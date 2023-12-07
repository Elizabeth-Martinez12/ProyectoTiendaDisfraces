<?php
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["id"])) {
    $id = $_GET["id"];

    
    $servidor = "localhost";
    $usuario = "root";
    $contrasena = "";
    $baseDeDatos = "TiendaDisfraces";
    $tabla = "user_info";

    $conn = mysqli_connect($servidor, $usuario, $contrasena, $baseDeDatos);

    if (!$conn) {
        die("La conexión a la base de datos ha fallado: " . mysqli_connect_error());
    }

    // Consulta para eliminar el perfil con el ID proporcionado
    $sql = "DELETE FROM $tabla WHERE id = $id";

    if (mysqli_query($conn, $sql)) {
        // Redireccionar a la vista de perfil después de eliminar
        header("Location: Informacion.php");
        exit();
    } else {
        echo "Error al eliminar el informacion: " . mysqli_error($conn);
    }

    mysqli_close($conn);
} else {
    echo "Acceso no válido.";
}
?>
