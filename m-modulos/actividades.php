

<?php include 'config.php' ?>



<?php include 'actividades_config.php' ?>


<?php include '../00_includes/head.php' ?>


<body class="hold-transition sidebar-mini layout-fixed">

  <div class="wrapper">
    <!-- Preloader -->
    <?php /* include '../00_includes/preloader.php';*/ ?>
    <!-- Navbar -->
    <?php include '../00_includes/menu_superior.php'; ?>
    <!-- /.navbar -->
    <!-- Main Sidebar Container -->
    <?php include '../00_includes/menu_lateral_izquierdo.php'; ?>

    <!-- Content Wrapper. Contains page content -->
    <?php include 'actividades_contenido.php' ?>
    <!-- /.content-wrapper -->



    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
      <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
  </div>
  <!-- ./wrapper -->

  <?php include '../00_includes/footer.php'; ?>


  <?php include 'actividades_modal_add.php'; ?>>
  <?php include 'actividades_modal_edit.php'; ?>
  <?php include 'actividades_modal_auditoria.php'; ?>
  <?php //include 'actividades_modal_visor.php'; 
  ?>

  <?php //include 'listar_autorizaciones_modal_qr.php'; 
  ?>

  <?php //include 'index_06_modal_delete.php'; 
  ?>

  <?php include '../00_includes/script.php'; ?>

  <?php include 'actividades_script.php'; ?>


</body>

</html>