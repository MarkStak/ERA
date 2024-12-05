<?php
require_once 'config.php';
header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);

if (!$data) {
    echo json_encode(['success' => false, 'message' => 'Неверные данные']);
    exit;
}

$email = $data['email'];
$password = $data['password'];

try {
    $stmt = $pdo->prepare("SELECT id, password FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        session_start();
        $_SESSION['user_id'] = $user['id'];
        
        echo json_encode([
            'success' => true,
            'token' => bin2hex(random_bytes(32))
        ]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Неверный email или пароль']);
    }
} catch(PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Ошибка сервера']);
}