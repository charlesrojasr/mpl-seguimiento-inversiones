<script>
  // ==========================================
  // ==== FUNCIONES DE MODALES GENERALES ======
  // ==========================================


  function funcionX(valor) {
    // EDITAR    
    //alert(valor);
    $('#edit').modal('show');
    var id = valor;
    getRow(id);

  }


  function funcionZ(valor) {
    // EDITAR    
    //alert(valor);
    $('#desarrollar_actividad').modal('show');
    var id = valor;
    getRow(id);

  }


  function funcionV(valor) {
    // EDITAR    
    //alert(valor);
    $('#visor').modal('show');
    var id = valor;
    getRow(id);

  }


  function funcionQR(valor) {
    // EDITAR    
    //alert(valor);
    $('#qr').modal('show');
    var id = valor;
    getRow(id);

  }



  function funcionY(valor) {
    //ELIMINAR
    //alert(valor);
    $('#delete').modal('show');
    var id = valor;
    getRow(id);
  }



  function funcionP(valor) {
    //ELIMINAR
    //alert(valor);
    $('#edit_photo_').modal('show');
    var id = valor;
    getRow(id);
  }

  $(function() {
    $('.edit').click(function(e) {
      e.preventDefault();
      $('#edit').modal('show');
      var id = $(this).data('id');
      //alert(id);
      getRow(id);
    });

    $('.delete').click(function(e) {
      e.preventDefault();
      $('#delete').modal('show');
      var id = $(this).data('id');
      getRow(id);
    });





    $('.photo').click(function(e) {
      e.preventDefault();
      var id = $(this).data('id');
      getRow(id);
    });

  });


  function getRow(id) {
    var tabla = '<?php echo $primaryTable; ?>';

    $.ajax({
      type: 'POST',
      url: 'actividades_row.php',
      data: {
        id: id,
        tabla: tabla
      },
      dataType: 'json',

      success: function(response) {
        console.log(response);

        // IDs ocultos
        $('.empid').val(response.id);
        $('.id_photo').val(response.id);

        // CAMPOS PRINCIPALES
        $("#edit_<?php echo $titulocampobd1; ?>").val(response.<?php echo $titulocampobd1; ?>);
        $("#edit_<?php echo $titulocampobd2; ?>").val(response.<?php echo $titulocampobd2; ?>);
        $("#edit_<?php echo $titulocampobd3; ?>").val(response.<?php echo $titulocampobd3; ?>);
        $("#edit_<?php echo $titulocampobd4; ?>").val(response.<?php echo $titulocampobd4; ?>);
        $("#edit_<?php echo $titulocampobd5; ?>").val(response.<?php echo $titulocampobd5; ?>);
        $("#edit_<?php echo $titulocampobd6; ?>").val(response.<?php echo $titulocampobd6; ?>);
        $("#edit_<?php echo $titulocampobd7; ?>").val(response.<?php echo $titulocampobd7; ?>);
        $("#edit_<?php echo $titulocampobd8; ?>").val(response.<?php echo $titulocampobd8; ?>);
        $("#edit_<?php echo $titulocampobd9; ?>").val(response.<?php echo $titulocampobd9; ?>);
        $("#edit_<?php echo $titulocampobd10; ?>").val(response.<?php echo $titulocampobd10; ?>);
        $("#edit_<?php echo $titulocampobd12; ?>").val(response.<?php echo $titulocampobd12; ?>);

        $('#edit_area_id').val(response.area_id).change();

        // ================================
        // 🔐 RESTRICCIONES PARA USUARIO ÁREA
        // ================================
        if (USER_ROLE_ID === 3) {

          // 1) Bloquear select de área
          $('#edit_area_id').prop('disabled', true);

          // 2) Copiar valor al hidden (para que se envíe por POST)
          $('#edit_area_id_hidden').val(response.area_id);

          // 3) Bloquear META
          $('#edit_<?php echo $titulocampobd9; ?>').prop('readonly', true);
        }


        // 👇 AQUÍ EL FIX
        $('#edit_otra_estrategia').prop("checked", response.estado_id == 5);



      }
    });
  }
</script>