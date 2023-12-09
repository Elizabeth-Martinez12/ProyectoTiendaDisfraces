
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <?php
    include 'menu.php';

    $servidor = "localhost";
    $usuario = "root";
    $contrasena = "";
    $baseDeDatos = "TiendaDisfraces";
    $tabla = "accessories";

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
    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#agregarAccesorioModal">Agregar Accesorio</button>

  
<br>
<br>
<table border="1" class="table table-bordered table-striped">
    <thead class="thead-dark">
        <tr>
            <th>ID</th>
            <th>Imagen</th>
            <th>Nombre</th>
            <th>Cantidad</th>
            <th>Tipo</th>
            <th>Material</th>
            <th>Categoria</th>
            <th>Precio</th> 
        </tr>
    </thead>
    <tbody>
        <?php foreach ($datos as $fila) : ?>
            <tr>
                <td><?= $fila["id"] ?></td>
                <td><img src="<?php echo $fila["illustration"]; ?>" alt="Photo" width="80" height="80"></td>
                <td><?= $fila["name"] ?></td>
                <td><?= $fila["quantity"] ?></td>
                <td><?= $fila["type"] ?></td>
                <td><?= $fila["material"] ?></td>
                <td><?= $fila["category"] ?></td>
                <td><?= $fila["price"] ?></td>
                <td>
                    <!-- Botones para editar y eliminar -->
                    <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editarAccesorioModal<?= $fila["id"] ?>">Editar</button>
                    <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#eliminarAccesorioModal<?= $fila["id"] ?>">Eliminar</button>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

    <div class="modal fade" id="agregarAccesorioModal" tabindex="-1" aria-labelledby="agregarPerfilModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="agregarPerfilModalLabel">Agregar Accesorios</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="procesar_agregar_accesorios.php">
                        <div class="mb-3">
                            <label for="illustration" class="form-label">Imagen</label>
                            <input type="file" class="form-control" id="illustration" name="illustration" required>
                        </div>
                        <div class="mb-3">
                            <label for="name" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="name" name="name" required></input>
                        </div>
                        <div class="mb-3">
                            <label for="quantity" class="form-label">Cantidad</label>
                            <input type="number" class="form-control" id="quantity" name="quantity" required></input>
                        </div>
                        <div class="mb-3">
                            <label for="type" class="form-label">Tipo</label>
                            <input type="text" class="form-control" id="type" name="type" required></input>
                        </div>
                        <div class="mb-3">
                            <label for="material" class="form-label">Material</label>
                            <input type="text" class="form-control" id="material" name="material" required></input>
                        </div>
                        <div class="mb-3">
                            <label for="category" class="form-label">Categoria</label>
                            <input class="form-control" id="category" name="category" required></input>
                        </div>
                        <div class="mb-3">
                            <label for="price" class="form-label">Precio</label>
                            <input type="double" class="form-control" id="price" name="price" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


<?php foreach ($datos as $fila) : ?>
    <div class="modal fade" id="editarAccesorioModal<?= $fila["id"] ?>" tabindex="-1" aria-labelledby="editarAccesorioModalLabel<?= $fila["id"] ?>" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editarAccesorioModalLabel<?= $fila["id"] ?>">Editar Accesorio</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="procesar_editar_accesorios.php">
                        <input type="hidden" name="id" value="<?= $fila["id"] ?>">
                        <div class="mb-3">
                            <label for="illustration" class="form-label">Imagen</label>
                            <input type="file" class="form-control" id="illustration" name="illustration" value="<?= $fila["illustration"] ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="name" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="name" name="name" required><?= $fila["name"] ?></input>
                        </div>
                        <div class="mb-3">
                            <label for="quantity" class="form-label">Cantidad</label>
                            <input type="number" class="form-control" id="quantity" name="quantity" value="<?= $fila["quantity"] ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="type" class="form-label">Tipo</label>
                            <input type="text" class="form-control" id="type" name="type" value="<?= $fila["type"] ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="material" class="form-label">Nombre de perfil</label>
                            <input type="text" class="form-control" id="material" name="material" value="<?= $fila["material"] ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="price" class="form-label">Precio</label>
                            <input type="text" class="form-control" id="price" name="price" value="<?= $fila["price"] ?>" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>


<?php foreach ($datos as $fila) : ?>
    <div class="modal fade" id="eliminarAccesorioModal<?= $fila["id"] ?>" tabindex="-1" aria-labelledby="eliminarAccesorioModalLabel<?= $fila["id"] ?>" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="eliminarAccesorioModalLabel<?= $fila["id"] ?>">Eliminar Perfil</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Confirmación de eliminación -->
                    <p>¿Estás seguro de que deseas eliminar el accesorio "<?= $fila["name"] ?>"?</p>
                    <!-- Enviar el ID al archivo de procesamiento de eliminación -->
                    <a href="procesar_eliminar_accesorio.php?id=<?= $fila["id"] ?>" class="btn btn-danger">Eliminar</a>
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
    exportTableToCSV('accesories.csv');
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

