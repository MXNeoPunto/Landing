<?php

require_once __DIR__ . '/../private/vendor/autoload.php';

use App\Router;
use App\Controllers\HomeController;
use App\Controllers\AuthController;
use App\Controllers\AdminController;
use App\Controllers\ClientController;

$router = new Router();

// Public Routes
$router->get('/', [HomeController::class, 'index']);
$router->get('/login', [AuthController::class, 'loginForm']);
$router->post('/login', [AuthController::class, 'login']);
$router->get('/register', [AuthController::class, 'registerForm']);
$router->post('/register', [AuthController::class, 'register']);
$router->get('/logout', [AuthController::class, 'logout']);
$router->get('/forgot-password', [AuthController::class, 'forgotPasswordForm']);
$router->post('/forgot-password', [AuthController::class, 'forgotPassword']);
$router->get('/auth/google', [AuthController::class, 'googleRedirect']);
$router->get('/auth/google/callback', [AuthController::class, 'googleCallback']);

// Admin Routes
$router->get('/admin/dashboard', [AdminController::class, 'dashboard']);
$router->get('/admin/services', [AdminController::class, 'services']);
$router->post('/admin/services/create', [AdminController::class, 'createService']);
$router->post('/admin/services/delete', [AdminController::class, 'deleteService']);
$router->post('/admin/services/update', [AdminController::class, 'updateService']);
$router->get('/admin/orders', [AdminController::class, 'orders']);
$router->post('/admin/orders/update', [AdminController::class, 'updateOrderStatus']);
$router->get('/admin/users', [AdminController::class, 'users']);
$router->post('/admin/users/role', [AdminController::class, 'updateUserRole']);
$router->get('/admin/settings', [AdminController::class, 'settings']);
$router->post('/admin/settings/update', [AdminController::class, 'updateSettings']); // Need to implement method

// Client Routes
$router->get('/client/dashboard', [ClientController::class, 'dashboard']);
$router->get('/client/orders', [ClientController::class, 'orders']);
$router->post('/client/orders/create', [ClientController::class, 'createOrder']);
$router->post('/client/orders/pay', [ClientController::class, 'pay']);
$router->get('/client/tickets', [ClientController::class, 'tickets']);
$router->post('/client/tickets/create', [ClientController::class, 'createTicket']);

// Dispatch
$router->dispatch($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);
