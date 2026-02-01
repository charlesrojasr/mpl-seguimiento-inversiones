<div class="modal fade" id="addnew">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <center>
          <h4 class="modal-title">NUEVA ACTIVIDAD</h4>
        </center>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <form class="form-horizontal" method="POST" action="actividades_modal_add_f.php" enctype="multipart/form-data">
        <div class="modal-body">
          <div class="form-group row">

            <div class="col-sm-6">
              <label for="inputEmail3" class="col-form-label"><?php echo $titulocampobd3P; ?></label>
              <textarea name="<?php echo $titulocampobd3; ?>" class="form-control" id="<?php echo $titulocampobd3; ?>" placeholder="<?php echo $titulocampobd3P; ?>" rows="3" oninput="this.value = this.value.toUpperCase();" required></textarea>
            </div>

            <div class="col-sm-6">
              <label for="inputEmail3" class="col-form-label"><?php echo $titulocampobd8P; ?></label>
              <textarea name="<?php echo $titulocampobd8; ?>" class="form-control" id="<?php echo $titulocampobd8; ?>" placeholder="<?php echo $titulocampobd8P; ?>" rows="3" oninput="this.value = this.value.toUpperCase();" required></textarea>
            </div>

          </div>

          <div class="form-group row">

            <div class="col-sm-6">
              <label class="col-form-label"><?php echo $titulocampobd2P; ?></label>

              <?php if ($isAreaUser): ?>
                <!-- Usuario de área: SELECT bloqueado + hidden -->
                <select class="form-control" disabled>
                  <?php
                  include 'actividades_obtener_areas.php';
                  $areas = obtenerAreasConId();

                  foreach ($areas as $area) {
                    $selected = ($area['id'] == $area_id) ? 'selected' : '';
                    echo '<option value="' . $area['id'] . '" ' . $selected . '>' . $area['nombre'] . '</option>';
                  }
                  ?>
                </select>

                <!-- Campo oculto para que el valor sí viaje por POST -->
                <input type="hidden" name="area_id" value="<?php echo $area_id; ?>">

              <?php else: ?>
                <!-- Admin u otros roles -->
                <select name="area_id" class="form-control" id="area_id" required>
                  <option value="">SELECCIONAR</option>
                  <?php
                  include 'actividades_obtener_areas.php';
                  $areas = obtenerAreasConId();

                  foreach ($areas as $area) {
                    echo '<option value="' . $area['id'] . '">' . $area['nombre'] . '</option>';
                  }
                  ?>
                </select>
              <?php endif; ?>
            </div>


            <div class="col-sm-3">
              <label for="inputEmail3" class="col-form-label"><?php echo $titulocampobd9P; ?></label>
              <input type="text" name="<?php echo $titulocampobd9; ?>" class="form-control" id="<?php echo $titulocampobd9; ?>" placeholder="<?php echo $titulocampobd9P; ?>" required pattern="^\d+(\.\d{1,2})?$" oninput="validateInput(this)">
            </div>

            <div class="col-sm-3">
              <label for="inputEmail3" class="col-form-label"><?php echo $titulocampobd10P; ?></label>
              <input type="text" name="<?php echo $titulocampobd10; ?>" class="form-control" id="<?php echo $titulocampobd10; ?>" placeholder="<?php echo $titulocampobd10P; ?>" required pattern="^\d+(\.\d{1,2})?$" oninput="validateInput(this)">
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

            <div class="col-sm-12">
              <label for="inputEmail3" class="col-form-label"><?php echo $titulocampobd4P; ?></label>
              <textarea name="<?php echo $titulocampobd4; ?>" class="form-control" id="<?php echo $titulocampobd4; ?>" placeholder="<?php echo $titulocampobd4P; ?>" rows="3" oninput="this.value = this.value.toUpperCase();" required></textarea>
            </div>

          </div>

          <div class="form-group row">
            <div class="col-sm-12">
              <div class="form-check">
                <input type="checkbox" class="form-check-input" name="otra_estrategia" id="otra_estrategia">
                <label class="form-check-label" for="otra_estrategia"><?php echo "Considerar como Otra Estrategia"; ?></label>
              </div>
            </div>
          </div>
        </div>

        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
          <button type="submit" name="add" class="btn btn-primary">Añadir</button>
        </div>
      </form>
    </div>
  </div>
</div>