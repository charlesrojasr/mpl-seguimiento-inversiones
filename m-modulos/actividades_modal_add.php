<?php
include 'actividades_obtener_areas.php';
$areas = obtenerAreasConId();
?>


<div class="modal fade" id="addnew">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">

      <div class="modal-header">
        <h4 class="modal-title">NUEVA ACTIVIDAD</h4>
        <button type="button" class="close" data-dismiss="modal">
          <span>&times;</span>
        </button>
      </div>

      <form class="form-horizontal"
        method="POST"
        onsubmit="guardarFiltrosActuales()"
        action="actividades_modal_add_f.php">

        <div class="modal-body">

          <!-- AREA -->
          <div class="form-group row">
            <div class="col-sm-12">
              <label><?php echo $titulocampobd4P; ?></label>

              <?php if ($isAreaUser): ?>

                <!-- Usuario de área -->
                <select class="form-control" disabled>
                  <option selected><?= $_SESSION['area_name'] ?></option>
                </select>

                <input type="hidden"
                  name="area_id"
                  value="<?= $_SESSION['area_id'] ?>">

              <?php else: ?>

                <!-- Admin -->
                <select name="area_id"
                  class="form-control"
                  required>
                  <option value="">SELECCIONAR</option>

                  <?php foreach ($areas as $area): ?>
                    <option value="<?= $area['id'] ?>">
                      <?= $area['nombre'] ?>
                    </option>
                  <?php endforeach; ?>

                </select>

              <?php endif; ?>

            </div>
          </div>


          <!-- ETAPA -->
          <div class="form-group row">
            <div class="col-sm-6">

              <label><?php echo $titulocampobd2P; ?></label>

              <input type="text"
                id="add_proyecto_nombre"
                class="form-control"
                readonly>

              <input type="hidden"
                name="proyecto_id"
                id="add_proyecto_id">

            </div>
            <div class="col-sm-6">
              <label><?php echo $titulocampobd3P; ?></label>

              <select name="etapa_id"
                class="form-control"
                required>

                <option value="">SELECCIONAR</option>

                <?php
                include 'actividades_obtener_etapas.php';
                $etapas = obtenerEtapasConId();

                foreach ($etapas as $etapa) {
                  echo '<option value="' . $etapa['id'] . '">'
                    . $etapa['nombre'] . '</option>';
                }
                ?>
              </select>
            </div>
          </div>

          <!-- ACTIVIDAD + DIAS -->
          <div class="form-group row">

            <div class="col-sm-8">
              <label><?php echo $titulocampobd6P; ?></label>
              <textarea
                name="<?php echo $titulocampobd6; ?>"
                class="form-control"
                rows="3"
                required></textarea>
            </div>

            <div class="col-sm-4">
              <label><?php echo $titulocampobd8P; ?></label>
              <input type="number"
                name="<?php echo $titulocampobd8; ?>"
                class="form-control">
            </div>

          </div>

          <!-- FECHAS + ESTADO -->
          <div class="form-group row">

            <div class="col-sm-6">
              <label><?php echo $titulocampobd7P; ?></label>
              <input type="date"
                name="<?php echo $titulocampobd7; ?>"
                class="form-control">
            </div>

            <div class="col-sm-6">
              <label><?php echo $titulocampobd9P; ?></label>
              <input type="date"
                name="<?php echo $titulocampobd9; ?>"
                class="form-control">
            </div>


          </div>

        </div>

        <div class="modal-footer justify-content-between">
          <button type="button"
            class="btn btn-secondary"
            data-dismiss="modal">
            Cancelar
          </button>

          <button type="submit"
            name="add"
            class="btn btn-primary">
            Añadir
          </button>
        </div>

      </form>
    </div>
  </div>
</div>