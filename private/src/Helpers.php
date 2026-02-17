<?php

namespace App;

function view($name, $data = [])
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    $data['csrf_token'] = CSRF::generate();
    $data['csrf_input'] = CSRF::input();
    extract($data);
    require __DIR__ . '/../../private/views/' . $name . '.php';
}

function redirect($url)
{
    header("Location: $url");
    exit;
}

function json_response($data, $status = 200)
{
    header('Content-Type: application/json');
    http_response_code($status);
    echo json_encode($data);
    exit;
}

function flash($key, $message = null)
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    if ($message) {
        $_SESSION['flash'][$key] = $message;
    } else {
        $msg = $_SESSION['flash'][$key] ?? null;
        unset($_SESSION['flash'][$key]);
        return $msg;
    }
}
