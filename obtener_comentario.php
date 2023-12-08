<?php
if (!isset($_GET['disfraz_id'])) {
    http_response_code(400);
    echo json_encode(['error' => 'ID de disfraz no proporcionado']);
    exit;
}

$disfrazId = $_GET['disfraz_id'];

// Realizar la conexión a la base de datos (ajusta estos datos según tu configuración)
$servidor = "localhost";
$usuario = "root";
$contrasena = "";
$baseDeDatos = "TiendaDisfraces";

$conn = mysqli_connect($servidor, $usuario, $contrasena, $baseDeDatos);

if (!$conn) {
    http_response_code(500);
    echo json_encode(['error' => 'Error al conectar con la base de datos']);
    exit;
}

// Consulta para obtener los comentarios asociados al disfraz
$sql = "SELECT * FROM costume_comments WHERE costume_id = $disfrazId";
$result = mysqli_query($conn, $sql);

if (!$result) {
    http_response_code(500);
    echo json_encode(['error' => 'Error al ejecutar la consulta']);
    exit;
}

// Obtener los comentarios y devolverlos en formato JSON
$comentarios = [];
while ($fila = mysqli_fetch_assoc($result)) {
    $comentarios[] = $fila;
}

header('Content-Type: application/json');
echo json_encode($comentarios);

// Cerrar la conexión a la base de datos
mysqli_close($conn);
?>
