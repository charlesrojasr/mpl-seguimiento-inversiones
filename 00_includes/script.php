<!-- jQuery -->
<script src="../plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="../plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>


<script src="../plugins/moment/moment.min.js"></script>
<script src="../plugins/daterangepicker/daterangepicker.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="../plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Summernote -->
<script src="../plugins/summernote/summernote-bs4.min.js"></script>
<!-- overlayScrollbars -->
<script src="../plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="../dist/js/adminlte.js"></script>

<!-- SweetAlert2 -->
<script src="../plugins/sweetalert2/sweetalert2.min.js"></script>
<!-- Toastr -->
<script src="../plugins/toastr/toastr.min.js"></script>



<!-- DataTables  & Plugins -->
<script src="../plugins/datatables/jquery.dataTables.min.js"></script>
<script src="../plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="../plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="../plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="../plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="../plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="../plugins/jszip/jszip.min.js"></script>
<script src="../plugins/pdfmake/pdfmake.min.js"></script>
<script src="../plugins/pdfmake/vfs_fonts.js"></script>
<script src="../plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="../plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="../plugins/datatables-buttons/js/buttons.colVis.min.js"></script>


<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


<script>
  $(function() {
    var dt = $("#example1").DataTable({
      paging: true,
      lengthChange: false,
      searching: true,
      ordering: true,
      info: true,
      autoWidth: false,
      responsive: true,
      buttons: ["excel"],
      order: [
        [0, "desc"]
      ] // Ordenar por ID descendiente

    });

    // Colocar los botones (Excel) en el wrapper
    dt.buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

    // Selector de estado junto al botón Excel
    var estadoSelectHtml =
      '<select id="estadoFiltroTabla" ' +
      'onchange="filtrarTabla()"' + // ← aquí llamamos directo a filtrarTabla()
      ' class="form-control form-control-sm" ' +
      'style="display:inline-block;width:auto;margin-left:10px;min-width:150px;">' +
      '<option value="todos">Estado (Todos)</option>' +
      '<option value="Completado">Completado</option>' +
      '<option value="En proceso">En proceso</option>' +
      '<option value="Pendiente">Pendiente</option>' +
      '<option value="Sin iniciar">Sin iniciar</option>' +
      '<option value="Otra estrategia">Otra estrategia</option>' +
      '</select>';

    $('#example1_wrapper .dt-buttons').append(estadoSelectHtml);

    // // Cuando cambie el estado, aplicamos el filtro respetando el área
    // $(document).on('change', '#estadoFiltroTabla', function () {
    //     filtrarTabla(); // aquí se refresca toda la tabla según área + estado
    // });

    // Si tienes otra tabla example2:
    if ($('#example3').length) {
      $('#example3').DataTable({
        paging: true,
        lengthChange: false,
        searching: true,
        ordering: true,
        info: true,
        autoWidth: false,
        responsive: true,
        buttons: ["excel"],
        order: [
          [0, "desc"]
        ] // Ordenar por ID descendiente
      });
    }
  });
</script>