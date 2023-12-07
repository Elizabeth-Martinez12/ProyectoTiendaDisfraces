<?php
// procesar_agregar_perfil.php

// Verificar si se recibieron los datos del formulario
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Conectar a la base de datos
    $servidor = "localhost";
    $usuario = "root";
    $contrasena = "";
    $baseDeDatos = "TiendaDisfraces";
    $tabla = "users";

    $conn = mysqli_connect($servidor, $usuario, $contrasena, $baseDeDatos);

    if (!$conn) {
        die("La conexión a la base de datos ha fallado: " . mysqli_connect_error());
    }

    // Obtener datos del formulario
    $username = $_POST["username"];
    $password = $_POST["password"];
    $status = $_POST["status"];
    $profile_id = $_POST["profile_id"];

    // Insertar nuevo perfil en la base de datos
    $sql = "INSERT INTO $tabla (username, password, status, profile_id) VALUES ('$username', '$password', '$status', '$profile_id')";

    if (mysqli_query($conn, $sql)) {
        echo "Usuario agregado exitosamente.";
    } else {
        echo "Error al agregar usuario: " . mysqli_error($conn);
    }

    // Cerrar la conexión
    mysqli_close($conn);
} else {
    echo "Acceso no autorizado.";
}

// Redirigir a la vista de perfiles después de procesar el formulario
header("Location: Usuarios.php");
exit();
?>
