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

    <table id="example1" class="table table-bordered table-striped table-responsive">
        <thead>
            <tr>

                <th><?php echo $titulocampobd1P; ?></th>
                <th hidden><?php echo $titulocampobd2P; ?></th>
                <th><?php echo $titulocampobd3P; ?></th>
                <th><?php echo $titulocampobd4P; ?></th>
                <th><?php echo $titulocampobd5P; ?></th>
                <th><?php echo $titulocampobd6P; ?></th>
                <th><?php echo $titulocampobd7P; ?></th>
                <th><?php echo $titulocampobd8P; ?></th>
                <th><?php echo $titulocampobd9P; ?></th>
                <th><?php echo $titulocampobd10P; ?></th>
                <th><?php echo $titulocampobd15P; ?></th>
                <th><?php echo $titulocampobd11P; ?></th>

            </tr>
        </thead>
        <tbody>
            <?php while ($motoTaxy = $getAllMotoTaxy->fetch_assoc()) { ?>
                <tr>
                    <td>
                        <?php echo $motoTaxy["$titulocampobd1"]; ?>
                        <button class="btn btn-primary btn-block edit" data-id="<?php echo $motoTaxy[$titulocampobd1]; ?>">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </button>

                    </td>
                    <td hidden><?php echo $motoTaxy["$titulocampobd2"]; ?></td>
                    <td><?php echo $motoTaxy["$titulocampobd3"]; ?></td>
                    <td><?php echo $motoTaxy["$titulocampobd4"]; ?></td>
                    <td><?php echo $motoTaxy["$titulocampobd5"]; ?></td>
                    <td><?php echo $motoTaxy["$titulocampobd6"]; ?></td>
                    <td style="white-space: nowrap;">
                        <?php
                        if (!empty($motoTaxy[$titulocampobd7])) {
                            echo date('d/m/Y', strtotime($motoTaxy[$titulocampobd7]));
                        }
                        ?>
                    </td>
                    <td><?php echo $motoTaxy["$titulocampobd8"]; ?></td>
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

                </tr>


            <?php } ?>
        </tbody>
    </table>