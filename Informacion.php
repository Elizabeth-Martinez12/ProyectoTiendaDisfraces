<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
<?php
include 'menu.php';

$servidor = "localhost";
$usuario = "root";
$contrasena = "";
$baseDeDatos = "TiendaDisfraces";
$tabla = "user_info";

$datos = obtenerDatosDeTabla($servidor, $usuario, $contrasena, $baseDeDatos, $tabla);
function obtenerDatosDeTabla($servidor, $usuario, $contrasena, $baseDeDatos, $tabla) {
    $conn = mysqli_connect($servidor, $usuario, $contrasena, $baseDeDatos);

    if (!$conn) {
        die("La conexión a la base de datos ha fallado: " . mysqli_connect_error());
    }

    $sql = "SELECT * FROM " . $tabla;
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
    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#agregarInformacionModal">Agregar Información de Usuario</button>

<br>
<br>
<table border="1" class="table table-bordered table-striped">
    <thead class="thead-dark">
        <tr>
            <th>Id</th>
            <th>Nombre</th>
            <th>Apellido</th>
            <th>Cumpleaños</th>
            <th>Genero</th>
            <th>Edad</th>
            <th>Telefono</th>
            <th>Fotografia</th>
            <th>Estado</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($datos as $fila): ?>
        <tr>
                <td><?= $fila["id"] ?></td>
                <td><?= $fila["first_name"] ?></td>
                <td><?= $fila["last_name"] ?></td>
                <td><?= $fila["birthday"] ?></td>
                <td><?= $fila["gender"] ?></td>
                <td><?= $fila["age"] ?></td>
                <td><?= $fila["phone"] ?></td>
                <td><img src="<?php echo $fila["photo"]; ?>" alt="Photo" width="80" height="80"></td>
                <td><?= $fila["status"] ?></td>
                <td>
                    <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editarInformacionModal<?= $fila["id"] ?>">Editar</button>
                    <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#eliminarInformacionModal<?= $fila["id"] ?>">Eliminar</button>
                </td>
                </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<div class="modal fade" id="agregarInformacionModal" tabindex="-1" aria-labelledby="agregarInformacionModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="agregarInformacionModalLabel">Agregar Informacion de Usuario</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="procesar_agregar_informacion.php">
                        <div class="mb-3">
                            <label for="first_name" class="form-label">Nombre de Usuario</label>
                            <input type="text" class="form-control" id="first_name" name="first_name" required>
                        </div>
                        <div class="mb-3">
                            <label for="last_name" class="form-label">Apellido</label>
                            <input type="text" class="form-control" id="last_name" name="last_name" required>
                        </div>
                        <div class="mb-3">
                            <label for="birthday" class="form-label">Cumpleaños</label>
                            <input type="date" class="form-control" id="birthday" name="birthday" required>
                        </div>
                        <div class="mb-3">
                            <label for="gender">Genero</label>
                            <select name="gender" id="gender" class="form-control">
                            <option value="M">M</option>
                            <option value="F">F</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="age" class="form-label">Edad</label>
                            <input type="number" class="form-control" id="age" name="age" required>
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label">Telefono</label>
                            <input type="double" class="form-control" id="phone" name="phone" required>
                        </div>
                        <div class="mb-3">
                            <label for="photo" class="form-label">Fotografia</label>
                            <input type="url" class="form-control" id="photo" name="photo" required>
                        </div>
                        <div class="mb-3">
                            <label for="status" class="form-label">Estado</label>
                            <input type="number" class="form-control" id="status" name="status" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


<?php foreach ($datos as $fila) : ?>
    <div class="modal fade" id="editarInformacionModal<?= $fila["id"] ?>" tabindex="-1" aria-labelledby="editarInformacionModalLabel<?= $fila["id"] ?>" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editarInformacionModelLabel<?= $fila["id"] ?>">Editar Informacion</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="procesar_editar_informacion.php">
                    <div class="mb-3">
                            <label for="first_name" class="form-label">Nombre de Usuario</label>
                            <input type="text" class="form-control" id="first_name" name="first_name" value="<?= $fila["first_name"] ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="last_name" class="form-label">Apellido</label>
                            <input type="last_name" class="form-control" id="last_name" name="last_name" value="<?= $fila["last_name"] ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="birthday" class="form-label">Cumpleaños</label>
                            <input type="date" class="form-control" id="birthday" name="birthday" value="<?= $fila["birthday"] ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="gender">Genero</label>
                            <select name="gender" id="gender" class="form-control">
                            <?php if ($fila["gender"] == "M"): ?>
                                <option value="M" selected>M</option>
                                <option value="F">F</option>
                            <?php else: ?>
                                <option value="M">M</option>
                                <option value="F" selected>F</option>
                            <?php endif; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="age" class="form-label">Edad</label>
                            <input type="number" class="form-control" id="age" name="age" value="<?= $fila["age"] ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label">Telefono</label>
                            <input type="double" class="form-control" id="phone" name="phone" value="<?= $fila["phone"] ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="photo" class="form-label">Fotografia</label>
                            <input type="url" class="form-control" id="photo" name="photo" value="<?= $fila["photo"] ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="status" class="form-label">Estado</label>
                            <input type="number" class="form-control" id="status" name="status" value="<?= $fila["status"] ?>" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>


<?php foreach ($datos as $fila) : ?>
    <div class="modal fade" id="eliminarInformacionModal<?= $fila["id"] ?>" tabindex="-1" aria-labelledby="eliminarInformacionModalLabel<?= $fila["id"] ?>" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="eliminarInformacionModalLabel<?= $fila["id"] ?>">Eliminar Informacion</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>¿Estás seguro de que deseas eliminar el informacion "<?= $fila["first_name"] ?>"?</p>
                    <a href="procesar_eliminar_informacion.php?id=<?= $fila["id"] ?>" class="btn btn-danger">Eliminar</a>
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
    exportTableToCSV('user_info.csv');
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

