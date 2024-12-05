<?php
require_once 'config.php';
header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);

if (!$data) {
    echo json_encode(['success' => false, 'message' => 'Неверные данные']);
    exit;
}

$username = $data['username'];
$email = $data['email'];
$password = password_hash($data['password'], PASSWORD_DEFAULT);

try {
    // Проверка существования email
    $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->execute([$email]);
    if ($stmt->rowCount() > 0) {
        echo json_encode(['success' => false, 'message' => 'Email уже зарегистрирован']);
        exit;
    }

    // Создание нового пользователя
    $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
    $stmt->execute([$username, $email, $password]);
    
    echo json_encode(['success' => true]);
} catch(PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Ошибка сервера']);
}
<?php
require_once 'config.php';
header('Content-Type: application/json');

// Включаем отображение ошибок для отладки
ini_set('display_errors', 1);
error_reporting(E_ALL);

$data = json_decode(file_get_contents('php://input'), true);

// Проверка входных данных
if (!$data || !isset($data['username']) || !isset($data['email']) || !isset($data['password'])) {
    echo json_encode(['success' => false, 'message' => 'Неполные данные формы']);
    exit;
}

$username = trim($data['username']);
$email = trim($data['email']);
$password = $data['password'];

// Базовая валидация
if (strlen($username) < 3) {
    echo json_encode(['success' => false, 'message' => 'Имя пользователя должно быть не менее 3 символов']);
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['success' => false, 'message' => 'Некорректный email']);
    exit;
}

if (strlen($password) < 6) {
    echo json_encode(['success' => false, 'message' => 'Пароль должен быть не менее 6 символов']);
    exit;
}

try {
    // Проверка существования email
    $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->execute([$email]);
    if ($stmt->rowCount() > 0) {
        echo json_encode(['success' => false, 'message' => 'Email уже зарегистрирован']);
        exit;
    }

    // Проверка существования username
    $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ?");
    $stmt->execute([$username]);
    if ($stmt->rowCount() > 0) {
        echo json_encode(['success' => false, 'message' => 'Имя пользователя уже занято']);
        exit;
    }

    // Создание нового пользователя
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
    $stmt->execute([$username, $email, $hashedPassword]);
    
    echo json_encode(['success' => true, 'message' => 'Регистрация успешна']);
} catch(PDOException $e) {
    error_log("Ошибка базы данных: " . $e->getMessage());
    echo json_encode(['success' => false, 'message' => 'Ошибка сервера: ' . $e->getMessage()]);
}