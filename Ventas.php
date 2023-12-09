<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
<?php
include 'menu.php';

$servidor = "localhost";
$usuario = "root";
$baseDeDatos = "TiendaDisfraces";
$tabla = "transactions";

$datos = obtenerDatosDeTabla($servidor, $usuario, $baseDeDatos, $tabla);
function obtenerDatosDeTabla($servidor, $usuario, $baseDeDatos, $tabla) {
    $conn = mysqli_connect($servidor, $usuario, "", $baseDeDatos);

    if (!$conn) {
        die("La conexión a la base de datos ha fallado: " . mysqli_connect_error());
    }

    $sql = "SELECT transactions.*, users.username as nombre_usuario, costumes.costume_name as nombre_prenda
            FROM transactions
            JOIN users ON transactions.user_id = users.id
            JOIN costumes ON transactions.costume_id = costumes.id";

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
    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#agregarVentaModal">Agregar Venta</button>

<br>
<br>
<table border="1" class="table table-bordered table-striped">
    <thead class="thead-dark">
        <tr>
            <th>Id</th>
            <th>Nombre usuario</th>
            <th>Nombre prenda</th>
            <th>Cantidad</th>
            <th>Total</th>
            <th>Fecha Venta</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($datos as $fila): ?>
        <tr>
                <td><?= $fila["id"] ?></td>
                <td><?= $fila["nombre_usuario"] ?></td>
                <td><?= $fila["nombre_prenda"] ?></td>
                <td><?= $fila["quantity"] ?></td>
                <td><?= $fila["total_amount"] ?></td>
                <td><?= $fila["transaction_date"] ?></td>
                <td>
                    <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editarVentaModal<?= $fila["id"] ?>">Editar</button>
                    <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#eliminarVentaModal<?= $fila["id"] ?>">Eliminar</button>
                </td>
                </tr>
        <?php endforeach; ?>
    </tbody>
</table>



<div class="modal fade" id="agregarVentaModal" tabindex="-1" aria-labelledby="agregarVentaModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="agregarVentaModalLabel">Agregar Venta</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="procesar_agregar_venta.php">
                        <div class="mb-3">
                            <label for="user_id" class="form-label">Nombre de Usuario</label>
                            <input type="text" class="form-control" id="user_id" name="user_id" required>
                        </div>
                        <div class="mb-3">
                            <label for="costume_id" class="form-label">Prenda</label>
                            <input type="number" class="form-control" id="costume_id" name="costume_id" required>
                        </div>
                        <div class="mb-3">
                            <label for="quantity" class="form-label">Estado</label>
                            <input type="number" class="form-control" id="quantity" name="quantity" required>
                        </div>
                        <div class="mb-3">
                            <label for="total_amount" class="form-label">Total</label>
                            <input type="number" class="form-control" id="total_amount" name="total_amount" required>
                        </div>
                        <div class="mb-3">
                            <label for="transaction_date" class="form-label">Fecha Venta</label>
                            <input type="date" class="form-control" id="transaction_date" name="transaction_date" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


<?php foreach ($datos as $fila) : ?>

    <div class="modal fade" id="editarVentaModal<?= $fila["id"] ?>" tabindex="-1" aria-labelledby="editarVentaModalLabel<?= $fila["id"] ?>" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editarVentaModalLabel<?= $fila["id"] ?>">Editar Venta</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="procesar_editar_venta.php">
                        <input type="hidden" name="id" value="<?= $fila["id"] ?>" required>
                    <div class="mb-3">
                            <label for="user_id" class="form-label">Usuario</label>
                            <input type="text" class="form-control" id="user_id" name="user_id" value="<?= $fila["user_id"] ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="costume_id" class="form-label">Disfraz</label>
                            <input type="text" class="form-control" id="costume_id" name="costume_id" value="<?= $fila["costume_id"] ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="quantity" class="form-label">Cantidad</label>
                            <input type="number" class="form-control" id="quantity" name="quantity" value="<?= $fila["quantity"] ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="total_amount" class="form-label">Total</label>
                            <input type="number" class="form-control" id="total_amount" name="total_amount" value="<?= $fila["total_amount"] ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="transaction_date" class="form-label">Estado</label>
                            <input type="date" class="form-control" id="transaction_date" name="transaction_date" value="<?= $fila["transaction_date"] ?>" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>


<?php foreach ($datos as $fila) : ?>
    <div class="modal fade" id="eliminarVentaModal<?= $fila["id"] ?>" tabindex="-1" aria-labelledby="eliminarVentaModalLabel<?= $fila["id"] ?>" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="eliminarVentaModalLabel<?= $fila["id"] ?>">Eliminar Perfil</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>¿Estás seguro de que deseas eliminar venta "<?= $fila["nombre_prenda"] ?>"?</p>
                    <a href="procesar_eliminar_venta.php?id=<?= $fila["id"] ?>" class="btn btn-danger">Eliminar</a>
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

