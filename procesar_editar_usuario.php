<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id"];
    $username = $_POST["username"];
    $password = $_POST["password"];
    $status = $_POST["status"];

    // Verificar si el índice "profile_name" está presente en $_POST antes de acceder a él
    $profile_name = isset($_POST["profile_name"]) ? $_POST["profile_name"] : null;

    if ($profile_name !== null) {
    // Resto del código
    

    // Validación y escape de datos
    $id = intval($id);
    $username = htmlspecialchars($username);
    // Aquí deberías aplicar funciones de hash seguras para almacenar la contraseña
    // Además, considera el uso de sentencias preparadas para evitar inyecciones SQL

    $servidor = "localhost";
    $usuario = "root";
    $contrasena = "";
    $baseDeDatos = "TiendaDisfraces";
    $tabla = "users";

    $conn = mysqli_connect($servidor, $usuario, $contrasena, $baseDeDatos);

    if (!$conn) {
        die("La conexión a la base de datos ha fallado: " . mysqli_connect_error());
    }

    // Obtener el id correspondiente al profile_name de la tabla user_profiles
    $profile_query = "SELECT id FROM user_profiles WHERE profile_name = '$profile_name'";
    $profile_result = mysqli_query($conn, $profile_query);

    if (!$profile_result) {
        die("Error al obtener el id del profile: " . mysqli_error($conn));
    }

    $profile_row = mysqli_fetch_assoc($profile_result);
    $profile_id = $profile_row['id'];

    // Consulta para actualizar el perfil con el ID proporcionado
    $sql = "UPDATE $tabla SET username = '$username', password = '$password', status = '$status', profile_id = '$profile_id' WHERE id = $id";

    if (mysqli_query($conn, $sql)) {
        // Redireccionar a la vista de perfil después de la actualización
        header("Location: Usuarios.php");
        exit();
    } else {
        echo "Error al actualizar el perfil: " . mysqli_error($conn);
    }

    mysqli_close($conn);
} else {
    echo "Error: El campo profile_name no está presente en la solicitud.";
    }
}
?>
