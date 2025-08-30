 
<?php

header('Content-Type: application/json');

$name = isset($_POST['nombre']) ? trim($_POST['nombre']) : '';
$email = isset($_POST['email']) ? trim($_POST['email']) : '';
$message = isset($_POST['mensaje']) ? trim($_POST['mensaje']) : '';

if (empty($name) || empty($email)) {
    echo json_encode(['success' => false, 'message' => 'El nombre y el correo electrónico son campos obligatorios.']);
    exit;
}

$db_file = __DIR__ . '/contacts.db';

try {
    $pdo = new PDO('sqlite:' . $db_file);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS contacts (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            name TEXT NOT NULL,
            email TEXT NOT NULL,
            message TEXT,
            submission_date DATETIME DEFAULT CURRENT_TIMESTAMP
        );
    ");

    $stmt = $pdo->prepare("INSERT INTO contacts (name, email, message) VALUES (?, ?, ?)");
    $stmt->execute([$name, $email, $message]);

    echo json_encode(['success' => true, 'message' => 'Registro guardado con éxito.']);

} catch (PDOException $e) {

    echo json_encode(['success' => false, 'message' => 'Error de base de datos: ' . $e->getMessage()]);
}

?>
