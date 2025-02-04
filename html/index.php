<?php
// Configuración de la base de datos
$host = 'db';
$port = '5432';
$dbname = 'tareas';
$user = 'postgres';
$password = 'postgres';

try {
    // Conexión PDO con PostgreSQL
    $pdo = new PDO("pgsql:host=$host;port=$port;dbname=$dbname", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Obtener todas las tareas
    $stmt = $pdo->query("SELECT * FROM tasks");
    $tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>


<head>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body style="background-color:LightGoldenrodYellow;">
</body>
<div class="d-flex justify-content-center">
<h1 style="color :blue;">Lista de Tareas</h1>
</div>
<a class="btn btn-primary" href="create.php" role="button">Crear Nueva Tarea</a>
<div> .</div>
<style>
  table{
	background-color:ligthblue;
}
</style>
<table class="table table-success table-striped">
    <thead>
        <tr>
            <th> ID </th>
            <th> Descripción </th>
            <th> Fecha </th>
            <th> Estado </th>
            <th> Acciones </th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($tasks as $task): ?>
            <tr>
                <td> <?php echo $task['id']; ?> </td>
                <td> <?php echo htmlspecialchars($task['descripcion']); ?> </td>
                <td> <?php echo htmlspecialchars($task['fecha']); ?> </td>
                <td> <?php echo htmlspecialchars($task['estado']); ?> </td>
                <td>
                    <a href="edit.php?id=<?php echo $task['id']; ?>">Editar</a> |
                    <a href="delete.php?id=<?php echo $task['id']; ?>" onclick="return confirm('¿Estás seguro de eliminar esta tarea?')">Eliminar</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

