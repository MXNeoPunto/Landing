<?php
require_once '../config/db.php';
require_once '../includes/security.php';

check_auth();

if (!in_array($_SESSION['rol'], ['admin', 'admin_principal', 'admin_secundario'])) {
    header('Location: cliente.php');
    exit();
}

$r2Config = $pdo->query("SELECT r2_access_key, r2_secret_key, r2_endpoint, r2_bucket, r2_public_url FROM config_general WHERE id = 1")->fetch();

if (empty($r2Config['r2_access_key']) || empty($r2Config['r2_secret_key']) || empty($r2Config['r2_endpoint']) || empty($r2Config['r2_bucket'])) {
    $_SESSION['error_msg'] = "Debes configurar Cloudflare R2 primero.";
    header('Location: admin.php');
    exit();
}

// Function to sign R2 requests
function signR2Request($access_key, $secret_key, $endpoint, $bucket, $method, $path, $query = '') {
    $timestamp = gmdate('Ymd\THis\Z');
    $date = gmdate('Ymd');
    $region = 'auto';
    $service = 's3';

    $parsed_url = parse_url($endpoint);
    $host = $parsed_url['host'];

    $payload_hash = hash('sha256', '');

    $canonical_headers = [
        "host:" . $host,
        "x-amz-content-sha256:" . $payload_hash,
        "x-amz-date:" . $timestamp
    ];
    sort($canonical_headers);
    $signed_headers_str = "host;x-amz-content-sha256;x-amz-date";

    $canonical_request = "$method\n$path\n$query\n" . implode("\n", $canonical_headers) . "\n\n$signed_headers_str\n$payload_hash";

    $credential_scope = "$date/$region/$service/aws4_request";
    $string_to_sign = "AWS4-HMAC-SHA256\n$timestamp\n$credential_scope\n" . hash('sha256', $canonical_request);

    $kSecret = 'AWS4' . $secret_key;
    $kDate = hash_hmac('sha256', $date, $kSecret, true);
    $kRegion = hash_hmac('sha256', $region, $kDate, true);
    $kService = hash_hmac('sha256', $service, $kRegion, true);
    $kSigning = hash_hmac('sha256', 'aws4_request', $kService, true);
    $signature = hash_hmac('sha256', $string_to_sign, $kSigning);

    return [
        "x-amz-date: $timestamp",
        "x-amz-content-sha256: $payload_hash",
        "Authorization: AWS4-HMAC-SHA256 Credential=$access_key/$credential_scope, SignedHeaders=$signed_headers_str, Signature=$signature"
    ];
}

$files = [];
$error = null;

// Filter logic (age)
$ageFilter = isset($_GET['age']) ? (int)$_GET['age'] : 0; // 0 = all, 3 = 3 months, 4 = 4 months

try {
    $path = '/' . $r2Config['r2_bucket'];
    $url = rtrim($r2Config['r2_endpoint'], '/') . $path . "?list-type=2";

    $headers = signR2Request($r2Config['r2_access_key'], $r2Config['r2_secret_key'], $r2Config['r2_endpoint'], $r2Config['r2_bucket'], 'GET', $path, 'list-type=2');

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);

    $response = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($http_code == 200) {
        $xml = simplexml_load_string($response);
        if ($xml && isset($xml->Contents)) {
            $cutoffDate = null;
            if ($ageFilter > 0) {
                $cutoffDate = new DateTime("-$ageFilter months");
            }

            foreach ($xml->Contents as $item) {
                $lastModified = new DateTime((string)$item->LastModified);

                if ($cutoffDate && $lastModified > $cutoffDate) {
                    continue; // Skip newer files if we only want files older than X months
                }

                $size = (int)$item->Size;
                // Format size
                if ($size >= 1048576) $sizeStr = number_format($size / 1048576, 2) . ' MB';
                elseif ($size >= 1024) $sizeStr = number_format($size / 1024, 2) . ' KB';
                else $sizeStr = $size . ' bytes';

                $key = (string)$item->Key;
                $publicUrl = !empty($r2Config['r2_public_url']) ? rtrim($r2Config['r2_public_url'], '/') . '/' . $key : '#';

                $files[] = [
                    'key' => $key,
                    'size' => $sizeStr,
                    'date' => $lastModified->format('d/m/Y H:i'),
                    'url' => $publicUrl
                ];
            }
        }
    } else {
        $error = "Error al conectar con R2. HTTP Code: $http_code. Verifica tus credenciales.";
    }
} catch (Exception $e) {
    $error = "Excepción: " . $e->getMessage();
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestor Cloudflare R2 - NeoPunto</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50 min-h-screen">

<nav class="bg-white border-b border-gray-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">
            <div class="flex items-center">
                <a href="admin.php" class="text-blue-600 hover:text-blue-800 flex items-center gap-2 font-medium">
                    <i class="fa-solid fa-arrow-left"></i> Volver a Panel
                </a>
                <span class="ml-4 text-xl font-bold tracking-tight text-gray-800">Archivos Cloudflare R2</span>
            </div>
        </div>
    </div>
</nav>

<main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-6">

    <?php if($error): ?>
        <div class="bg-red-50 border border-red-200 text-red-800 rounded-xl p-4 flex items-center shadow-sm">
            <i class="fa-solid fa-triangle-exclamation mr-3 text-red-500"></i> <?php echo htmlspecialchars($error); ?>
        </div>
    <?php endif; ?>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex flex-col sm:flex-row justify-between items-center gap-4">
        <div>
            <h2 class="text-lg font-semibold text-gray-800">Filtros de Antigüedad</h2>
            <p class="text-sm text-gray-500">Muestra archivos que tengan al menos X meses de antigüedad.</p>
        </div>
        <form method="GET" class="flex items-center gap-2">
            <select name="age" class="block w-48 rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm py-2 px-3 bg-gray-50">
                <option value="0" <?php echo $ageFilter == 0 ? 'selected' : ''; ?>>Todos los archivos</option>
                <option value="3" <?php echo $ageFilter == 3 ? 'selected' : ''; ?>>Más de 3 meses</option>
                <option value="4" <?php echo $ageFilter == 4 ? 'selected' : ''; ?>>Más de 4 meses</option>
                <option value="6" <?php echo $ageFilter == 6 ? 'selected' : ''; ?>>Más de 6 meses</option>
            </select>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-blue-700 transition shadow-sm">Filtrar</button>
        </form>
    </div>

    <div class="bg-white shadow-sm border border-gray-100 rounded-2xl overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre del Archivo</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tamaño</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha Subida</th>
                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-100">
                <?php if (empty($files) && !$error): ?>
                <tr>
                    <td colspan="4" class="px-6 py-12 text-center text-gray-500">No se encontraron archivos en este bucket que coincidan con los filtros.</td>
                </tr>
                <?php else: ?>
                    <?php foreach($files as $f): ?>
                    <tr class="hover:bg-gray-50 transition-colors group">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <i class="fa-solid fa-file text-gray-400 mr-3 text-lg"></i>
                                <span class="text-sm font-medium text-gray-900 truncate max-w-xs" title="<?php echo htmlspecialchars($f['key']); ?>">
                                    <?php echo htmlspecialchars($f['key']); ?>
                                </span>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            <span class="bg-gray-100 px-2 py-1 rounded text-xs font-medium"><?php echo $f['size']; ?></span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            <i class="fa-regular fa-clock mr-1 opacity-70"></i> <?php echo $f['date']; ?>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <?php if ($f['url'] !== '#'): ?>
                            <a href="<?php echo htmlspecialchars($f['url']); ?>" target="_blank" class="text-blue-600 hover:text-blue-900 bg-blue-50 px-3 py-1.5 rounded-lg mr-2 inline-flex items-center gap-1">
                                <i class="fa-solid fa-arrow-up-right-from-square text-xs"></i> Abrir
                            </a>
                            <?php endif; ?>
                            <!-- Delete action would need another curl DELETE request to API, out of scope but icon left for UI -->
                            <button disabled class="text-gray-400 cursor-not-allowed hover:text-gray-500" title="Eliminar (No implementado)">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</main>

</body>
</html>
