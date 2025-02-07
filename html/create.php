<?php
/*
// Configuración de la base de datos
$host = 'db';
$port = '5432';
$dbname = 'tareas';
$user = 'postgres';
$password = 'postgres';
*/
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $descripcion = $_POST['descripcion'];
    $fecha = $_POST['fecha'];
    $estado = $_POST['estado'];
    $user_id = $_POST['user_id'];

	if (!empty($descripcion)&&!empty(estado)){
    	/*	try {
        		// Conexión PDO con PostgreSQL
        		$pdo = new PDO("pgsql:host=$host;port=$port;dbname=$dbname", $user, $password);
        		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
*/
        		// Insertar nueva tarea
        		$stmt = $pdo->prepare("INSERT INTO tasks (descripcion, fecha, estado, user_id) VALUES (:descripcion, :fecha, :estado, :user_id)");
        		$stmt->bindParam(':descripcion', $descripcion, PDO::PARAM_STR);
        		$stmt->bindParam(':fecha', $fecha, PDO::PARAM_STR);
        		$stmt->bindParam(':estado', $estado, PDO::PARAM_STR);
        		$stmt->bindParam(':user_id', $user_id, PDO::PARAM_STR);
			$stmt->execute();

        		// Redirigir al index
        		header("Location: index.php");
        		exit;
    	/*	} catch (PDOException $e) {
        		echo "Error: " . $e->getMessage();
    		}*/
	}else header("Location: index.php");
}
?>

<head>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

</head>
<body style="background-color:LightGoldenrodYellow;">
</body>



<div class="container mb-4 mt-4">
<div class="d-flex justify-content-center">
<h1 style= "color:blue">Crear Tarea</h1>
</div>
<br>

<form method="POST">

	<div class="card text-bg-secondary mb-3">
		<div class="card-body">
			<div class="mb-3">
    				<label for="descripcion" class="form-label">Descripción:</label>
    				<input type="text" class="form-control" id="descripcion" name="descripcion"><br>
			</div>
			<div class="mb-3">
    				<label for="fecha" class="form-label">Fecha:</label>
    				<input type="date" class="form-control" id="fecha" name="fecha"><br>
			</div>
			<div class="mb-3">
				<label for="estado" class="form-label">Estado:</label>
    				<input type="text" class="form-control" id="estado" name="estado"><br>
			</div>
			<div>
				<label for="usuario" class="form-label">Usuario:</label>
				<select name="user_id">
					<?php foreach ($users as $user): ?>
						<option value="<?= $user['id'] ?>"><?= $user['nombre'] ?></option>
					<?php endforeach; ?>
				</select>
			</div>
    			<input type="submit" class="btn btn-success"value="Crear Tarea">
			<input type="submit" class="btn btn-danger btn-sm" href="index.php" value="Volver">
		</div>
	</div>
</form>
</div>
