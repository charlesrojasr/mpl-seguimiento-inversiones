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

$("#proyectoFiltro").on("change", function () {

  limpiarTodo();

  $("#tablaDatos").hide();

});


/* =====================================================
   CARGAR FILTROS SECUNDARIOS (UNA SOLA VEZ)
===================================================== */

function cargarFiltrosSecundarios() {

  // Evitar recargar
  if (filtrosIniciales.etapa.length > 0) return;

  filtrosIniciales.etapa  = obtenerValoresColumna(2);
  filtrosIniciales.area   = obtenerValoresColumna(3);
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
    .column(col, { search: 'applied' })
    .data()
    .unique()
    .sort()
    .toArray();
}


/* =====================================================
   LLENAR SELECT DESDE CACHE
===================================================== */

function llenarDesdeCache(selector, data) {

  let html = '<option value="">Todos</option>';

  data.forEach(function (d) {

    if (d && d.trim() !== "") {
      html += `<option value="${d}">${d}</option>`;
    }

  });

  $(selector).html(html);
}


/* =====================================================
   FILTROS SECUNDARIOS
===================================================== */

$(document).on('change', '#etapaFiltro', function () {

  dt.column(2).search(this.value).draw();

});

$(document).on('change', '#areaFiltro', function () {

  dt.column(3).search(this.value).draw();

});

$(document).on('change', '#estadoFiltro', function () {

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

$(function () {

  $('.edit').click(function (e) {

    e.preventDefault();

    $('#edit').modal('show');

    let id = $(this).data('id');

    getRow(id);

  });


  $('.delete').click(function (e) {

    e.preventDefault();

    $('#delete').modal('show');

    let id = $(this).data('id');

    getRow(id);

  });


  $('.photo').click(function (e) {

    e.preventDefault();

    let id = $(this).data('id');

    getRow(id);

  });

});


/* =====================================================
   AJAX OBTENER FILA
===================================================== */

function getRow(id) {

  let tabla = '<?php echo $primaryTable; ?>';

  $.ajax({

    type: 'POST',
    url: 'actividades_row.php',

    data: {
      id: id,
      tabla: tabla
    },

    dataType: 'json',

    success: function (response) {

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
      $("#edit_<?php echo $titulocampobd11; ?>").val(response.<?php echo $titulocampobd11; ?>);

    }

  });

}
</script>
