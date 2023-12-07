<?php

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $servidor = "localhost";
    $usuario = "root";
    $contrasena = "";
    $baseDeDatos = "TiendaDisfraces";
    $tabla = "user_profiles";

    $conn = mysqli_connect($servidor, $usuario, $contrasena, $baseDeDatos);

    if (!$conn) {
        die("La conexión a la base de datos ha fallado: " . mysqli_connect_error());
    }

    $profile_name = $_POST["profile_name"];
    $description = $_POST["description"];
    $status = $_POST["status"];


    $sql = "INSERT INTO $tabla (profile_name, description, status) VALUES ('$profile_name', '$description', '$status')";

    if (mysqli_query($conn, $sql)) {
        echo "Perfil agregado exitosamente.";
    } else {
        echo "Error al agregar perfil: " . mysqli_error($conn);
    }

    mysqli_close($conn);
} else {
    echo "Acceso no autorizado.";
}

header("Location: Perfil.php");
exit();
?>
