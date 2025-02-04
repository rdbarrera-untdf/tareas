<?php
// Configuración de la base de datos
$host = 'db';
$port = '5432';
$dbname = 'tareas';
$user = 'postgres';
$password = 'postgres';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $descripcion = $_POST['descripcion'];
    $fecha = $_POST['fecha'];
    $estado = $_POST['estado'];

    try {
        // Conexión PDO con PostgreSQL
        $pdo = new PDO("pgsql:host=$host;port=$port;dbname=$dbname", $user, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Insertar nueva tarea
        $stmt = $pdo->prepare("INSERT INTO tasks (descripcion, fecha, estado) VALUES (:descripcion, :fecha, :estado)");
        $stmt->bindParam(':descripcion', $descripcion, PDO::PARAM_STR);
        $stmt->bindParam(':fecha', $fecha, PDO::PARAM_STR);
        $stmt->bindParam(':estado', $estado, PDO::PARAM_STR);
        $stmt->execute();

        // Redirigir al index
        header("Location: index.php");
        exit;
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>

<h1>Crear Nueva Tarea</h1>
<form method="POST">
    <label for="descripcion">Descripción:</label>
    <input type="text" id="descripcion" name="descripcion" required><br>

    <label for="fecha">Fecha:</label>
    <input type="text" id="fecha" name="fecha" required><br>

    <label for="estado">Estado:</label>
    <input type="text" id="estado" name="estado" required><br>

    <input type="submit" value="Crear Tarea">
</form>
