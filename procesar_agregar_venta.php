<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $servidor = "localhost";
    $usuario = "root";
    $contrasena = "";
    $baseDeDatos = "TiendaDisfraces";
    $tabla = "transactions";

    $conn = mysqli_connect($servidor, $usuario, $contrasena, $baseDeDatos);

    if (!$conn) {
        die("La conexión a la base de datos ha fallado: " . mysqli_connect_error());
    }

    $nombre_usuario = $_POST["nombre_usuario"];
    $nombre_prenda = $_POST["nombre_prenda"];
    $quantity = $_POST["quantity"];
    $total_amount = $_POST["total_amount"];
    $transaction_date = $_POST["transaction_date"];

    $sql = "INSERT INTO $tabla (nombre_usuario, nombre_prenda, quantity, total_amount, transaction_date) VALUES ('$nombre_usuario', '$nombre_prenda', '$quantity', '$total_amount', '$transaction_date')";

    if (mysqli_query($conn, $sql)) {
        echo "Venta agregada exitosamente.";
    } else {
        echo "Error al agregar venta: " . mysqli_error($conn);
    }

    mysqli_close($conn);
} else {
    echo "Acceso no autorizado.";
}

header("Location: Ventas.php");
exit();
?>
