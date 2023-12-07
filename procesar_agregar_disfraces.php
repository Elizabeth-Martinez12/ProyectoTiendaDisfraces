<?php

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $servidor = "localhost";
    $usuario = "root";
    $contrasena = "";
    $baseDeDatos = "TiendaDisfraces";
    $tabla = "costumes";

    $conn = mysqli_connect($servidor, $usuario, $contrasena, $baseDeDatos);

    if (!$conn) {
        die("La conexión a la base de datos ha fallado: " . mysqli_connect_error());
    }

    $name = $_POST["name"];
    $image = $_POST["image"];
    $costume_name = $_POST["costume_name"];
    $description = $_POST["description"];
    $price = $_POST["price"];
    $stock = $_POST["stock"];

    $sql = "INSERT INTO $tabla (name, image, costume_name, description, price, stock) VALUES ('$name', '$image', '$costume_name', '$description', '$price', '$stock')";

    if (mysqli_query($conn, $sql)) {
        echo "Disfraz agregada exitosamente.";
    } else {
        echo "Error al agregar disfraz: " . mysqli_error($conn);
    }

    
    mysqli_close($conn);
} else {
    echo "Acceso no autorizado.";
}

header("Location: Disfraces.php");
exit();
?>
