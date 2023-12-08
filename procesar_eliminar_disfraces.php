<?php
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["id"])) {
    $id = $_GET["id"];

    $servidor = "localhost";
    $usuario = "root";
    $contrasena = "";
    $baseDeDatos = "TiendaDisfraces";
    $tabla = "costumes";

    $conn = mysqli_connect($servidor, $usuario, $contrasena, $baseDeDatos);

    // Obtén el id del disfraz antes de eliminarlo
    $sqlGetDisfrazId = "SELECT id FROM $tabla WHERE id = $id";
    $resultGetDisfrazId = mysqli_query($conn, $sqlGetDisfrazId);

    if (!$resultGetDisfrazId) {
        http_response_code(500);
        echo json_encode(['error' => 'Error al obtener el ID del disfraz']);
        exit;
    }

    $row = mysqli_fetch_assoc($resultGetDisfrazId);
    $disfrazId = $row['id'];

    // Elimina los comentarios asociados al disfraz
    $sqlDeleteTransactions = "DELETE FROM transactions WHERE costume_id = $disfrazId";
$resultDeleteTransactions = mysqli_query($conn, $sqlDeleteTransactions);

if (!$resultDeleteTransactions) {
    http_response_code(500);
    echo json_encode(['error' => 'Error al eliminar transacciones asociadas']);
    exit;
}

    // Elimina el disfraz
    $sql = "DELETE FROM $tabla WHERE id = $id";

    if (mysqli_query($conn, $sql)) {
        header("Location: Disfraces.php");
        exit();
    } else {
        echo "Error al eliminar el disfraz: " . mysqli_error($conn);
    }

    mysqli_close($conn);
} else {
    echo "Acceso no válido.";
}
?>
