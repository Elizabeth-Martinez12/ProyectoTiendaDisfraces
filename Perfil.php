
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <?php
    include 'menu.php';

    $servidor = "localhost";
    $usuario = "root";
    $contrasena = "";
    $baseDeDatos = "TiendaDisfraces";
    $tabla = "user_profiles";

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
    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#agregarPerfilModal">Agregar Perfil</button>

  
<br>
<br>
<table border="1" class="table table-bordered table-striped">
    <thead class="thead-dark">
        <tr>
            <th>ID</th>
            <th>Nombre de perfil</th>
            <th>Descripción</th>
            <th>Estado</th>
            <th>Acciones</th> 
        </tr>
    </thead>
    <tbody>
        <?php foreach ($datos as $fila) : ?>
            <tr>
                <td><?= $fila["id"] ?></td>
                <td><?= $fila["profile_name"] ?></td>
                <td><?= $fila["description"] ?></td>
                <td><?= $fila["status"] ?></td>
                <td>
                    <!-- Botones para editar y eliminar -->
                    <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editarPerfilModal<?= $fila["id"] ?>">Editar</button>
                    <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#eliminarPerfilModal<?= $fila["id"] ?>">Eliminar</button>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

    <div class="modal fade" id="agregarPerfilModal" tabindex="-1" aria-labelledby="agregarPerfilModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="agregarPerfilModalLabel">Agregar Perfil</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="procesar_agregar_perfil.php">
                        <div class="mb-3">
                            <label for="profile_name" class="form-label">Nombre de perfil</label>
                            <input type="text" class="form-control" id="profile_name" name="profile_name" required>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Descripción</label>
                            <textarea class="form-control" id="description" name="description" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="status" class="form-label">Estado</label>
                            <input type="text" class="form-control" id="status" name="status" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


<?php foreach ($datos as $fila) : ?>
    <div class="modal fade" id="editarPerfilModal<?= $fila["id"] ?>" tabindex="-1" aria-labelledby="editarPerfilModalLabel<?= $fila["id"] ?>" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editarPerfilModalLabel<?= $fila["id"] ?>">Editar Perfil</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Aquí puedes agregar el formulario para editar un perfil -->
                    <!-- Utiliza los valores de $fila para prellenar los campos -->
                    <!-- Asegúrate de incluir los campos necesarios, como profile_name, description, status, etc. -->
                    <form method="POST" action="procesar_editar_perfil.php">
                        <input type="hidden" name="id" value="<?= $fila["id"] ?>">
                        <div class="mb-3">
                            <label for="profile_name" class="form-label">Nombre de perfil</label>
                            <input type="text" class="form-control" id="profile_name" name="profile_name" value="<?= $fila["profile_name"] ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Descripción</label>
                            <textarea class="form-control" id="description" name="description" required><?= $fila["description"] ?></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="status" class="form-label">Estado</label>
                            <input type="text" class="form-control" id="status" name="status" value="<?= $fila["status"] ?>" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>


<?php foreach ($datos as $fila) : ?>
    <div class="modal fade" id="eliminarPerfilModal<?= $fila["id"] ?>" tabindex="-1" aria-labelledby="eliminarPerfilModalLabel<?= $fila["id"] ?>" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="eliminarPerfilModalLabel<?= $fila["id"] ?>">Eliminar Perfil</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Confirmación de eliminación -->
                    <p>¿Estás seguro de que deseas eliminar el perfil "<?= $fila["profile_name"] ?>"?</p>
                    <!-- Enviar el ID al archivo de procesamiento de eliminación -->
                    <a href="procesar_eliminar_perfil.php?id=<?= $fila["id"] ?>" class="btn btn-danger">Eliminar</a>
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
    exportTableToCSV('user_profiles.csv');
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

