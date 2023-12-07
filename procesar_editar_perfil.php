<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id"];
    $profile_name = $_POST["profile_name"];
    $description = $_POST["description"];
    $status = $_POST["status"];

    // Conectarse a la base de datos
    $servidor = "localhost";
    $usuario = "root";
    $contrasena = "";
    $baseDeDatos = "TiendaDisfraces";
    $tabla = "user_profiles";

    $conn = mysqli_connect($servidor, $usuario, $contrasena, $baseDeDatos);

    if (!$conn) {
        die("La conexión a la base de datos ha fallado: " . mysqli_connect_error());
    }

    // Consulta para actualizar el perfil con el ID proporcionado
    $sql = "UPDATE $tabla SET profile_name = '$profile_name', description = '$description', status = '$status' WHERE id = $id";

    if (mysqli_query($conn, $sql)) {
        // Redireccionar a la vista de perfil después de la actualización
        header("Location: Perfil.php");
        exit();
    } else {
        echo "Error al actualizar el perfil: " . mysqli_error($conn);
    }

    mysqli_close($conn);
} else {
    echo "Acceso no válido.";
}
?>
