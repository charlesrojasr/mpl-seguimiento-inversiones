<?php
// Incluir el archivo de conexión y funciones para obtener las áreas
include('actividades_buscar_areas.php'); // Asegúrate de que la ruta sea correcta

// Obtener las áreas para el filtro
$areas = obtenerAreasConId();
?>

<!-- ===================== FILTROS ===================== -->
<div class="card">
    <div class="card-header">Filtros</div>
    <div class="card-body">
        <div class="row">

            <!-- Filtro Área -->
            <div class="col-md-4 mb-2">
                <label>Área</label>
                <select id="areasFiltro" class="form-control">
                    <option value="Todos">Todos</option>
                    <?php foreach ($areas as $area): ?>
                        <option value="<?= htmlspecialchars($area) ?>">
                            <?= htmlspecialchars($area) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-4 mb-2">
                <!-- Filtro Acción -->
                 <label>Áccion</label>
                <select id="accionFiltro" class="form-control">
                    <option value="">Todos</option>
                    <option value="INSERT">AÑADIÓ</option>
                    <option value="UPDATE">ACTUALIZÓ</option>
                </select>
            </div>

            <!-- Botones -->
            <div class="col-md-2 mb-2">
                <button onclick="filtrarTabla()"
                    class="btn btn-block bg-gradient-primary">Buscar</button>
            </div>

            <div class="col-md-2 mb-2">
                <button onclick="limpiarFiltro()"
                    class="btn btn-block bg-gradient-secondary">Limpiar</button>
            </div>

        </div>
    </div>
</div>

<!-- ===================== TABLA ===================== -->
<div class="card mt-3">
    <table id="example2" class="table table-bordered table-striped table-responsive">
        <thead>
            <tr>
                <th><?= $titulocampobd1P ?></th>
                <th><?= $titulocampobd2P ?></th>
                <th><?= $titulocampobd3P ?></th>
                <th><?= $titulocampobd4P ?></th>
                <th><?= $titulocampobd6P ?></th>
                <th><?= $titulocampobd7P ?></th>
                <th><?= $titulocampobd8P ?></th>
                <th><?= $titulocampobd9P ?></th>
                <th><?= $titulocampobd10P ?></th>
            </tr>
        </thead>

        <tbody>
            <?php while ($row = $getAllMotoTaxy->fetch_assoc()): ?>
                <tr>
                    <td><?= $row[$titulocampobd1] ?></td>
                    <td><?= $row[$titulocampobd2] ?></td>
                    <td><?= $row[$titulocampobd3] ?></td>

                    <?php
                    $accion = $row[$titulocampobd4]; // 👈 DEFINIR PRIMERO
                    $mapAccion = [
                        'INSERT' => '<strong style="color:#1e7e34;">AÑADIÓ</strong>',
                        'UPDATE' => '<strong style="color:#0b5ed7;">ACTUALIZÓ</strong>'
                    ];
                    ?>

                    <td data-accion="<?= htmlspecialchars($accion) ?>">
                        <?= $mapAccion[$accion] ?? htmlspecialchars($accion) ?>
                    </td>



                    <td><?= $row[$titulocampobd6] ?></td>
                    <td><?= $row[$titulocampobd7] ?></td>
                    <td><?= $row[$titulocampobd8] ?></td>
                    <td><?= $row[$titulocampobd9] ?></td>
                    <td><?= $row[$titulocampobd10] ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- DataTables -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>


<script>
    let tabla;

    $(document).ready(function() {

        tabla = $('#example2').DataTable({
            responsive: true,
            autoWidth: false,
            lengthChange: true,
            searching: true,
            info: true,
            paging: true,
            dom: 'Bfrtip', // 👈 habilita botones
            buttons: [{
                extend: 'excelHtml5',
                text: 'Exportar a Excel',
                className: 'btn btn-success',
                title: 'Auditoría de Actividades',
                exportOptions: {
                    columns: ':visible' // exporta solo columnas visibles
                }
            }],
            language: {
                search: "Buscar:",
                lengthMenu: "Mostrar _MENU_ registros",
                info: "Mostrando _START_ a _END_ de _TOTAL_ registros",
                infoEmpty: "Mostrando 0 a 0 de 0 registros",
                infoFiltered: "(filtrado de _MAX_ registros totales)",
                zeroRecords: "No se encontraron resultados",
                emptyTable: "No hay datos disponibles en la tabla",
                paginate: {
                    first: "Primero",
                    previous: "Anterior",
                    next: "Siguiente",
                    last: "Último"
                }
            },
            order: [
                [0, 'desc']
            ]
        });

        // 🔥 Filtro compuesto Área AND Acción
        $.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {

            const areaFiltro = $('#areasFiltro').val();
            const accionFiltro = $('#accionFiltro').val();

            const areaTabla = data[2]; // Área = columna 2
            const filaNodo = tabla.row(dataIndex).node();
            const accionTabla = $(filaNodo).find('td[data-accion]').data('accion');

            const cumpleArea = !areaFiltro ||
                areaFiltro === 'Todos' ||
                areaTabla === areaFiltro;

            const cumpleAccion = !accionFiltro ||
                accionTabla === accionFiltro;

            return cumpleArea && cumpleAccion;
        });

    });

    // Buscar
    function filtrarTabla() {
        if (tabla) tabla.draw();
    }

    // Limpiar
    function limpiarFiltro() {
        $('#areasFiltro').val('Todos');
        $('#accionFiltro').val('');
        if (tabla) tabla.draw();
    }
</script>