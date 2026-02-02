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

      <form class="form-horizontal" method="POST" action="actividades_modal_edit_f.php" enctype="multipart/form-data">
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
                class="form-control"
                oninput="soloLetras(this)">
            </div>

            <div class="col-sm-4">
              <label><?php echo $titulocampobd13P ?? 'Apellido Paterno'; ?></label>
              <input type="text"
                name="<?php echo $titulocampobd13; ?>"
                id="edit_<?php echo $titulocampobd13; ?>"
                class="form-control"
                oninput="soloLetras(this)">
            </div>

            <div class="col-sm-4">
              <label><?php echo $titulocampobd14P ?? 'Apellido Materno'; ?></label>
              <input type="text"
                name="<?php echo $titulocampobd14; ?>"
                id="edit_<?php echo $titulocampobd14; ?>"
                class="form-control"
                oninput="soloLetras(this)">
            </div>


          </div>
          <script>
            function soloLetras(input) {
              input.value = input.value.replace(/[^a-zA-ZÁÉÍÓÚáéíóúÑñ\s]/g, '');
            }
          </script>


          <div class="form-group row">

            <div class="col-sm-12">
              <label><?php echo $titulocampobd6P; ?></label>
              <textarea
                name="<?php echo $titulocampobd6; ?>"
                id="edit_<?php echo $titulocampobd6; ?>"
                class="form-control"
                rows="3"></textarea>
            </div>


          </div>

          <div class="form-group row">

            <div class="col-sm-4">
              <label><?php echo $titulocampobd7P; ?></label>
              <input type="date"
                name="<?php echo $titulocampobd7; ?>"
                id="edit_<?php echo $titulocampobd7; ?>"
                class="form-control">
            </div>

            <div class="col-sm-4">
              <label><?php echo $titulocampobd9P; ?></label>
              <input type="date"
                name="<?php echo $titulocampobd9; ?>"
                id="edit_<?php echo $titulocampobd9; ?>"
                class="form-control">
            </div>


            <div class="col-sm-4">
              <label><?php echo $titulocampobd10P; ?></label>
              <select name="estado_id" id="edit_estado_id" class="form-control" required>
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

          <div class="form-group row">

            <!-- CHECK REPROGRAMAR -->
            <div class="col-sm-4">
              <div class="form-check mt-4">
                <input
                  class="form-check-input"
                  type="checkbox"
                  id="check_reprogramar"
                  name="check_reprogramar"
                  value="1">
                <label class="form-check-label" for="check_reprogramar">
                  Reprogramar fecha
                </label>
              </div>
            </div>

            <!-- FECHA REPROGRAMADA -->
            <div class="col-sm-4" id="contenedor_fecha_reprogramada" style="display:none;">
              <label><?php echo $titulocampobd11P; ?></label>
              <input
                type="date"
                name="<?php echo $titulocampobd11; ?>"
                id="edit_<?php echo $titulocampobd11; ?>"
                class="form-control">
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