<?php
session_start();

if (isset($_SESSION['usuario'])) {
    header('Location: PanelControl.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $servidor = "localhost";
    $usuario_bd = "root";
    $contrasena_bd = "";
    $base_de_datos = "TiendaDisfraces";

    $conn = mysqli_connect($servidor, $usuario_bd, $contrasena_bd, $base_de_datos);

    if (!$conn) {
        die("La conexión a la base de datos ha fallado: " . mysqli_connect_error());
    }

    // Obtener datos del formulario
    $usuario = mysqli_real_escape_string($conn, $_POST['usuario']);
    $password = isset($_POST['password']) ? mysqli_real_escape_string($conn, $_POST['password']) : '';


    // Consulta SQL para verificar las credenciales
    $sql = "SELECT id, username FROM users WHERE username = '$usuario' AND password = '$password'";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        if (mysqli_num_rows($result) == 1) {
            // Iniciar sesión y redirigir
            $row = mysqli_fetch_assoc($result);
            $_SESSION['usuario_id'] = $row['id'];
            $_SESSION['usuario'] = $row['username'];
            header('Location: Perfil.php');
            exit();
        } else {
            $error_message = "Usuario o contraseña incorrectos";
        }
    } else {
        echo "Error en la consulta: " . mysqli_error($conn);
    }

    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
</head>
<body>
    <h2>Iniciar Sesión</h2>
    
    <?php if (isset($error_message)): ?>
        <p style="color: red;"><?= $error_message ?></p>
    <?php endif; ?>

    <form method="POST" action="">
        <label for="usuario">Usuario:</label>
        <input type="text" id="usuario" name="usuario" required>
        <br>
        <label for="password">Contraseña:</label>
        <input type="password" id="password" name="password" required>
        <br>
        <button type="submit">Iniciar Sesión</button>
    </form>
</body>
</html>
