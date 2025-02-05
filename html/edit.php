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

        // Obtener los datos de la tarea
        $stmt = $pdo->prepare("SELECT * FROM tasks WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $task = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $descripcion = $_POST['descripcion'];
            $fecha = $_POST['fecha'];
            $estado = $_POST['estado'];

            // Actualizar la tarea
            $stmt = $pdo->prepare("UPDATE tasks SET descripcion = :descripcion, fecha = :fecha, estado = :estado WHERE id = :id");
            $stmt->bindParam(':descripcion', $descripcion, PDO::PARAM_STR);
            $stmt->bindParam(':fecha', $fecha, PDO::PARAM_STR);
            $stmt->bindParam(':estado', $estado, PDO::PARAM_STR);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();

            // Redirigir a la lista de tareas
            header("Location: index.php");
            exit;
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>

<head>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

</head>
<body style="background-color:LightGoldenrodYellow;">
</body>



<div class="container mb-4 mt-4">
<div class="d-flex justify-content-center">
<h1 style= "color:blue">Editar Tarea</h1>
</div>

<form method="POST">
<div class="card text-bg-secondary mb-3">
<div class="card-body">
<div class="mb-3">
  <label for="descripcion" class="form-label">Descripcion</label>
  <input type="text" class="form-control" id="descripcion"  name="descripcion" value="<?php echo htmlspecialchars($task['descripcion']); ?>">
</div>
<div class="mb-3">
  <label for="fecha" class="form-label">Fecha</label>
  <input type="text" class="form-control" id="fecha"  name="fecha" value="<?php echo htmlspecialchars($task['fecha']); ?>">
</div>
<div class="mb-3">
  <label for="estado" class="form-label">Estado</label>
  <input type="text" class="form-control" id="estado"  name="estado" value="<?php echo htmlspecialchars($task['estado']); ?>">
</div>
<input type="submit" class="btn btn-primary" value="Actualizar Tarea">
<input type="submit" href="index.php" class="btn btn-primary btn-sm" value="Voler">

</div>
</div>
</form>
</div>
