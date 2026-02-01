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
            <div class="col-sm-6">
              <label class="col-form-label"><?php echo $titulocampobd3P; ?></label>
              <textarea
                name="<?php echo $titulocampobd3; ?>"
                class="form-control"
                id="edit_<?php echo $titulocampobd3; ?>"
                rows="3"
                oninput="this.value = this.value.toUpperCase();"
                <?php echo $isAreaUser ? 'readonly' : ''; ?>></textarea>
            </div>

            <!-- INDICADORES -->
            <div class="col-sm-6">
              <label class="col-form-label"><?php echo $titulocampobd8P; ?></label>
              <textarea
                name="<?php echo $titulocampobd8; ?>"
                class="form-control"
                id="edit_<?php echo $titulocampobd8; ?>"
                rows="3"
                oninput="this.value = this.value.toUpperCase();"
                <?php echo $isAreaUser ? 'readonly' : ''; ?>></textarea>
            </div>

          </div>

          <div class="form-group row">

            <!-- ÁREA (usa area_id) -->
            <div class="col-sm-6">
              <label class="col-form-label"><?php echo $titulocampobd2P; ?></label>

              <?php if ($isAreaUser): ?>
                <!-- Usuario de área: bloqueado -->
                <select class="form-control" id="edit_area_id" disabled>
                  <?php
                  $areas = obtenerAreasConId();
                  foreach ($areas as $area) {
                    echo '<option value="' . $area['id'] . '">' . $area['nombre'] . '</option>';
                  }
                  ?>
                </select>

                <!-- Valor real que sí se envía -->
                <input type="hidden" name="area_id" id="edit_area_id_hidden">

              <?php else: ?>
                <!-- Admin -->
                <select name="area_id" class="form-control" id="edit_area_id">
                  <option value="">SELECCIONAR</option>
                  <?php
                  $areas = obtenerAreasConId();
                  foreach ($areas as $area) {
                    echo '<option value="' . $area['id'] . '">' . $area['nombre'] . '</option>';
                  }
                  ?>
                </select>
              <?php endif; ?>
            </div>



            <!-- META -->
            <div class="col-sm-3">
              <label class="col-form-label"><?php echo $titulocampobd9P; ?></label>
              <input
                type="text"
                name="<?php echo $titulocampobd9; ?>"
                class="form-control"
                id="edit_<?php echo $titulocampobd9; ?>"
                <?php echo $isAreaUser ? 'readonly' : ''; ?>
                required
                pattern="^\d+(\.\d{1,2})?$"
                oninput="validateInput(this)">
            </div>


            <!-- AVANCE -->
            <div class="col-sm-3">
              <label class="col-form-label"><?php echo $titulocampobd10P; ?></label>
              <input
                type="text"
                name="<?php echo $titulocampobd10; ?>"
                class="form-control"
                id="edit_<?php echo $titulocampobd10; ?>"
                required
                pattern="^\d+(\.\d{1,2})?$" oninput="validateInput(this)">
            </div>

            <script>
              function validateInput(input) {
                // Elimina cualquier carácter que no sea número o punto decimal
                input.value = input.value.replace(/[^0-9\.]/g, '');

                // Solo permite un punto decimal y máximo dos decimales
                let decimalCount = (input.value.match(/\./g) || []).length;
                if (decimalCount > 1) {
                  input.value = input.value.substring(0, input.value.lastIndexOf('.'));
                }

                if (input.value.indexOf('.') !== -1) {
                  let decimalPart = input.value.split('.')[1];
                  if (decimalPart.length > 2) {
                    input.value = input.value.substring(0, input.value.lastIndexOf('.') + 3);
                  }
                }
              }
            </script>


          </div>

          <div class="form-group row">

            <!-- DETALLES -->
            <div class="col-sm-12">
              <label class="col-form-label"><?php echo $titulocampobd4P; ?></label>
              <textarea
                name="<?php echo $titulocampobd4; ?>"
                class="form-control"
                id="edit_<?php echo $titulocampobd4; ?>"
                rows="3"
                oninput="this.value = this.value.toUpperCase();"></textarea>
            </div>

          </div>

          <div class="form-group row">
            <div class="col-sm-12">
              <div class="form-check">
                <input type="checkbox" class="form-check-input" name="otra_estrategia" id="edit_otra_estrategia">
                <label class="form-check-label" for="edit_otra_estrategia">
                  Considerar como Otra Estrategia
                </label>
              </div>
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