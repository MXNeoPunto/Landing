<?php

namespace App\Controllers;

use App\Auth;
use App\Database;
use App\CSRF;
use function App\flash;

class AdminController extends Controller
{
    private $db;

    public function __construct()
    {
        if (!Auth::isAdmin()) {
            $this->redirect('/login');
        }
        $this->db = Database::getInstance()->getConnection();
    }

    public function dashboard()
    {
        // Fetch stats
        $stats = [
            'total_orders' => $this->db->query("SELECT COUNT(*) FROM orders")->fetchColumn(),
            'pending_orders' => $this->db->query("SELECT COUNT(*) FROM orders WHERE status = 'pending'")->fetchColumn(),
            'processing_orders' => $this->db->query("SELECT COUNT(*) FROM orders WHERE status = 'processing'")->fetchColumn(),
            'completed_orders' => $this->db->query("SELECT COUNT(*) FROM orders WHERE status = 'completed'")->fetchColumn(),
        ];

        $this->view('admin/dashboard', ['stats' => $stats]);
    }

    public function services()
    {
        $stmt = $this->db->query("SELECT * FROM services ORDER BY created_at DESC");
        $services = $stmt->fetchAll();
        $this->view('admin/services', ['services' => $services]);
    }

    public function createService()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!CSRF::validate($_POST['csrf_token'] ?? '')) {
                flash('error', 'Token de seguridad inválido.');
                $this->redirect('/admin/services');
            }
            $stmt = $this->db->prepare("INSERT INTO services (name, description, price) VALUES (?, ?, ?)");
            $stmt->execute([$_POST['name'], $_POST['description'], $_POST['price']]);
            flash('success', 'Servicio creado correctamente.');
            $this->redirect('/admin/services');
        }
    }

    public function deleteService()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!CSRF::validate($_POST['csrf_token'] ?? '')) {
                flash('error', 'Token de seguridad inválido.');
                $this->redirect('/admin/services');
            }
            $stmt = $this->db->prepare("DELETE FROM services WHERE id = ?");
            $stmt->execute([$_POST['service_id']]);
            flash('success', 'Servicio eliminado correctamente.');
            $this->redirect('/admin/services');
        }
    }

    public function updateService()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!CSRF::validate($_POST['csrf_token'] ?? '')) {
                flash('error', 'Token de seguridad inválido.');
                $this->redirect('/admin/services');
            }
            $stmt = $this->db->prepare("UPDATE services SET name = ?, description = ?, price = ?, active = ? WHERE id = ?");
            $stmt->execute([$_POST['name'], $_POST['description'], $_POST['price'], isset($_POST['active']) ? 1 : 0, $_POST['service_id']]);
            flash('success', 'Servicio actualizado correctamente.');
            $this->redirect('/admin/services');
        }
    }

    public function orders() {
        $stmt = $this->db->query("SELECT o.*, u.full_name, s.name as service_name FROM orders o JOIN users u ON o.user_id = u.id JOIN services s ON o.service_id = s.id ORDER BY o.created_at DESC");
        $orders = $stmt->fetchAll();
        $this->view('admin/orders', ['orders' => $orders]);
    }

    public function updateOrderStatus() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!CSRF::validate($_POST['csrf_token'] ?? '')) {
                flash('error', 'Token de seguridad inválido.');
                $this->redirect('/admin/orders');
            }
            $stmt = $this->db->prepare("UPDATE orders SET status = ? WHERE id = ?");
            $stmt->execute([$_POST['status'], $_POST['order_id']]);
            flash('success', 'Estado del pedido actualizado.');
            $this->redirect('/admin/orders');
        }
    }

    public function settings()
    {
        $stmt = $this->db->query("SELECT * FROM settings");
        $settingsRaw = $stmt->fetchAll();
        $settings = [];
        foreach($settingsRaw as $s) {
            $settings[$s['setting_key']] = $s['setting_value'];
        }

        $this->view('admin/settings', ['settings' => $settings]);
    }

    public function updateSettings() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!CSRF::validate($_POST['csrf_token'] ?? '')) {
                flash('error', 'Token de seguridad inválido.');
                $this->redirect('/admin/settings');
            }
            foreach ($_POST as $key => $value) {
                if ($key === 'csrf_token') continue;
                // Upsert settings
                $stmt = $this->db->prepare("INSERT INTO settings (setting_key, setting_value) VALUES (?, ?) ON DUPLICATE KEY UPDATE setting_value = VALUES(setting_value)");
                $stmt->execute([$key, $value]);
            }
            flash('success', 'Ajustes guardados correctamente.');
            $this->redirect('/admin/settings');
        }
    }

    public function users() {
        $stmt = $this->db->query("SELECT * FROM users ORDER BY created_at DESC");
        $users = $stmt->fetchAll();
        $this->view('admin/users', ['users' => $users]);
    }

    public function updateUserRole() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!CSRF::validate($_POST['csrf_token'] ?? '')) {
                flash('error', 'Token de seguridad inválido.');
                $this->redirect('/admin/users');
            }
            $userId = $_POST['user_id'];
            $newRole = $_POST['role'];
            $stmt = $this->db->prepare("UPDATE users SET role = ? WHERE id = ?");
            $stmt->execute([$newRole, $userId]);
            flash('success', 'Rol de usuario actualizado.');
            $this->redirect('/admin/users');
        }
    }
}
