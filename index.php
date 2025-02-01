<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
define('ROOT_PATH', dirname(__FILE__) . '/');

require_once ROOT_PATH . 'config/database.php';
require_once ROOT_PATH . 'controllers/TaskController.php';



$controller = new TaskController($pdo);

$requestUri = explode('?', $_SERVER['REQUEST_URI'], 2)[0];

// Vérifier si l'utilisateur est connecté pour toutes les routes sauf login/signup
if (!isset($_SESSION['id']) && !in_array($requestUri, ['/login', '/signup'])) {
    header('Location: /login');
    exit;
}

if ($requestUri === '/') {
    $controller->index();
} elseif ($requestUri === '/add') {
    $controller->add();
} elseif (preg_match('/\/edit\/(\d+)/', $requestUri, $matches)) {
    $controller->edit($matches[1]);
} elseif (preg_match('/\/delete\/(\d+)/', $requestUri, $matches)) {
    $controller->delete($matches[1]);
} elseif ($requestUri === '/login') {
    $controller->login();
} elseif ($requestUri === '/signup') {
    $controller->signup();
} elseif ($requestUri === '/logout') {
    $controller->logout();
} else {
    http_response_code(404);
    echo "Page not found.";
}
