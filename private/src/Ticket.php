<?php

namespace App;

use PDO;

class Ticket
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    public function create($userId, $subject, $message)
    {
        $stmt = $this->db->prepare("INSERT INTO tickets (user_id, subject, message) VALUES (?, ?, ?)");
        return $stmt->execute([$userId, $subject, $message]);
    }

    public function getByUser($userId)
    {
        $stmt = $this->db->prepare("SELECT * FROM tickets WHERE user_id = ? ORDER BY created_at DESC");
        $stmt->execute([$userId]);
        return $stmt->fetchAll();
    }

    public function getAll()
    {
        $stmt = $this->db->query("SELECT t.*, u.full_name, u.email FROM tickets t JOIN users u ON t.user_id = u.id ORDER BY t.created_at DESC");
        return $stmt->fetchAll();
    }

    public function updateStatus($id, $status)
    {
        $stmt = $this->db->prepare("UPDATE tickets SET status = ? WHERE id = ?");
        return $stmt->execute([$status, $id]);
    }

    public function getById($id)
    {
        $stmt = $this->db->prepare("SELECT t.*, u.full_name, u.email FROM tickets t JOIN users u ON t.user_id = u.id WHERE t.id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
}
