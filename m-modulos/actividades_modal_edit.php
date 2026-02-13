<div class="modal fade" id="edit">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <center>
          <h4 class="modal-title">EDITAR ACTIVIDAD</h4>
        </center>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <form class="form-horizontal" method="POST" action="actividades_modal_edit_f.php" enctype="multipart/form-data" onsubmit="guardarFiltrosActuales()">
        <div class="modal-body">

          <input type="hidden" name="id" class="empid">


          <div class="form-group row">
            <!-- ACTIVIDAD -->
            <div class="col-sm-12">
              <div class="form-group">
                <label class="col-form-label"><?php echo $titulocampobd4P; ?></label>

                <select name="area_id" id="edit_area_id" class="form-control" required>
                  <option value="">SELECCIONAR</option>
                  <?php
                  include 'actividades_obtener_estados.php';
                  $areas = obtenerAreasConId();
                  foreach ($areas as $area) {
                    echo '<option value="' . (int)$area['id'] . '">'
                      . htmlspecialchars($area['nombre'])
                      . '</option>';
                  }
                  ?>
                </select>
              </div>
            </div>

          </div>

          <div class="form-group row">

            <div class="col-sm-4">
              <label><?php echo $titulocampobd12P ?? 'Nombre'; ?></label>
              <input type="text"
                name="<?php echo $titulocampobd12; ?>"
                id="edit_<?php echo $titulocampobd12; ?>"
                class="form-control editable-area"
                oninput="soloLetras(this)">
            </div>

            <div class="col-sm-4">
              <label><?php echo $titulocampobd13P ?? 'Apellido Paterno'; ?></label>
              <input type="text"
                name="<?php echo $titulocampobd13; ?>"
                id="edit_<?php echo $titulocampobd13; ?>"
                class="form-control editable-area"
                oninput="soloLetras(this)">
            </div>

            <div class="col-sm-4">
              <label><?php echo $titulocampobd14P ?? 'Apellido Materno'; ?></label>
              <input type="text"
                name="<?php echo $titulocampobd14; ?>"
                id="edit_<?php echo $titulocampobd14; ?>"
                class="form-control editable-area"
                oninput="soloLetras(this)">
            </div>


          </div>

          <script>
            function soloLetras(input) {
              input.value = input.value.replace(/[^a-zA-ZÁÉÍÓÚáéíóúÑñ\s]/g, '');
            }
          </script>


          <div class="form-group row">

            <div class="col-sm-8">
              <label><?php echo $titulocampobd6P; ?></label>
              <textarea
                name="<?php echo $titulocampobd6; ?>"
                id="edit_<?php echo $titulocampobd6; ?>"
                class="form-control editable-area"
                rows="3"></textarea>
            </div>

            <div class="col-sm-4">
              <label><?php echo $titulocampobd8P; ?></label>
              <input type="number"
                name="<?php echo $titulocampobd8; ?>"
                id="edit_<?php echo $titulocampobd8; ?>"
                class="form-control editable-area">
            </div>
          </div>

          <div class="form-group row">

            <div class="col-sm-4">
              <label><?php echo $titulocampobd7P; ?></label>
              <input type="date"
                name="<?php echo $titulocampobd7; ?>"
                id="edit_<?php echo $titulocampobd7; ?>"
                class="form-control editable-area">
            </div>

            <div class="col-sm-4">
              <label><?php echo $titulocampobd9P; ?></label>
              <input type="date"
                name="<?php echo $titulocampobd9; ?>"
                id="edit_<?php echo $titulocampobd9; ?>"
                class="form-control editable-area">
            </div>


            <div class="col-sm-4">
              <label><?php echo $titulocampobd10P; ?></label>
              <select name="estado_id" id="edit_estado_id" class="form-control editable-area" required>
                <option value="">SELECCIONAR</option>
                <?php
                $estados = obtenerEstados();
                foreach ($estados as $e) {
                  echo '<option value="' . $e['id'] . '">' . htmlspecialchars($e['descripcion']) . '</option>';
                }
                ?>
              </select>
            </div>
          </div>

          <div class="form-group row mt-3">

            <!-- COLUMNA 1 : CHECKBOX -->
            <div class="col-sm-4">

              <div class="form-check mt-4">
                <input
                  class="form-check-input editable-area"
                  type="checkbox"
                  id="check_reprogramar">

                <label class="form-check-label" for="check_reprogramar">
                  ¿Reprogramar?
                </label>
              </div>

            </div>


            <!-- COLUMNA 2 : RADIOS -->
            <div class="col-sm-4">

              <div id="contenedor_radios" style="display:none;">

                <label><strong>Tipo de reprogramación</strong></label>

                <!-- AMBAS PRIMERO -->
                <div class="form-check">
                  <input class="form-check-input editable-area"
                    type="radio"
                    name="tipo_reprogramacion"
                    id="opcion2"
                    value="ambas">

                  <label class="form-check-label editable-area" for="opcion2">
                    Reprogramar Fecha inicio + Fecha Fin
                  </label>
                </div>

                <div class="form-check">
                  <input class="form-check-input editable-area"
                    type="radio"
                    name="tipo_reprogramacion"
                    id="opcion1"
                    value="solo">

                  <label class="form-check-label editable-area" for="opcion1">
                    Reprogramar Fecha Fin
                  </label>
                </div>



              </div>

            </div>


            <!-- COLUMNA 3 : FECHAS -->
            <div class="col-sm-4">

              <div id="contenedor_fechas" style="display:none;">

                <!-- FECHA FIN -->
                <div class="mb-2">
                  <label><?php echo $titulocampobd11P; ?></label>
                  <input
                    type="date"
                    name="<?php echo $titulocampobd11; ?>"
                    id="edit_<?php echo $titulocampobd11; ?>"
                    class="form-control editable-area">
                </div>

                <!-- FECHA INICIO -->
                <div id="contenedor_fecha2" style="display:none;">
                  <label><?php echo $titulocampobd15P; ?></label>
                  <input
                    type="date"
                    name="<?php echo $titulocampobd15; ?>"
                    id="edit_<?php echo $titulocampobd15; ?>"
                    class="form-control editable-area">
                </div>

              </div>

            </div>

          </div>

          <!-- FILA OBSERVACION REPROGRAMACION -->
          <div class="form-group row mt-3" id="row_observacion_reprog" style="display:none;">

            <div class="col-sm-12">

              <label>
                <?php echo $titulocampobd16P ?? 'Observación'; ?>
              </label>

              <textarea
                name="<?php echo $titulocampobd16; ?>"
                id="edit_<?php echo $titulocampobd16; ?>"
                class="form-control editable-area mb-2"
                rows="3"
                placeholder="Ingrese observación de la reprogramación"></textarea>

              <!-- BOTON LIMPIAR -->
              <button
                type="button"
                class="btn btn-sm btn-outline-secondary editable-area"
                id="btn_limpiar_observacion">

                <i class="fa fa-eraser "></i> Limpiar observación

              </button>

            </div>

          </div>




        </div>

        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
          <button type="submit" name="edit" class="btn btn-primary">Guardar</button>
        </div>


      </form>
    </div>
  </div>
</div>