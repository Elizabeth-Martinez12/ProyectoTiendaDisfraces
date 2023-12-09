<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
<?php
include 'menu.php';

$servidor = "localhost";
$usuario = "root";
$costume_name = "";
$baseDeDatos = "TiendaDisfraces";
$tabla = "costumes";

$datos = obtenerDatosDeTabla($servidor, $usuario, $costume_name, $baseDeDatos, $tabla);

function obtenerDatosDeTabla($servidor, $usuario, $costume_name, $baseDeDatos, $tabla) {
    $conn = mysqli_connect($servidor, $usuario, $costume_name, $baseDeDatos);

    if (!$conn) {
        die("La conexión a la base de datos ha fallado: " . mysqli_connect_error());
    }

    $sql = "SELECT costumes.*, costume_categories.name, costume_comments.comment_text 
            FROM costumes
            LEFT JOIN costume_categories ON costumes.idCategory = costume_categories.id
            LEFT JOIN costume_comments ON costumes.id = costume_comments.costume_id
            WHERE costumes.id = costume_comments.costume_id;";  
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
<button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#agregarDisfracesModal">Agregar disfraz</button>
<br>
<br>
<table border="1" class="table table-bordered table-striped">
    <thead class="thead-dark">
        <tr>
            <th>Id</th>
            <th>Categoria</th>
            <th>Imagen</th>
            <th>Nombre</th>
            <th>Descripcion</th>
            <th>Precio</th>
            <th>Cantidad</th>
            <th>Comentarios</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($datos as $fila): ?>
            <tr>
                <td><?= $fila["id"] ?></td>
                <td><?= $fila["name"] ?></td>
                <td><img src="<?php echo $fila["image"]; ?>" alt="Photo" width="alt" height="100"></td>
                <td><?= $fila["costume_name"] ?></td>
                <td><?= $fila["description"] ?></td>
                <td><?= $fila["price"] ?></td>
                <td><?= $fila["stock"] ?></td>
                <td>
                    <button class="btn btn-info" data-bs-toggle="modal" data-bs-target="#comentariosModal<?= $fila["id"] ?>">Ver Comentarios</button>
                </td>
                <td>
                    <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editarDisfracesModal<?= $fila["id"] ?>">Editar</button>
                    <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#eliminarDisfracesModal<?= $fila["id"] ?>">Eliminar</button>
                </td>

            </tr>

            <div class="modal fade" id="comentariosModal<?= $fila["id"] ?>" tabindex="-1" aria-labelledby="comentariosModalLabel<?= $fila["id"] ?>" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="comentariosModalLabel<?= $fila["id"] ?>">Comentarios para <?= $fila["costume_name"] ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                </div>
            </div>
        </div>
    </div>
        <?php endforeach; ?>
    </tbody>
</table>

<script>
<?php foreach ($datos as $fila): ?>
    document.getElementById('comentariosModal<?= $fila["id"] ?>').addEventListener('show.bs.modal', function (event) {
        var modal = event.target;
        var disfrazId = <?= $fila["id"] ?>;

        obtenerComentariosAjax(disfrazId, function(comentarios) {
            var modalBody = modal.querySelector('.modal-body');
            modalBody.innerHTML = '';

            if (comentarios.length > 0) {
                var listaComentarios = document.createElement('ul');
                comentarios.forEach(function(comentario) {
                    var listItem = document.createElement('li');
                    listItem.textContent = comentario.comment_text;
                    listaComentarios.appendChild(listItem);
                });
                modalBody.appendChild(listaComentarios);
            } else {
                modalBody.textContent = 'No hay comentarios disponibles.';
            }
        });
    });
<?php endforeach; ?>
</script>


<script>
function obtenerComentariosAjax(disfrazId, callback) {
    fetch('obtener_comentario.php?disfraz_id=' + disfrazId)
        .then(response => response.json())
        .then(data => callback(data))
        .catch(error => console.error('Error al obtener comentarios:', error));
}
</script>

<div class="modal fade" id="agregarDisfracesModal" tabindex="-1" aria-labelledby="agregarDisfracesModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="agregarDisfracesModalLabel">Agregar Usuario</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="procesar_agregar_disfraces.php">
                        <div class="mb-3">
                            <label for="name" class="form-label">Categoria</label>
                            <select name="name" class="form-control">
                            <?php
                                $unicaCategory = array_unique(array_column($datos, 'name'));
                                foreach ($unicaCategory as $category) : ?>
                                    <option value="<?= $category ?>"><?= $category ?></option>
                                <?php endforeach ?>
                                </select>
                        </div>   
                        <div class="mb-3">
                            <label for="image" class="form-label">Imagen</label>
                            <input type="file" class="form-control" id="image" name="image" required>
                        </div>
                        <div class="mb-3">
                            <label for="costume_name" class="form-label">Nombre</label>
                            <input type="costume_name" class="form-control" id="costume_name" name="costume_name" required>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Descripción</label>
                            <textarea class="form-control" id="description" name="description" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="price" class="form-label">Precio</label>
                            <input type="double" class="form-control" id="price" name="price" required>
                        </div>
                        <div class="mb-3">
                            <label for="stock" class="form-label">Cantidad</label>
                            <input type="number" class="form-control" id="stock" name="stock" required>
                        </div>
                        
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


<?php foreach ($datos as $fila) : ?>

    <div class="modal fade" id="editarDisfracesModal<?= $fila["id"] ?>" tabindex="-1" aria-labelledby="editarDisfracesModalLabel<?= $fila["id"] ?>" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editarDisfracesModalLabel<?= $fila["id"] ?>">Editar Disfraz</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="procesar_editar_disfraces.php">
                        <input type="hidden" name="id" value="<?= $fila["id"] ?>" required>
                    <div class="mb-3">
                            <label for="name" class="form-label">Categoria</label>
                            <input type="text" class="form-control" id="name" name="name" value="<?= $fila["name"] ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="image" class="form-label">Imagen</label>
                            <input type="url" class="form-control" id="image" name="image" value="<?= $fila["image"] ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="costume_name" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="costume_name" name="costume_name" value="<?= $fila["costume_name"] ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Descripcion</label>
                            <input type="description" class="form-control" id="description" name="description" value="<?= $fila["description"] ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="price" class="form-label">Precio</label>
                            <input type="double" class="form-control" id="price" name="price" value="<?= $fila["price"] ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="stock" class="form-label">Cantidad</label>
                            <input type="numer" class="form-control" id="stock" name="stock" value="<?= $fila["stock"] ?>" required>
                        </div>
                        
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>


<?php foreach ($datos as $fila) : ?>
    <div class="modal fade" id="eliminarDisfracesModal<?= $fila["id"] ?>" tabindex="-1" aria-labelledby="eliminarDisfracesModalLabel<?= $fila["id"] ?>" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="eliminarDisfracesModalLabel<?= $fila["id"] ?>">Eliminar Perfil</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>¿Estás seguro de que deseas eliminar el disfraz "<?= $fila["costume_name"] ?>"?</p>
                    <a href="procesar_eliminar_disfraces.php?id=<?= $fila["id"] ?>" class="btn btn-danger">Eliminar</a>
                </div>
            </div>
        </div>
    </div>
    
<?php endforeach; ?>

<br>

<button id="exportCSV" class="btn btn-primary">Descargar CSV</button>

<script>
document.getElementById('exportCSV').addEventListener('click', function() {
   
    exportTableToCSV('costumes.csv');
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

    downloadCSV(csv.join('\n'), filename);
}

function downloadCSV(csv, filename) {
    var csvFile;
    var downloadLink;

    var blob = new Blob([csv], { type: 'text/csv;charset=utf-8;' });

    if (navigator.msSaveBlob) { 
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