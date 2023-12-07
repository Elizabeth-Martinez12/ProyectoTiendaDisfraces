<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id"];
    $first_name = $_POST["first_name"];
    $last_name = $_POST["last_name"];
    $birthday = $_POST["birthday"];
    $gender = $_POST["gender"];
    $age = $_POST["age"];
    $phone = $_POST["phone"];
    $photo = $_POST["photo"];
    $status = $_POST["status"];

    // Conectarse a la base de datos
    $servidor = "localhost";
    $usuario = "root";
    $contrasena = "";
    $baseDeDatos = "TiendaDisfraces";
    $tabla = "user_info";

    $conn = mysqli_connect($servidor, $usuario, $contrasena, $baseDeDatos);

    if (!$conn) {
        die("La conexión a la base de datos ha fallado: " . mysqli_connect_error());
    }

    // Consulta para actualizar el perfil con el ID proporcionado
    $sql = "UPDATE $tabla SET first_name = '$first_name', last_name = '$last_name', birthday = '$birthday', gender = '$gender', age = '$age', phone = '$phone', photo = '$photo'  status = '$status' WHERE id = $id";

    if (mysqli_query($conn, $sql)) {
        // Redireccionar a la vista de perfil después de la actualización
        header("Location: Informacion.php");
        exit();
    } else {
        echo "Error al actualizar la informacion: " . mysqli_error($conn);
    }

    mysqli_close($conn);
} else {
    echo "Acceso no válido.";
}
?>
