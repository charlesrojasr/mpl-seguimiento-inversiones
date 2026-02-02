<script>
  var dt = null;

  $(function() {

    dt = $("#example1").DataTable({



      paging: true,
      lengthChange: false,
      searching: true,
      ordering: false,
      info: true,
      responsive: true,
      autoWidth: false,
      pageLength: 35,

      buttons: [{
        extend: 'excel',
        exportOptions: {
          modifier: {
            search: 'applied'
          }
        }
      }],


      drawCallback: function() {

        if ($("#filtrosSecundarios").is(":visible")) {
          cargarFiltrosSecundarios();
        }

      }

    });

    dt.buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');



    // Tabla example3 (si existe)
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
        ]

      });

    }

  });
</script>

<script>
  /* =====================================================
   VARIABLES GLOBALES
===================================================== */

  let filtrosIniciales = {
    etapa: [],
    area: [],
    estado: []
  };


  /* =====================================================
     FILTRO PRINCIPAL
  ===================================================== */

  function buscarTabla() {

    if (!window.dt) {
      alert("La tabla aún no está lista");
      return;
    }

    let proyecto = $("#proyectoFiltro").val();

    if (proyecto === "") {
      alert("Seleccione un proyecto");
      return;
    }

    limpiarTodo();

    // Filtro principal
    if (proyecto === "Todos") {
      dt.column(1).search("");
    } else {
      dt.column(1).search("^" + proyecto + "$", true, false);
    }

    dt.draw();

    $("#tablaDatos").show();
    $("#filtrosSecundarios").show();

    // Cargar filtros secundarios una sola vez
    cargarFiltrosSecundarios();
  }


  /* =====================================================
     LIMPIAR FILTROS
  ===================================================== */

  function limpiarFiltros() {

    $("#proyectoFiltro").val("");

    limpiarTodo();

    $("#tablaDatos").hide();
  }


  /* =====================================================
     RESET GENERAL
  ===================================================== */

  function limpiarTodo() {

    if (typeof dt === "undefined") return;

    dt.search("").columns().search("").draw();

    $("#filtrosSecundarios").hide();

    $("#etapaFiltro").html('<option value="">Etapa</option>');
    $("#areaFiltro").html('<option value="">Área</option>');
    $("#estadoFiltro").html('<option value="">Estado</option>');

    // Reset cache
    filtrosIniciales = {
      etapa: [],
      area: [],
      estado: []
    };
  }


  /* =====================================================
     CAMBIO DE PROYECTO
  ===================================================== */

  $("#proyectoFiltro").on("change", function() {

    limpiarTodo();

    $("#tablaDatos").hide();

  });


  /* =====================================================
     CARGAR FILTROS SECUNDARIOS (UNA SOLA VEZ)
  ===================================================== */

  function cargarFiltrosSecundarios() {

    // Evitar recargar
    if (filtrosIniciales.etapa.length > 0) return;

    filtrosIniciales.etapa = obtenerValoresColumna(2);
    filtrosIniciales.area = obtenerValoresColumna(3);
    filtrosIniciales.estado = obtenerValoresColumna(9);

    llenarDesdeCache("#etapaFiltro", filtrosIniciales.etapa);
    llenarDesdeCache("#areaFiltro", filtrosIniciales.area);
    llenarDesdeCache("#estadoFiltro", filtrosIniciales.estado);
  }


  /* =====================================================
     OBTENER VALORES ÚNICOS DE COLUMNA
  ===================================================== */

  function obtenerValoresColumna(col) {

    return dt
      .column(col, {
        search: 'applied'
      })
      .data()
      .map(function(d) {
        // Quitar HTML y dejar solo texto
        return $('<div>').html(d).text().trim();
      })
      .unique()
      .sort()
      .toArray();
  }


  /* =====================================================
     LLENAR SELECT DESDE CACHE
  ===================================================== */

  function llenarDesdeCache(selector, data) {

    let html = '<option value="">Todos</option>';

    data.forEach(function(d) {

      if (d && d.trim() !== "") {
        html += `<option value="${d}">${d}</option>`;
      }

    });

    $(selector).html(html);
  }


  /* =====================================================
     FILTROS SECUNDARIOS
  ===================================================== */

  $(document).on('change', '#etapaFiltro', function() {

    dt.column(2).search(this.value).draw();

  });

  $(document).on('change', '#areaFiltro', function() {

    dt.column(3).search(this.value).draw();

  });

  $(document).on('change', '#estadoFiltro', function() {

    dt.column(9).search(this.value).draw();

  });
</script>

<script>
  /* =====================================================
   MODALES - FUNCIONES GENERALES
===================================================== */

  function funcionX(valor) {

    $('#edit').modal('show');
    getRow(valor);

  }


  function funcionZ(valor) {

    $('#desarrollar_actividad').modal('show');
    getRow(valor);

  }


  function funcionV(valor) {

    $('#visor').modal('show');
    getRow(valor);

  }


  function funcionQR(valor) {

    $('#qr').modal('show');
    getRow(valor);

  }


  function funcionY(valor) {

    $('#delete').modal('show');
    getRow(valor);

  }


  function funcionP(valor) {

    $('#edit_photo_').modal('show');
    getRow(valor);

  }


  /* =====================================================
     EVENTOS BOTONES
  ===================================================== */

  $(function() {

    $(document).on('click', '.edit', function(e) {
      e.preventDefault();

      let id = $(this).data('id');

      $('#edit').modal('show');
      getRow(id);
    });

  });


  /* =====================================================
     AJAX OBTENER FILA
  ===================================================== */

  function getRow(id) {

    $.ajax({
      type: 'POST',
      url: 'actividades_row.php',
      data: {
        id: id
      },
      dataType: 'json',

      success: function(response) {

        if (!response) {
          console.error("Respuesta vacía");
          return;
        }

        console.log(response);

        $('.empid').val(response.id);
        $('.id_photo').val(response.id);

        $("#edit_<?php echo $titulocampobd1; ?>").val(response.id);
        $("#edit_<?php echo $titulocampobd2; ?>").val(response.proyecto_name);
        $("#edit_<?php echo $titulocampobd3; ?>").val(response.etapa_name);
        $("#edit_<?php echo $titulocampobd4; ?>").val(response.area_name);
        $("#edit_<?php echo $titulocampobd5; ?>").val(response.responsable_nombre_completo);
        $("#edit_<?php echo $titulocampobd6; ?>").val(response.actividad);
        $("#edit_<?php echo $titulocampobd7; ?>").val(response.fecha_inicio);
        $("#edit_<?php echo $titulocampobd8; ?>").val(response.dias);
        $("#edit_<?php echo $titulocampobd9; ?>").val(response.fecha_final);
        $("#edit_<?php echo $titulocampobd10; ?>").val(response.estado_name);
        $("#edit_<?php echo $titulocampobd11; ?>").val(response.fecha_reprogramada);
        $("#edit_<?php echo $titulocampobd12; ?>").val(response.responsable_nombre);
        $("#edit_<?php echo $titulocampobd13; ?>").val(response.responsable_apellidop);
        $("#edit_<?php echo $titulocampobd14; ?>").val(response.responsable_apellidom);
      }
    });
  }
</script>

<?php if (!empty($alertas)) { ?>
  <script>
    $(function() {

      var actividadesProximas = <?php echo json_encode($alertas, JSON_UNESCAPED_UNICODE); ?>;

      // 🔥 ORDENAR POR DÍAS RESTANTES (más urgente primero)
      actividadesProximas.sort(function(a, b) {
        return parseInt(a.dias_restantes) - parseInt(b.dias_restantes);
      });

      if (actividadesProximas.length > 0) {

        var htmlLista = '<div style="text-align:left;">';
        htmlLista += '<p>Las siguientes actividades están <b>próximas a vencer</b>:</p>';
        htmlLista += '<ul style="padding-left:18px;">';

        actividadesProximas.forEach(function(act) {

          let dias = parseInt(act.dias_restantes);
          let alerta = '';

          switch (dias) {
            case 0:
              alerta = '<span style="color:red;"><b>VENCE HOY</b></span>';
              break;
            case 1:
              alerta = '<span style="color:#e67e22;"><b>Vence en 1 día</b></span>';
              break;
            default:
              alerta = '<span style="color:#f1c40f;"><b>Vence en ' + dias + ' días</b></span>';
          }

          let fechaVence = '';
          let labelFecha = '';

          if (parseInt(act.estado_id) === 3) {
            fechaVence = act.fecha_reprogramada;
            labelFecha = 'Fecha Fin (Reprogramada)';
          } else {
            fechaVence = act.fecha_final;
            labelFecha = 'Fecha Fin';
          }

          htmlLista += `
      <li style="margin-bottom:8px;">
        <b>${act.proyecto_name}</b><br>
        <small>
          Etapa: ${act.etapa_name || '-'} |
          Área: ${act.area_name || '-'} <br>
          Actividad: ${act.actividad || '-'} <br>
          ${labelFecha}: ${fechaVence} | ${alerta}
        </small>
      </li>
    `;
        });



        htmlLista += '</ul></div>';

        Swal.fire({
          title: '⚠ Actividades próximas a vencer',
          html: htmlLista,
          icon: 'warning',
          width: 750,
          confirmButtonText: 'Entendido',
          confirmButtonColor: '#3085d6',
          showCloseButton: true,
          allowOutsideClick: false
        });
      }
    });
  </script>
<?php } ?>

<?php if (!empty($mensajeAlerta)) { ?>
  <script>
    window.addEventListener('load', function() {
      alert(`<?php echo $mensajeAlerta; ?>`);
    });
  </script>

<?php } ?>