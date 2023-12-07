<?php

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $servidor = "localhost";
    $usuario = "root";
    $contrasena = "";
    $baseDeDatos = "TiendaDisfraces";
    $tabla = "user_info";

    $conn = mysqli_connect($servidor, $usuario, $contrasena, $baseDeDatos);

    if (!$conn) {
        die("La conexión a la base de datos ha fallado: " . mysqli_connect_error());
    }

    $first_name = $_POST["first_name"];
    $last_name = $_POST["last_name"];
    $birthday = $_POST["birthday"];
    $gender = $_POST["gender"];
    $age = $_POST["age"];
    $phone = $_POST["phone"];
    $photo = $_POST["photo"];
    $status = $_POST["status"];

    $sql = "INSERT INTO $tabla (first_name, last_name, birthday, gender, age, phone, photo, status) VALUES ('$first_name', '$last_name', '$birthday', '$gender', '$age', '$phone','$photo', '$status')";

    if (mysqli_query($conn, $sql)) {
        echo "Información agregada exitosamente.";
    } else {
        echo "Error al agregar información: " . mysqli_error($conn);
    }

    
    mysqli_close($conn);
} else {
    echo "Acceso no autorizado.";
}

header("Location: Informacion.php");
exit();
?>
