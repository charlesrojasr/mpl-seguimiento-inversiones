<!-- MODAL AUDITORIA -->
<div class="modal fade" id="modalAuditoria" tabindex="-1">
  <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content">

      <div class="modal-header bg-info text-white">
        <h5 class="modal-title">
          Historial de Reprogramaciones
        </h5>

        <button type="button" class="close text-white" data-dismiss="modal">
          &times;
        </button>
      </div>

      <div class="modal-body">

        <div class="table-responsive">

          <table id="tablaAuditoria"
            class="table table-bordered table-striped w-100">

            <thead class="bg-light">
              <tr>
                <th>ID</th>
                <th>Usuario</th>
                <th>Área</th>
                <th>Acción</th>
                <th>Campo</th>
                <th>Valor Anterior</th>
                <th>Valor Nuevo</th>
                <th>Fecha de Actualización</th>
              </tr>
            </thead>

            <tbody></tbody>

          </table>

        </div>

      </div>

      <div class="modal-footer">
        <button class="btn btn-secondary" data-dismiss="modal">
          Cerrar
        </button>
      </div>

    </div>
  </div>
</div>
