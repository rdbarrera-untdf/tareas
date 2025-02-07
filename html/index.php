<?php
include 'db.php';
/*
// Configuración de la base de datos
$host = 'db';
$port = '5432';
$dbname = 'tareas';
$user = 'postgres';
$password = 'postgres';

try {
    // Conexión PDO con PostgreSQL
    $pdo = new PDO("pgsql:host=$host;port=$port;dbname=$dbname", $user, $password,[PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC]);

// $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
*/

    //capturar filtro
	$descripcion_filtro= $_GET['descripcion'] ?? '';
	$fecha_inicio= $_GET['fecha_inicio'] ?? '';
	$fecha_fin=$GET['fecha_fin'] ?? '';
	$estado_filtro=$_GET['estado'] ?? '';
	$user_id_filtro=$_GET['user_id'] ?? '';

    //hacer la consulta

	$query = "SELECT tasks.id, tasks.descripcion, tasks.fecha, tasks.estado, users.nombre as usuario FROM tasks LEFT JOIN users ON tasks.user_id = users.id"; // 1=1 permite agregar condiciones dinámicas WHERE 1=1
    	$params = [];


    if (!empty($descripcion_filtro)) {
        $query .= " AND descripcion ILIKE :descripcion";
        $params[':descripcion'] = "%$descripcion_filtro%";
    }

    if (!empty($fecha_inicio)) {
        $query .= " AND fecha >= :fecha_inicio";
        $params[':fecha_inicio'] = $fecha_inicio;
    }

    if (!empty($fecha_fin)) {
        $query .= " AND fecha <= :fecha_fin";
        $params[':fecha_fin'] = $fecha_fin;
    }
    if (!empty($estado_filtro)) {
	$query .=" AND estado ILIKE :estado";
	$params[':estado']="%$estado_filtro%";
    }
    if (!empty($user_id_filtro)){
	$query .= " AND user_id ILIKE : user_id";
	$params[':user_id']="%$user_id_filtro%";
    }
    // Ejecutar la consulta con los filtros
    $stmt = $pdo->prepare($query);
    $stmt->execute($params);
    $tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);


/*
    // Obtener todas las tareas
    $stmt = $pdo->query("SELECT * FROM tasks");
    $tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);
*/
/*
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
*/
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Tareas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body style="background-color:LightGoldenrodYellow;">
    <div class="container mt-4 mb-4">

        <div class="d-flex justify-content-center">
            <h1 style="color :blue;">Lista de Tareas</h1>
        </div>

        <!-- Formulario de búsqueda -->
        <form method="GET" class="row align-items-start">
            <div class="row justify-content-start">
                <div class="col">
                    <label for="descripcion" class="form-label">Buscar por descripción:</label>
                    <input type="text" class="form-control" id="descripcion" name="descripcion" value="<?php echo htmlspecialchars($descripcion_filtro); ?>">

		 </div>
		 <div class="col">
		    <label for="estado" class="form-label">Buscar por estado:</label>
		    <input type="text" class="form-control" id="estado" name="estado" value="<?php echo htmlspecialchars($estado_filtro); ?>">
		</div>
	    </div>
	    <div class="row justify-content-start">
               	<div class="col">
                    <label for="fecha_inicio" class="form-label">Fecha inicio:</label>
                    <input type="date" class="form-control" id="fecha_inicio" name="fecha_inicio" value="<?php echo htmlspecialchars($fecha_inicio); ?>">
                </div>
                <div class="col">
                    <label for="fecha_fin" class="form-label">Fecha fin:</label>
                    <input type="date" class="form-control" id="fecha_fin" name="fecha_fin" value="<?php echo htmlspecialchars($fecha_fin); ?>">
                </div>
		<div class="col">
		   <label for="usuario" class="form-label">Usuario:</label>
		   <select name="user_id">
			<?php foreach ($users as $user): ?>
				<option value="<?=$user[id] ?>"><?= $user['nombre'] ?></option>
			<?php endforeach; ?>
		   </select>
		</div>
	    </div>

            <div class="row align-items-center"> <!--  d-flex align-items-end -->
	    	<div class="col">
			<button type="submit" class="btn btn-outline-primary">Filtrar</button>
		</div>
	   	<div class="col">
			<a href="index.php" class="btn btn-outline-danger">Borrar</a>
		</div>
            </div>
        </form>
<br>
<br>
        <!-- Botón para crear nueva tarea -->
	<div class="row justify-content-end">
		<div class="col-4">
			<a class="btn btn-success mb-4" href="create.php" role="button">Crear Nueva Tarea</a>
		</div>
	</div>
        <table class="table table-success table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Descripción</th>
                    <th>Fecha</th>
                    <th>Estado</th>
		    <th>Usuario</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($tasks as $task): ?>
                    <tr>
                        <td><?php echo $task['id']; ?></td>
                        <td><?php echo htmlspecialchars($task['descripcion']); ?></td>
                        <td><?php echo htmlspecialchars($task['fecha']); ?></td>
                        <td><?php echo htmlspecialchars($task['estado']); ?></td>
                        <td><?php echo htmlspecialchars($task['usuario']); ?></td>
			<td>
                            <a href="edit.php?id=<?php echo $task['id']; ?>" class="btn btn-outline-info btn-sm">Editar</a>
                            <a href="delete.php?id=<?php echo $task['id']; ?>" class="btn btn-outline-danger btn-sm" onclick="return confirm('¿Estás seguro de eliminar esta tarea?')">Eliminar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

    </div>
</body>
</html>

