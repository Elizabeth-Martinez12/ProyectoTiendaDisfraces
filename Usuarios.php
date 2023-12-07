<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
<?php
include 'menu.php';

$servidor = "localhost";
$usuario = "root";
$password = "";
$baseDeDatos = "TiendaDisfraces";
$tabla = "users";

$datos = obtenerDatosDeTabla($servidor, $usuario, $password, $baseDeDatos, $tabla);
function obtenerDatosDeTabla($servidor, $usuario, $password, $baseDeDatos, $tabla) {
    $conn = mysqli_connect($servidor, $usuario, $password, $baseDeDatos);

    if (!$conn) {
        die("La conexión a la base de datos ha fallado: " . mysqli_connect_error());
    }

    $sql = "SELECT users.*, user_profiles.profile_name
            FROM users
            LEFT JOIN user_profiles ON users.profile_id = user_profiles.id
            WHERE user_profiles.profile_name IN ('Administrador', 'Usuario')";
    $result = mysqli_query($conn, $sql);

    $datos = array();
    if ($result) {
        if (mysqli_num_rows($result) > 0) {
            while ($fila = mysqli_fetch_assoc($result)) {
                $datos[] = $fila;
            }
        }
    } else {
        echo "Error en la consulta: " . mysqli_error($conn);
    }

    mysqli_close($conn);

    return $datos;
}


?>

<br>
    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#agregarUsuarioModal">Agregar Usuario</button>

<br>
<br>
<table border="1" class="table table-bordered table-striped">
    <thead class="thead-dark">
        <tr>
            <th>Id</th>
            <th>Nombre de usuario</th>
            <th>Contraseña</th>
            <th>Estado</th>
            <th>Tipo de usuario</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($datos as $fila): ?>
        <tr>
                <td><?= $fila["id"] ?></td>
                <td><?= $fila["username"] ?></td>
                <td>
                <?= str_repeat('*', strlen($fila['password'])) ?>
                <button class="btn btn-info" onclick="mostrarcontraseña('<?= $fila['password'] ?>')">Mostrar</button>
                </td>
                <td><?= $fila["status"] ?></td>
                <td><?= $fila["profile_name"] ?></td>
                <td>
                    <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editarUsuarioModal<?= $fila["id"] ?>">Editar</button>
                    <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#eliminarUsuarioModal<?= $fila["id"] ?>">Eliminar</button>
                </td>
                </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<script>
    function mostrarcontraseña(password) {
        alert('Contraseña: ' + password);
    }
</script>


<div class="modal fade" id="agregarUsuarioModal" tabindex="-1" aria-labelledby="agregarUsuarioModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="agregarUsuarioModalLabel">Agregar Usuario</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="procesar_agregar_usuario.php">
                        <div class="mb-3">
                            <label for="username" class="form-label">Nombre de Usuario</label>
                            <input type="text" class="form-control" id="username" name="username" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Contraseña</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <div class="mb-3">
                            <label for="status" class="form-label">Estado</label>
                            <input type="number" class="form-control" id="status" name="status" required>
                        </div>
                        <div class="mb-3">
                            <label for="profile_name" class="form-label">Tipo de Usuario</label>
                            <select name="profile_name" class="form-control">
                            <?php
                                $perfilesUnicos = array_unique(array_column($datos, 'profile_name'));
                                foreach ($perfilesUnicos as $perfil) : ?>
                                    <option value="<?= $perfil ?>"><?= $perfil ?></option>
                                <?php endforeach ?>
                                </select>
                            </div>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


<?php foreach ($datos as $fila) : ?>

    <div class="modal fade" id="editarUsuarioModal<?= $fila["id"] ?>" tabindex="-1" aria-labelledby="editarUsuarioModalLabel<?= $fila["id"] ?>" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editarUsuarioModalLabel<?= $fila["id"] ?>">Editar Usuario</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="procesar_editar_usuario.php">
                        <input type="hidden" name="id" value="<?= $fila["id"] ?>" required>
                    <div class="mb-3">
                            <label for="username" class="form-label">Nombre de Usuario</label>
                            <input type="text" class="form-control" id="username" name="username" value="<?= $fila["username"] ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Contraseña</label>
                            <input type="text" class="form-control" id="password" name="password" value="<?= $fila["password"] ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="status" class="form-label">Estado</label>
                            <input type="number" class="form-control" id="status" name="status" value="<?= $fila["status"] ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="profile_name" class="form-label">Tipo de Usuario</label>
                            <select name="profile_name" class="form-control">
                            <?php
                                var_dump($_POST);
                                $perfilesUnicos = array_unique(array_column($datos, 'profile_name'));
                                foreach ($perfilesUnicos as $perfil) : ?>
                                    <option value="<?= $perfil ?>"><?= $perfil ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>


<?php foreach ($datos as $fila) : ?>
    <div class="modal fade" id="eliminarUsuarioModal<?= $fila["id"] ?>" tabindex="-1" aria-labelledby="eliminarUsuarioModalLabel<?= $fila["id"] ?>" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="eliminarUsuarioModalLabel<?= $fila["id"] ?>">Eliminar Perfil</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>¿Estás seguro de que deseas eliminar usuario "<?= $fila["username"] ?>"?</p>
                    <a href="procesar_eliminar_usuario.php?id=<?= $fila["id"] ?>" class="btn btn-danger">Eliminar</a>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>

<br>

<button id="exportCSV" class="btn btn-primary">Descargar CSV</button>

<script>
document.getElementById('exportCSV').addEventListener('click', function() {
    // Llama a la función de exportación
    exportTableToCSV('users.csv');
});

function exportTableToCSV(filename) {
    var csv = [];
    var rows = document.querySelectorAll('table tr');

    for (var i = 0; i < rows.length; i++) {
        var row = [], cols = rows[i].querySelectorAll('td, th');

        for (var j = 0; j < cols.length; j++) {
            row.push(cols[j].innerText);
        }

        csv.push(row.join(','));
    }

    // Descarga el archivo CSV
    downloadCSV(csv.join('\n'), filename);
}

function downloadCSV(csv, filename) {
    var csvFile;
    var downloadLink;

    // Crear un objeto Blob para el contenido CSV
    var blob = new Blob([csv], { type: 'text/csv;charset=utf-8;' });

    // Crear un enlace de descarga
    if (navigator.msSaveBlob) { // IE 10+
        navigator.msSaveBlob(blob, filename);
    } else {
        csvFile = new Blob([csv], { type: 'text/csv' });
        downloadLink = document.createElement('a');
        downloadLink.href = window.URL.createObjectURL(csvFile);
        downloadLink.setAttribute('download', filename);
        downloadLink.click();
    }
}
</script>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

