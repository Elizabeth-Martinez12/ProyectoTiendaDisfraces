<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $servidor = "localhost";
    $usuario = "root";
    $contrasena = "";
    $baseDeDatos = "TiendaDisfraces";
    $tabla = "users";

    $conn = mysqli_connect($servidor, $usuario, $contrasena, $baseDeDatos);

    if (!$conn) {
        die("La conexión a la base de datos ha fallado: " . mysqli_connect_error());
    }

    $username = $_POST["username"];
    $password = $_POST["password"];
    $status = $_POST["status"];
    $profile_id = $_POST["profile_id"];

    $sql = "INSERT INTO $tabla (username, password, status, profile_id) VALUES ('$username', '$password', '$status', '$profile_id')";

    if (mysqli_query($conn, $sql)) {
        echo "Usuario agregado exitosamente.";
    } else {
        echo "Error al agregar usuario: " . mysqli_error($conn);
    }

    mysqli_close($conn);
} else {
    echo "Acceso no autorizado.";
}

header("Location: Usuarios.php");
exit();
?>
