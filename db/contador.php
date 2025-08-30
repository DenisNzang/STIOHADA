<?php
header('Content-Type: text/plain');

try {
    // Conectar a la base de datos SQLite
    $db = new PDO('sqlite:contacts.db');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Obtener el contador actual
    $stmt = $db->query("SELECT count FROM visits WHERE id = 1");
    $contador = $stmt->fetchColumn();

    // Incrementar el contador
    $contador++;
    $stmt = $db->prepare("UPDATE visits SET count = ? WHERE id = 1");
    $stmt->execute([$contador]);

    // Devolver el nuevo valor
    echo $contador;

} catch(PDOException $e) {
    // En caso de error, devolver un valor por defecto
    echo "N/D";
    error_log("Error en contador.php: " . $e->getMessage());
}
?>
