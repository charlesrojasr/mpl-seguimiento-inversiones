<!-- Filtro principal por Proyecto -->
<div class="card">
    <div class="card-header">Selecciona la Innversión:</div>
    <div class="card-body">
        <div class="row">

            <!-- Select Proyecto -->
            <div class="col-md-8 mb-2">
                <select id="proyectoFiltro" class="form-control">
                    <option value="">Selecciona</option>

                    <?php
                    // Obtener proyectos
                    $proyectos = [];

                    $q = $conn->query("SELECT nombre FROM inversiones_seg_proyecto ORDER BY nombre");

                    while ($row = $q->fetch_assoc()) {
                        echo '<option value="' . $row['nombre'] . '">' . $row['nombre'] . '</option>';
                    }
                    ?>
                </select>
            </div>

            <!-- Buscar -->
            <div class="col-md-2 mb-2">
                <button onclick="buscarTabla()" class="btn btn-primary w-100">
                    Buscar
                </button>
            </div>

            <!-- Limpiar -->
            <div class="col-md-2 mb-2">
                <button onclick="limpiarFiltros()" class="btn btn-secondary w-100">
                    Limpiar
                </button>
            </div>

        </div>
    </div>
</div>


<!-- GRAFICO DE AVANCE POR PROYECTO -->
<div class="card bg-gradient mb-3" id="graficaAvance" style="display:none;">
    <div class="card-header border-0">
        <h3 class="card-title">
            <i class="fas fa-chart-line mr-1"></i>
            Avance del Proyecto (%)
        </h3>
    </div>

    <div class="card-body">
        <canvas id="line-chart"
            style="min-height:250px;height:250px;max-height:250px;max-width:100%;">
        </canvas>
    </div>

    <div class="card-footer bg-transparent">
        <div class="row mb-3">
            <h3 class="card-title">
                <i class="fas fa-chart-pie mr-1"></i>
                Avance por Etapa (%)
            </h3>
        </div>
        <div class="row">
            <div class="col-12 col-md-4 text-center mb-3">
                <div style="height:160px; position:relative;">
                    <canvas id="dona-etapa-1"></canvas>
                </div>
                <div class="mt-2 font-weight-bold">Requerimiento y actos preparatorios</div>
            </div>

            <div class="col-12 col-md-4 text-center mb-3">
                <div style="height:160px; position:relative;">
                    <canvas id="dona-etapa-2"></canvas>
                </div>
                <div class="mt-2 font-weight-bold">Proceso de convocatoria en el SEACE</div>
            </div>

            <div class="col-12 col-md-4 text-center mb-3">
                <div style="height:160px; position:relative;">
                    <canvas id="dona-etapa-3"></canvas>
                </div>
                <div class="mt-2 font-weight-bold">Ejecución contractual</div>
            </div>


        </div>

    </div>
</div>



<div class="card mt-2" id="filtrosSecundarios" style="display:none;">
    <div class="card-body">
        <div class="row">

            <div class="col-md-4 mb-2">
                <label for="inputEmail3" class="col-form-label">Etapa:</label>
                <select id="etapaFiltro" class="form-control">
                    <option value="">Etapa</option>
                </select>
            </div>

            <div class="col-md-4 mb-2">
                <label for="inputEmail3" class="col-form-label">Unidad Orgánica:</label>
                <select id="areaFiltro" class="form-control">
                    <option value="">Área</option>
                </select>
            </div>

            <div class="col-md-4 mb-2">
                <label for="inputEmail3" class="col-form-label">Estado:</label>
                <select id="estadoFiltro" class="form-control">
                    <option value="">Estado</option>
                </select>
            </div>

        </div>
    </div>
</div>



<!-- Tabla de datos -->
<div class="card mt-3" id="tablaDatos" style="display:none;">

    <table id="example1" class="table table-bordered table-striped">
        <thead>
            <tr>

                <th><?php echo $titulocampobd1P; ?></th>
                <th hidden><?php echo $titulocampobd2P; ?></th>
                <th><?php echo $titulocampobd3P; ?></th>
                <th><?php echo $titulocampobd4P; ?></th>
                <th hidden><?php echo $titulocampobd5P; ?></th>
                <th><?php echo $titulocampobd6P; ?></th>
                <th><?php echo $titulocampobd7P; ?></th>
                <th><?php echo $titulocampobd8P; ?></th>
                <th><?php echo $titulocampobd9P; ?></th>
                <th><?php echo $titulocampobd10P; ?></th>
                <th><?php echo $titulocampobd15P; ?></th>
                <th><?php echo $titulocampobd11P; ?></th>
                <th><?php echo $titulocampobd16P; ?></th>

            </tr>
        </thead>
        <tbody>
            <?php while ($motoTaxy = $getAllMotoTaxy->fetch_assoc()) { ?>
                <tr>
                    <td>
                        <?php echo $motoTaxy["$titulocampobd1"]; ?>
                        <?php if ($_SESSION['role_id'] == 1 || $_SESSION['role_id'] == 2): ?>
                            <button class="btn btn-primary btn-block edit mb-1"
                                data-id="<?php echo $motoTaxy[$titulocampobd1]; ?>">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </button>
                        <?php endif; ?>


                        <button class="btn btn-info btn-block btn-auditoria"
                            data-id="<?php echo $motoTaxy[$titulocampobd1]; ?>">
                            <i class="fa-solid fa-clock-rotate-left"></i>
                        </button>



                    </td>
                    <td hidden><?php echo $motoTaxy["$titulocampobd2"]; ?></td>
                    <td><?php echo $motoTaxy["$titulocampobd3"]; ?></td>
                    <td><?php echo $motoTaxy["$titulocampobd4"]; ?></td>
                    <td hidden><?php echo $motoTaxy["$titulocampobd5"]; ?></td>
                    <td><?php echo $motoTaxy["$titulocampobd6"]; ?></td>
                    <td style="white-space: nowrap;">
                        <?php
                        if (!empty($motoTaxy[$titulocampobd7])) {
                            echo date('d/m/Y', strtotime($motoTaxy[$titulocampobd7]));
                        }
                        ?>
                    </td>
                    <td>
                        <?php
                        $dias = $motoTaxy[$titulocampobd8];
                        $tipo = $motoTaxy[$titulocampobd17] ?? null;

                        if ($tipo == 1) {
                            $tipoTexto = "Calendario";
                        } elseif ($tipo == 2) {
                            $tipoTexto = "Hábiles";
                        } else {
                            $tipoTexto = "";
                        }

                        echo $dias;

                        if (!empty($tipoTexto)) {
                            echo " | " . $tipoTexto;
                        }
                        ?>
                    </td>

                    <td style="white-space: nowrap;">
                        <?php
                        if (!empty($motoTaxy[$titulocampobd9])) {
                            echo date('d/m/Y', strtotime($motoTaxy[$titulocampobd9]));
                        }
                        ?>
                    </td>
                    <td>
                        <?php
                        $estado = $motoTaxy[$titulocampobd10];

                        // Normalizamos para evitar errores
                        $estadoNormalizado = strtolower(trim($estado));

                        $claseEstado = '';

                        switch ($estadoNormalizado) {
                            case 'completado':
                                $claseEstado = 'estado-completado';
                                break;

                            case 'sin iniciar':
                                $claseEstado = 'estado-sin-iniciar';
                                break;

                            case 'atrasado':
                                $claseEstado = 'estado-atrasado';
                                break;

                            case 'en proceso':
                                $claseEstado = 'estado-enproceso';
                                break;

                            case 'reprogramado':
                                $claseEstado = 'estado-programado';
                                break;
                        }
                        ?>

                        <span class="estado-pill <?php echo $claseEstado; ?>">
                            <?php echo htmlspecialchars($estado); ?>
                        </span>
                    </td>

                    <td style="white-space: nowrap;">
                        <?php if (!empty($motoTaxy[$titulocampobd15])): ?>
                            <span class="estado-pill" style="background:#de0707;">
                                <?php echo date('d/m/Y', strtotime($motoTaxy[$titulocampobd15])); ?>
                            </span>
                        <?php endif; ?>
                    </td>



                    <td style="white-space: nowrap;">
                        <?php if (!empty($motoTaxy[$titulocampobd11])): ?>
                            <span class="estado-pill" style="background:#de0707;">
                                <?php echo date('d/m/Y', strtotime($motoTaxy[$titulocampobd11])); ?>
                            </span>
                        <?php endif; ?>
                    </td>
                    <td><?php echo $motoTaxy["$titulocampobd16"]; ?></td>

                </tr>


            <?php } ?>
        </tbody>
    </table>