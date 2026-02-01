<?php
// Incluir el archivo de conexión y funciones para obtener las áreas
include('actividades_buscar_areas.php'); // Asegúrate de que la ruta sea correcta

// Obtener las áreas para el filtro
$areas = obtenerAreas();
?>

<?php if ($role_id == 1): ?>
    <!-- Filtro principal por área -->
    <div class="card">
        <div class="card-header">Selecciona el área:</div>
        <div class="card-body">
            <div class="form-group align-items-center">
                <div class="row">

                    <!-- Filtro por Área -->
                    <div class="col-md-8 pr-md-1 mb-2 mb-md-0">
                        <select id="areasFiltro" class="form-control">
                            <option value="">Selecciona</option>
                            <option value="Todos">Todos</option>
                            <?php
                            // Mostrar las áreas obtenidas en el select
                            foreach ($areas as $area) {
                                echo '<option value="' . $area . '">' . $area . '</option>';
                            }
                            ?>
                        </select>
                    </div>

                    <!-- Botón de búsqueda -->
                    <div class="col-md-2 pr-md-1 d-flex align-items-center mb-2 mb-md-0">
                        <button id="btnBuscar" onclick="filtrarTabla()"
                            class="btn btn-block bg-gradient-primary w-100">Buscar</button>
                    </div>

                    <!-- Botón de limpiar -->
                    <div class="col-md-2 pr-md-1 d-flex align-items-center mb-2 mb-md-0">
                        <button id="btnLimpiar" onclick="limpiarFiltro()"
                            class="btn btn-block bg-gradient-secondary w-100">Limpiar</button>
                    </div>

                </div>
            </div>
        </div>
    </div>
<?php endif; ?>







<!-- Cards de estado general -->
<div class="card">
    <div class="card-header">Estado</div>
    <div class="card-body">
        <div class="row">
            <!-- Card de cantidad de registros -->
            <div class="col-md-3">
                <div class="card text-white bg-info mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Total Actividades</h5>
                        <p id="cantidadRegistros" class="card-text" style="font-size: 24px; font-weight: bold;">0</p>
                        <i class="fas fa-list-alt" style="font-size: 24px;"></i>
                    </div>
                </div>
            </div>

            <!-- Card de porcentaje promedio -->
            <div class="col-md-3">
                <div class="card text-white bg-secondary mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Promedio Avance</h5>
                        <p id="porcentajePromedio" class="card-text" style="font-size: 24px; font-weight: bold;">0%</p>
                        <i class="fas fa-percent" style="font-size: 24px;"></i>
                    </div>
                </div>
            </div>

            <!-- Card de cantidad completado -->
            <div class="col-md-3">
                <div class="card text-white bg-success mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Completadas</h5>
                        <p id="cantidadCompletado" class="card-text" style="font-size: 24px; font-weight: bold;">0</p>
                        <i class="fas fa-check-circle" style="font-size: 24px;"></i>
                    </div>
                </div>
            </div>

            <!-- Card de cantidad de otra estrategia -->
            <div class="col-md-3">
                <div class="card text-white bg-purple mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Otra Estrategia</h5>
                        <p id="cantidadOtraEstrategia" class="card-text" style="font-size: 24px; font-weight: bold;">0
                        </p>
                        <i class="fas fa-chart-pie" style="font-size: 24px;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Gráfico circular + tabla de estados -->
<div class="card mt-3" id="graficoCircularCard" style="display: none;">
    <div class="card-header">Estatus de Actividades 2</div>
    <div class="card-body row">

        <!-- Gráfico Circular -->
        <div class="col-md-6 p-2 d-flex justify-content-center align-items-center">
            <canvas id="estadoChart" width="200" height="200"></canvas>
        </div>

        <!-- Tabla de Estado y Cantidad de Registros -->
        <div class="col-md-6">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Estado</th>
                        <th>Cantidad de Registros</th>
                    </tr>
                </thead>
                <tbody id="estadoTabla">
                    <tr>
                        <td>
                            <span id="completadosColor"
                                style="display:inline-block;width:10px;height:10px;background-color:rgb(16,185,129);"></span>
                            Completados
                        </td>
                        <td id="completadosCantidad">10</td>
                    </tr>
                    <tr>
                        <td>
                            <span id="enProgresoColor"
                                style="display:inline-block;width:10px;height:10px;background-color:rgb(255, 183, 0);"></span>
                            En proceso
                        </td>
                        <td id="enProgresoCantidad">0</td>
                    </tr>

                    <tr>
                        <td>
                            <span id="enPendienteColor"
                                style="display:inline-block;width:10px;height:10px;background-color:rgb(255,99,71);"></span>
                            Pendiente
                        </td>
                        <td id="enPendienteCantidad">0</td>
                    </tr>

                    <tr>
                        <td>
                            <span id="sinIniciarColor"
                                style="display:inline-block;width:10px;height:10px;background-color:rgb(139, 0, 0);"></span>
                            Sin iniciar
                        </td>
                        <td id="sinIniciarCantidad">2</td>
                    </tr>
                    <tr>
                        <td>
                            <span id="otraEstrategiaColor"
                                style="display:inline-block;width:10px;height:10px;background-color:rgb(139,92,246);"></span>
                            Otra Estrategia
                        </td>
                        <td id="otraEstrategiaCantidad">2</td>
                    </tr>
                </tbody>


            </table>
        </div>

    </div>
</div>

<!-- Canvas para el gráfico de barras -->
<div class="card mt-3" id="graficoCard" style="display: none;">
    <div class="card-header">Avance por Actividad</div>
    <div class="card-body">
        <canvas id="actividadChart" width="400" height="100"></canvas>
    </div>
</div>

<!-- Tabla de datos (oculta inicialmente) -->
<div class="card mt-3" id="tablaDatos" style="display: none;">
    <table id="example1" class="table table-bordered table-striped table-responsive">
        <thead>
            <tr>
                <th><?php echo $titulocampobd1P; ?></th>
                <th><?php echo $titulocampobd2P; ?></th>
                <th><?php echo $titulocampobd3P; ?></th>
                <th><?php echo $titulocampobd8P; ?></th>
                <th><?php echo $titulocampobd9P; ?></th>
                <th><?php echo $titulocampobd10P; ?></th>
                <th><?php echo $titulocampobd4P; ?></th>
                <th><?php echo $titulocampobd5P; ?></th>
                <th><?php echo $titulocampobd6P; ?></th>
            </tr>
        </thead>
        <tbody>
            <?php while ($motoTaxy = $getAllMotoTaxy->fetch_assoc()) { ?>
                <tr>
                    <td>
                        <?php echo $motoTaxy["$titulocampobd1"]; ?>
                        <button style="margin-top:0;margin-bottom:10px;width:35px;"
                            class="btn btn-primary btn-block w-100 edit"
                            data-id="<?php echo $motoTaxy["$titulocampobd1"]; ?>"
                            onclick="funcionX(<?php echo $motoTaxy["$titulocampobd1"]; ?>)">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </button>
                    </td>
                    <td><?php echo $motoTaxy["$titulocampobd2"]; ?></td>
                    <td><?php echo $motoTaxy["$titulocampobd3"]; ?></td>
                    <td><?php echo $motoTaxy["$titulocampobd8"]; ?></td>
                    <td><?php echo $motoTaxy["$titulocampobd9"]; ?></td>
                    <td><?php echo $motoTaxy["$titulocampobd10"]; ?></td>
                    <td><?php echo $motoTaxy["$titulocampobd4"]; ?></td>
                    <td style="text-align:center;padding:10px;">
                        <?php
                        $avance = $motoTaxy["$titulocampobd5"]; // Porcentaje de avance
                        $estado = $motoTaxy["$titulocampobd6"]; // Estado
                        $color_avance = 'rgb(239, 68, 68)';
                        $barra = 'width: 0%;';

                        if ($estado == 'Completado') {
                            $color_avance = 'rgb(16,185,129)';
                            $barra = 'width: 100%;';
                        } elseif ($estado == 'En proceso') {
                            $color_avance = 'rgb(255, 183, 0)';
                            $barra = 'width: ' . $avance . '%;';
                        } elseif ($estado == 'Pendiente') {
                            $color_avance = 'rgb(255,99,71)';
                            $barra = 'width: ' . $avance . '%;';
                        } elseif ($estado == 'Sin Iniciar') {
                            $color_avance = 'rgb(139, 0, 0)';
                            $barra = 'width: 0%;';
                        } elseif ($estado == 'Otra estrategia') {
                            $color_avance = 'rgb(139, 92, 246)';
                            $barra = 'width: ' . $avance . '%;';
                        }

                        echo '<div style="font-size:16px;color:' . $color_avance . ';margin-bottom:5px;">' . $avance . '%</div>';
                        echo '<div class="progress" style="height:15px;background-color:#e0e0e0;border-radius:5px;width:100%;">';
                        echo '<div class="progress-bar progress-bar-striped" style="background-color:' . $color_avance . ';' . $barra . '"></div>';
                        echo '</div>';
                        ?>
                    </td>

                    <td style="text-align:center;padding:10px;">
                        <?php
                        $color_estado = 'rgb(239, 68, 68)';
                        if ($estado == 'Completado') {
                            $color_estado = 'rgb(16,185,129)';
                        } elseif ($estado == 'En proceso') {
                            $color_estado = 'rgb(255, 183, 0)';
                        } elseif ($estado == 'Pendiente') {
                            $color_estado = 'rgb(255,99,71)';
                        } elseif ($estado == 'Sin iniciar') {
                            $color_estado = 'rgb(139, 0, 0)';
                        } elseif ($estado == 'Otra estrategia') {
                            $color_estado = 'rgb(139, 92, 246)';
                        }
                        echo '<span style="border:2px solid ' . $color_estado . ';border-radius:50px;padding:5px 15px;background-color:' . $color_estado . ';color:white;display:inline-block;width:100%;text-align:center;">' . $estado . '</span>';
                        ?>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<style>
    .progress {
        height: 15px;
        background-color: #e0e0e0;
        border-radius: 5px;
        width: 100%;
    }

    .progress-bar {
        height: 100%;
        border-radius: 5px;
        text-align: center;
        color: white;
    }

    td {
        padding: 10px;
        vertical-align: middle;
    }

    td span {
        display: inline-block;
        width: 100%;
        text-align: center;
        border-radius: 50px;
        padding: 5px 15px;
        color: white;
        font-size: 14px;
    }
</style>

<script>
    const USER_ROLE_ID = <?php echo (int)$role_id; ?>;
</script>


<script>
    /* ============================
       GRÁFICO CIRCULAR
       ============================ */
    function generarGraficoCircular(labels, data, colores) {
        var estadoChart = document.getElementById('estadoChart');

        estadoChart.width = 200;
        estadoChart.height = 200;
        estadoChart.style.width = '200px';
        estadoChart.style.height = '200px';

        var ctx = estadoChart.getContext('2d');

        if (window.chartInstanceCircular) {
            window.chartInstanceCircular.destroy();
        }

        window.chartInstanceCircular = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Estado de Actividades',
                    data: data,
                    backgroundColor: colores,
                    borderColor: colores,
                    borderWidth: 1
                }]
            },
            options: {
                responsive: false,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            label: function(tooltipItem) {
                                return tooltipItem.label + ": " + tooltipItem.raw + " registros";
                            }
                        }
                    }
                }
            }
        });

        document.getElementById("graficoCircularCard").style.display = "block";
    }

    /* ============================
       GRÁFICO DE BARRAS
       ============================ */
    function generarGraficoBarras(labels, data, colores) {
        var ctx = document.getElementById('actividadChart').getContext('2d');
        if (window.chartInstance) {
            window.chartInstance.destroy();
        }
        window.chartInstance = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Porcentaje de Actividad',
                    data: data,
                    backgroundColor: colores,
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 100
                    }
                }
            }
        });
        document.getElementById("graficoCard").style.display = "block";
    }

    /* ============================
       ACTUALIZAR CARDS (solo por ÁREA)
       ============================ */
    function actualizarCards(areaFiltro) {
        var xhr = new XMLHttpRequest();
        xhr.open("GET", "consulta_cards.php?area=" + encodeURIComponent(areaFiltro), true);

        xhr.onload = function() {
            if (xhr.status == 200) {
                var datos = JSON.parse(xhr.responseText);

                if (datos) {
                    document.getElementById('cantidadRegistros').textContent =
                        datos.cantidad_registros || 0;

                    var porcentajePromedio = parseFloat(datos.porcentaje_promedio) || 0;
                    document.getElementById('porcentajePromedio').textContent =
                        porcentajePromedio.toFixed(2) + '%';

                    var porcentajeColor = 'rgb(239, 68, 68)'; // Color por defecto

                    if (porcentajePromedio === 0) {
                        porcentajeColor = 'rgb(139, 0, 0)'; // Si el porcentaje es 0
                    } else if (porcentajePromedio >= 1 && porcentajePromedio <= 49) {
                        porcentajeColor = 'rgb(255,99,71)'; // Si el porcentaje está entre 1 y 49
                    } else if (porcentajePromedio > 49 && porcentajePromedio <= 99) {
                        porcentajeColor = 'rgb(255, 183,0)'; // Si el porcentaje está entre 50 y 99
                    } else if (porcentajePromedio >= 100) {
                        porcentajeColor = 'rgb(16,185,129)'; // Si el porcentaje es mayor o igual a 100
                    }


                    document.getElementById('porcentajePromedio').style.color = porcentajeColor;

                    document.getElementById('cantidadCompletado').textContent =
                        datos.cantidad_completado || 0;
                    document.getElementById('cantidadOtraEstrategia').textContent =
                        datos.cantidad_otra_estrategia || 0;

                    var completados = datos.cantidad_completado || 0;
                    var enProgreso = datos.cantidad_en_progreso || 0;
                    var enPendiente = datos.cantidad_en_pendiente || 0;
                    var sinIniciar = datos.cantidad_sin_iniciar || 0;
                    var otraEstrategia = datos.cantidad_otra_estrategia || 0;

                    document.getElementById("completadosCantidad").textContent = completados;
                    document.getElementById("enProgresoCantidad").textContent = enProgreso;
                    document.getElementById("enPendienteCantidad").textContent = enPendiente;
                    document.getElementById("sinIniciarCantidad").textContent = sinIniciar;
                    document.getElementById("otraEstrategiaCantidad").textContent = otraEstrategia;

                    document.getElementById("completadosColor").style.backgroundColor = 'rgb(16, 185, 129)';
                    document.getElementById("enProgresoColor").style.backgroundColor = 'rgb(255, 183, 0)';
                    document.getElementById("enPendienteColor").style.backgroundColor = 'rgb(255,99,71)';
                    document.getElementById("sinIniciarColor").style.backgroundColor = 'rgb(139, 0, 0)';
                    document.getElementById("otraEstrategiaColor").style.backgroundColor = 'rgb(139, 92, 246)';

                    generarGraficoCircular(
                        ['Completados', 'En Progreso', 'Pendiente', 'Sin iniciar', 'Otra Estrategia'],
                        [completados, enProgreso, enPendiente, sinIniciar, otraEstrategia],
                        [
                            'rgb(16, 185, 129)',
                            'rgb(255, 183, 0)',
                            'rgb(255,99,71)',
                            'rgb(139, 0, 0)',
                            'rgb(139, 92, 246)'
                        ]
                    );
                } else {
                    console.error("No se recibieron datos válidos del servidor");
                }
            } else {
                console.error("Error en la solicitud AJAX: " + xhr.status);
            }
        };

        xhr.send();
    }

    /* ============================
       FUNCIÓN PRINCIPAL: FILTRO ÁREA + ESTADO
       ============================ */
    // ✅ ÚNICA función oficial de filtrado
    function filtrarTabla() {
        var areaSelect = document.getElementById('areasFiltro');
        var areaSeleccionada = areaSelect ? areaSelect.value : '';


        var estadoSelect = document.getElementById('estadoFiltroTabla');
        var estadoSeleccionado = estadoSelect ? (estadoSelect.value || '') : '';

        // ============================
        // 🔐 GUARDAR FILTROS (CLAVE)
        // ============================
        if (areaSelect) {
            sessionStorage.setItem('filtro_area', areaSeleccionada);
        }

        if (estadoSelect) {
            sessionStorage.setItem('filtro_estado', estadoSeleccionado || 'todos');
        }


        var areaFiltro = (areaSeleccionada || '').toLowerCase();
        var estadoFiltro = (estadoSeleccionado || '').toLowerCase();

        if (!(window.jQuery && jQuery.fn.dataTable)) {
            console.error("DataTables no está cargado");
            return;
        }

        var dt = jQuery('#example1').DataTable();

        // ============================
        // 1) APLICAR NUEVOS FILTROS
        // ============================
        var searchArea = (areaFiltro === '' || areaFiltro === 'todos') ?
            '' :
            areaSeleccionada;

        var searchEstado = (estadoFiltro === '' || estadoFiltro === 'todos') ?
            '' :
            estadoSeleccionado;

        dt.column(1).search(searchArea); // columna Área
        dt.column(8).search(searchEstado); // columna Estado
        dt.draw();

        // ¿Cuántas filas quedaron con estos NUEVOS filtros?
        var rowCount = dt.rows({
            search: 'applied'
        }).count();

        // ============================
        // 2) SI NO HAY RESULTADOS → NO HACER NADA
        //    (revertir al filtro anterior y SALIR)
        // ============================
        if (rowCount === 0) {
            // Revertimos a los últimos filtros válidos
            var prevArea = lastAreaSeleccionada || '';
            var prevEstado = lastEstadoSeleccionado || 'todos';

            // Guardamos qué se intentó aplicar
            var estadoIntentado = estadoSeleccionado;
            var areaIntentada = areaSeleccionada;

            var prevAreaFiltro = prevArea.toLowerCase();
            var prevEstadoFiltro = prevEstado.toLowerCase();

            var prevSearchArea = (prevAreaFiltro === '' || prevAreaFiltro === 'todos') ?
                '' :
                prevArea;

            var prevSearchEstado = (prevEstadoFiltro === '' || prevEstadoFiltro === 'todos') ?
                '' :
                prevEstado;

            dt.column(1).search(prevSearchArea);
            dt.column(8).search(prevSearchEstado);
            dt.draw();

            // Devolvemos los selects a los valores anteriores
            var selArea = document.getElementById('areasFiltro');
            if (selArea) selArea.value = prevArea;

            if (estadoSelect) estadoSelect.value = prevEstado;

            // ❌ Nada de alert, nada de gráficos nuevos, nada de cards
            // 🔔 Mensaje para el usuario
            //alert("No existen registros con ese estado para esa área.");
            // 3) Mensaje al usuario, usando lo que se intentó filtrar
            var textoArea = (areaIntentada === '' || areaIntentada === 'Todos') ?
                'todas las áreas' :
                'el área "' + areaIntentada + '"';

            var textoEstado = (estadoIntentado === '' || estadoIntentado.toLowerCase() === 'todos') ?
                'todos los estados' :
                'el estado "' + estadoIntentado + '"';

            alert(
                'No existen registros con ' +
                textoEstado +
                ' para ' +
                textoArea +
                '.'
            );

            return;
        }

        // ============================
        // 3) ACTUALIZAMOS "último filtro válido"
        // ============================
        lastAreaSeleccionada = areaSeleccionada;
        lastEstadoSeleccionado = estadoSeleccionado || 'todos';

        // ============================
        // 4) RECORRER FILAS FILTRADAS PARA GRÁFICOS
        // ============================
        var actividadLabels = [];
        var porcentajeValues = [];
        var colores = [];

        var completados = 0;
        var enProgreso = 0;
        var enPendiente = 0;
        var sinIniciar = 0;
        var otraEstrategia = 0;

        dt.rows({
            search: 'applied'
        }).every(function() {
            var fila = this.node();
            if (!fila.cells || fila.cells.length < 9) return;

            // Columna 0: ID
            var actividadId = fila.cells[0].textContent.trim();
            var match = actividadId.match(/\d+/);
            if (match) actividadId = match[0];

            // Columna 7: porcentaje
            var porcentaje = parseFloat(fila.cells[7].textContent.trim()) || 0;
            var progressBar = fila.cells[7].querySelector('.progress-bar');
            var color = progressBar ?
                progressBar.style.backgroundColor :
                'rgba(75, 192, 192, 1)';

            actividadLabels.push("Act. " + actividadId);
            porcentajeValues.push(porcentaje);
            colores.push(color);

            // Columna 8: estado
            var estadoTexto = fila.cells[8].textContent.trim();

            if (estadoTexto === 'Completado') completados++;
            else if (estadoTexto === 'En Progreso') enProgreso++;
            else if (estadoTexto === 'Pendiente') enPendiente++;
            else if (estadoTexto === 'Sin iniciar') sinIniciar++;
            else if (estadoTexto === 'Otra estrategia' || estadoTexto === 'Otra Estrategia')
                otraEstrategia++;
        });

        // Mostrar card de tabla (hay resultados)
        var tablaDatos = document.getElementById('tablaDatos');
        if (tablaDatos) tablaDatos.style.display = '';

        // ============================
        // 5) CARDS + GRÁFICO CIRCULAR (según ÁREA)
        // ============================
        actualizarCards(areaSeleccionada);

        document.getElementById("completadosCantidad").textContent = completados;
        document.getElementById("enProgresoCantidad").textContent = enProgreso;
        document.getElementById("enPendienteCantidad").textContent = enPendiente;
        document.getElementById("sinIniciarCantidad").textContent = sinIniciar;
        document.getElementById("otraEstrategiaCantidad").textContent = otraEstrategia;

        document.getElementById("completadosColor").style.backgroundColor = 'rgb(16, 185, 129)';
        document.getElementById("enProgresoColor").style.backgroundColor = 'rgb(255, 183, 0)';
        document.getElementById("enPendienteColor").style.backgroundColor = 'rgb(255,99,71)';
        document.getElementById("sinIniciarColor").style.backgroundColor = 'rgb(139, 0, 0)';
        document.getElementById("otraEstrategiaColor").style.backgroundColor = 'rgb(139, 92, 246)';

        generarGraficoCircular(
            ['Completados', 'En Progreso', 'Pendiente', 'Sin iniciar', 'Otra Estrategia'],
            [completados, enProgreso, enPendiente, sinIniciar, otraEstrategia],
            [
                'rgb(16, 185, 129)',
                'rgb(255, 183, 0)',
                'rgb(255,99,71)',
                'rgb(139, 0, 0)',
                'rgb(139, 92, 246)'
            ]
        );

        // ============================
        // 6) GRÁFICO DE BARRAS
        // ============================
        generarGraficoBarras(actividadLabels, porcentajeValues, colores);
    }





    function limpiarFiltro() {

        sessionStorage.removeItem('filtro_area');
        sessionStorage.removeItem('filtro_estado');

        document.getElementById('areasFiltro').value = 'Todos';

        var estadoSelect = document.getElementById('estadoFiltroTabla');
        if (estadoSelect) estadoSelect.value = 'todos';

        if (window.jQuery && jQuery.fn.dataTable) {
            var dt = jQuery('#example1').DataTable();
            dt.column(1).search('');
            dt.column(8).search('');
            dt.search('');
            dt.draw();
        }

        window.location.reload();
    }




    /* ============================
       INICIALIZAR DATATABLES + SELECT ESTADO
       ============================ */

    document.addEventListener('DOMContentLoaded', function() {

        var areaGuardada = sessionStorage.getItem('filtro_area');
        var estadoGuardado = sessionStorage.getItem('filtro_estado');

        if (areaGuardada !== null) {
            var selArea = document.getElementById('areasFiltro');
            if (selArea) selArea.value = areaGuardada;
        }

        if (estadoGuardado !== null) {
            var selEstado = document.getElementById('estadoFiltroTabla');
            if (selEstado) selEstado.value = estadoGuardado;
        }

        // Si hay filtros guardados, reaplicarlos
        if (areaGuardada || estadoGuardado) {
            setTimeout(function() {
                filtrarTabla();
            }, 300);
        }

        // Tu lógica existente para role_id = 3
        if (USER_ROLE_ID === 3) {
            setTimeout(function() {
                filtrarTabla();
            }, 300);
        }
    });
</script>