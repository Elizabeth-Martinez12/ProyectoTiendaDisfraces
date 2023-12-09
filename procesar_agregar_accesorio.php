<?php

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $servidor = "localhost";
    $usuario = "root";
    $contrasena = "";
    $baseDeDatos = "TiendaDisfraces";
    $tabla = "accesories";

    $conn = mysqli_connect($servidor, $usuario, $contrasena, $baseDeDatos);

    if (!$conn) {
        die("La conexión a la base de datos ha fallado: " . mysqli_connect_error());
    }

    $illustration = $_POST["illustration"];
    $name = $_POST["name"];
    $quantity = $_POST["quantity"];
    $type = $_POST["type"];
    $material = $_POST["material"];
    $category = $_POST["category"];
    $price = $_POST["price"];

    $sql = "INSERT INTO $tabla (illustration, name, quantity, type, material, category, price) VALUES ('$category', '$illustration', '$name', '$quantity', '$type', '$material', '$category','$price')";

    if (mysqli_query($conn, $sql)) {
        echo "Accesorio agregada exitosamente.";
    } else {
        echo "Error al agregar accesorio: " . mysqli_error($conn);
    }

    
    mysqli_close($conn);
} else {
    echo "Acceso no autorizado.";
}

header("Location: Accesorios.php");
exit();
?>
