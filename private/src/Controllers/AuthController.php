<?php

namespace App\Controllers;

use App\Auth;
use App\CSRF;
use function App\flash;

class AuthController extends Controller
{
    private $auth;

    public function __construct()
    {
        $this->auth = new Auth();
    }

    public function loginForm()
    {
        if (Auth::check()) {
            $this->redirect('/dashboard');
        }
        $this->view('auth/login');
    }

    public function registerForm()
    {
        if (Auth::check()) {
            $this->redirect('/dashboard');
        }
        $this->view('auth/register');
    }

    public function login()
    {
        if (!CSRF::validate($_POST['csrf_token'] ?? '')) {
            flash('error', 'Token de seguridad inválido.');
            $this->redirect('/login');
        }

        $result = $this->auth->login($_POST['email'], $_POST['password']);

        if ($result['success']) {
            if ($result['user']['role'] === 'admin') {
                $this->redirect('/admin/dashboard');
            } else {
                $this->redirect('/client/dashboard');
            }
        } else {
            flash('error', $result['message']);
            $this->redirect('/login');
        }
    }

    public function register()
    {
        if (!CSRF::validate($_POST['csrf_token'] ?? '')) {
            flash('error', 'Token de seguridad inválido.');
            $this->redirect('/register');
        }

        $result = $this->auth->register(
            $_POST['full_name'],
            $_POST['email'],
            $_POST['phone'],
            $_POST['password']
        );

        if ($result['success']) {
            flash('success', $result['message']);
            $this->redirect('/login');
        } else {
            flash('error', $result['message']);
            $this->redirect('/register');
        }
    }

    public function logout()
    {
        $this->auth->logout();
        $this->redirect('/login');
    }

    public function forgotPasswordForm()
    {
        $this->view('auth/forgot_password');
    }

    public function forgotPassword()
    {
        // Mock implementation
        $email = $_POST['email'];
        // Generate token, save to DB, send email
        // ...
        flash('success', 'Si el correo existe, recibirás un enlace de recuperación.');
        $this->redirect('/login');
    }

    public function googleRedirect()
    {
        // Mock redirection to Google
        // In production: $client->createAuthUrl();
        $this->redirect('/auth/google/callback?code=mock_code');
    }

    public function googleCallback()
    {
        // Mock handling of Google callback
        // In production: exchange code for token, get user info

        // Simulating successful login with a mock user
        $mockEmail = 'google_user@example.com';
        $mockName = 'Google User';
        $mockGoogleId = '123456789';

        // Check if user exists, if not create
        $db = \App\Database::getInstance()->getConnection();
        $stmt = $db->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$mockEmail]);
        $user = $stmt->fetch();

        if (!$user) {
            $stmt = $db->prepare("INSERT INTO users (full_name, email, google_id, role, password_hash) VALUES (?, ?, ?, 'client', '')");
            $stmt->execute([$mockName, $mockEmail, $mockGoogleId]);
            $userId = $db->lastInsertId();
            $role = 'client';
        } else {
            $userId = $user['id'];
            $role = $user['role'];
            // Update google_id if missing
            if (empty($user['google_id'])) {
                $stmt = $db->prepare("UPDATE users SET google_id = ? WHERE id = ?");
                $stmt->execute([$mockGoogleId, $userId]);
            }
        }

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $_SESSION['user_id'] = $userId;
        $_SESSION['user_role'] = $role;
        $_SESSION['user_name'] = $mockName;

        $this->redirect('/client/dashboard');
    }
}
