<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id"];
    $user_id = $_POST["user_id"];
    $costume_id = $_POST["costume_id"];
    $quantity = $_POST["quantity"];
    $total_amount = $_POST["total_amount"];
    $transaction_date = $_POST["transaction_date"];

    // Conectarse a la base de datos
    $servidor = "localhost";
    $usuario = "root";
    $contrasena = "";
    $baseDeDatos = "TiendaDisfraces";
    $tabla = "transactions";

    $conn = mysqli_connect($servidor, $usuario, $contrasena, $baseDeDatos);

    if (!$conn) {
        die("La conexión a la base de datos ha fallado: " . mysqli_connect_error());
    }

    // Consulta para actualizar el perfil con el ID proporcionado
    $sql = "UPDATE $tabla SET user_id = '$user_id', costume_id = '$costume_id', quantity = '$quantity', total_amount = '$total_amount', transaction_date = '$transaction_date' WHERE id = $id";

    if (mysqli_query($conn, $sql)) {
        // Redireccionar a la vista de perfil después de la actualización
        header("Location: Ventas.php");
        exit();
    } else {
        echo "Error al actualizar la venta: " . mysqli_error($conn);
    }

    mysqli_close($conn);
} else {
    echo "Acceso no válido.";
}
?>
