<?php

namespace App\Controllers;

use App\Auth;
use App\Database;
use App\Ticket;
use App\Payment;
use App\CSRF;
use function App\flash;

class ClientController extends Controller
{
    private $db;
    private $userId;

    public function __construct()
    {
        if (!Auth::check()) {
            $this->redirect('/login');
        }
        $this->db = Database::getInstance()->getConnection();
        $this->userId = $_SESSION['user_id'];
    }

    public function dashboard()
    {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM orders WHERE user_id = ?");
        $stmt->execute([$this->userId]);
        $ordersCount = $stmt->fetchColumn();

        $stmt = $this->db->prepare("SELECT * FROM services WHERE active = 1");
        $stmt->execute();
        $services = $stmt->fetchAll();

        $this->view('client/dashboard', ['ordersCount' => $ordersCount, 'services' => $services]);
    }

    public function orders()
    {
        $stmt = $this->db->prepare("SELECT o.*, s.name as service_name FROM orders o JOIN services s ON o.service_id = s.id WHERE user_id = ? ORDER BY o.created_at DESC");
        $stmt->execute([$this->userId]);
        $orders = $stmt->fetchAll();
        $this->view('client/orders', ['orders' => $orders]);
    }

    public function createOrder()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!CSRF::validate($_POST['csrf_token'] ?? '')) {
                flash('error', 'Token de seguridad inválido.');
                $this->redirect('/client/dashboard');
            }

            $serviceId = $_POST['service_id'];

            // Get service price
            $stmt = $this->db->prepare("SELECT price FROM services WHERE id = ?");
            $stmt->execute([$serviceId]);
            $price = $stmt->fetchColumn();

            $stmt = $this->db->prepare("INSERT INTO orders (user_id, service_id, total_amount, status) VALUES (?, ?, ?, 'pending')");
            $stmt->execute([$this->userId, $serviceId, $price]);

            $this->redirect('/client/orders');
        }
    }

    public function tickets()
    {
        $ticketModel = new Ticket();
        $tickets = $ticketModel->getByUser($this->userId);
        $this->view('client/tickets', ['tickets' => $tickets]);
    }

    public function createTicket()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!CSRF::validate($_POST['csrf_token'] ?? '')) {
                flash('error', 'Token de seguridad inválido.');
                $this->redirect('/client/tickets');
            }
            $ticketModel = new Ticket();
            $ticketModel->create($this->userId, $_POST['subject'], $_POST['message']);
            flash('success', 'Ticket creado correctamente.');
            $this->redirect('/client/tickets');
        }
    }

    public function pay()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!CSRF::validate($_POST['csrf_token'] ?? '')) {
                flash('error', 'Token de seguridad inválido.');
                $this->redirect('/client/orders');
            }

            $orderId = $_POST['order_id'];
            $method = $_POST['payment_method'];

            if ($method === 'n1co') {
                $payment = new Payment();

                $stmt = $this->db->prepare("SELECT u.email, o.total_amount FROM orders o JOIN users u ON o.user_id = u.id WHERE o.id = ?");
                $stmt->execute([$orderId]);
                $orderData = $stmt->fetch();

                $result = $payment->createN1coOrder($orderData['total_amount'], $orderId, $orderData['email']);

                if ($result['success']) {
                    $stmt = $this->db->prepare("INSERT INTO payments (order_id, method, transaction_id, status) VALUES (?, 'n1co', ?, 'pending')");
                    $stmt->execute([$orderId, $result['transaction_id']]);

                    $this->redirect($result['redirect_url']);
                }
            } elseif ($method === 'transfer') {
                $payment = new Payment();
                $result = $payment->processManualTransfer($_FILES['proof_image'], $orderId);
                if ($result['success']) {
                    $stmt = $this->db->prepare("INSERT INTO payments (order_id, method, proof_image, status) VALUES (?, 'transfer', ?, 'pending')");
                    $stmt->execute([$orderId, $result['file_path']]);

                    $stmt = $this->db->prepare("UPDATE orders SET status = 'processing' WHERE id = ?");
                    $stmt->execute([$orderId]);
                }
            }
            $this->redirect('/client/orders');
        }
    }
}
