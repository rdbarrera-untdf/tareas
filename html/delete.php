<?php
// Configuración de la base de datos
$host = 'db';
$port = '5432';
$dbname = 'tareas';
$user = 'postgres';
$password = 'postgres';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    try {
        // Conexión PDO con PostgreSQL
        $pdo = new PDO("pgsql:host=$host;port=$port;dbname=$dbname", $user, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Eliminar tarea
        $stmt = $pdo->prepare("DELETE FROM tasks WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        // Redirigir al index
        header("Location: index.php");
        exit;
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
