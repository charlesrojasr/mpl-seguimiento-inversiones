<script>
  const ORDEN_ETAPAS = [
    'Requerimiento y actos preparatorios',
    'Proceso de convocatoria en el SEACE',
    'Ejecución contractual'
  ];
</script>


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

    let valores = dt
      .column(col, {
        search: 'applied'
      })
      .data()
      .map(function(d) {
        return $('<div>').html(d).text().trim();
      })
      .unique()
      .toArray();

    // 🧠 SI ES LA COLUMNA ETAPA (col = 2), ordenar por negocio
    if (col === 2) {
      valores.sort(function(a, b) {
        return ORDEN_ETAPAS.indexOf(a) - ORDEN_ETAPAS.indexOf(b);
      });
    } else {
      // resto de columnas: orden normal
      valores.sort();
    }

    return valores;
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



        $('#edit_area_id').val(response.area_id).trigger('change');
        $('#edit_estado_id').val(response.estado_id).trigger('change');

        $('#edit_<?php echo $titulocampobd12; ?>').val(response.responsable_nombre);
        $('#edit_<?php echo $titulocampobd13; ?>').val(response.responsable_apellidop);
        $('#edit_<?php echo $titulocampobd14; ?>').val(response.responsable_apellidom);
        $('#edit_<?php echo $titulocampobd15; ?>').val(response.fecha_reprogramada_inicio);




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

          if (dias <= 0) {
            alerta = '<span style="color:red;"><b>VENCE HOY</b></span>';
          } else if (dias === 1) {
            alerta = '<span style="color:#e67e22;"><b>Vence en 1 día</b></span>';
          } else {
            alerta = '<span style="color:#f1c40f;"><b>Vence en ' + dias + ' días</b></span>';
          }

          let fechaVence = '';
          let labelFecha = '';

          if (
            parseInt(act.estado_id) === 3 ||
            parseInt(act.estado_id) === 4 ||
            parseInt(act.estado_id) === 5
          ) {

            fechaVence = act.fecha_reprogramada;

            labelFecha = '<b style="color:#8b0000;">Fecha Fin (Reprogramada)</b>';

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


<script>
  function guardarFiltrosActuales() {
    const filtros = {
      proyecto: $('#proyectoFiltro').val(),
      etapa: $('#etapaFiltro').val(),
      area: $('#areaFiltro').val(),
      estado: $('#estadoFiltro').val()
    };

    localStorage.setItem('filtrosActividades', JSON.stringify(filtros));
  }
</script>

<script>
  $(window).on('load', function() {

    const filtrosGuardados = localStorage.getItem('filtrosActividades');

    if (!filtrosGuardados) return;

    const filtros = JSON.parse(filtrosGuardados);

    // Restaurar filtro principal
    if (filtros.proyecto) {
      $('#proyectoFiltro').val(filtros.proyecto);
      buscarTabla();
    }

    // Esperar a que se carguen los filtros secundarios
    setTimeout(function() {

      if (filtros.etapa) {
        $('#etapaFiltro').val(filtros.etapa).trigger('change');
      }

      if (filtros.area) {
        $('#areaFiltro').val(filtros.area).trigger('change');
      }

      if (filtros.estado) {
        $('#estadoFiltro').val(filtros.estado).trigger('change');
      }

      // Limpiar storage (opcional pero recomendado)
      localStorage.removeItem('filtrosActividades');

    }, 300);

  });
</script>

<script>
  $(function() {

    const ESTADOS_REPROGRAMADOS = [3, 4, 5];


    const $modal = $('#edit');

    const $check = $('#check_reprogramar');

    const $radios = $('#contenedor_radios');
    const $fechas = $('#contenedor_fechas');

    const $opAmbas = $('#opcion2'); // ambas = primero
    const $opSolo = $('#opcion1');

    const $fechaFin = $('#edit_<?php echo $titulocampobd11; ?>');
    const $fechaInicio = $('#edit_<?php echo $titulocampobd15; ?>');

    const $contFecha2 = $('#contenedor_fecha2');

    const $estado = $('#edit_estado_id');


    /* ===============================
       MOSTRAR / OCULTAR FECHA 2
    =============================== */
    function controlarFechas() {

      if ($opAmbas.is(':checked')) {

        $contFecha2.slideDown();

      } else {

        $contFecha2.slideUp();
        $fechaInicio.val('');

      }

    }


    /* ===============================
       ACTIVAR / DESACTIVAR REPROG
    =============================== */
    function controlarReprogramacion() {

      if ($check.is(':checked')) {

        $radios.slideDown();
        $fechas.slideDown();

        // guardar estado original
        if (!$estado.data('original')) {
          $estado.data('original', $estado.val());
        }

        // forzar estado
        // solo forzar si NO es ya reprog
        if (!ESTADOS_REPROGRAMADOS.includes(parseInt($estado.val()))) {
          $estado.val(3);
        }


        controlarFechas();

      } else {

        resetearTodo();

      }

    }


    /* ===============================
       RESET TOTAL
    =============================== */
    function resetearTodo() {

      // checkbox
      $check.prop('checked', false);

      // radios (por defecto: SOLO)
      $opSolo.prop('checked', true);
      $opAmbas.prop('checked', false);

      // fechas
      $fechaFin.val('');
      $fechaInicio.val('');

      // ocultar
      $radios.hide();
      $fechas.hide();
      $contFecha2.hide();

      // restaurar estado
      if ($estado.data('original')) {
        $estado.val($estado.data('original'));
        $estado.removeData('original');
      }

    }


    /* ===============================
       EVENTOS
    =============================== */

    // checkbox
    $check.on('change', controlarReprogramacion);

    // radios
    $opSolo.on('change', controlarFechas);
    $opAmbas.on('change', controlarFechas);


    // cerrar modal
    $modal.on('hidden.bs.modal', function() {
      resetearTodo();
    });


    // abrir modal (editar)
    $modal.on('shown.bs.modal', function() {

      const fFin = $fechaFin.val();
      const fInicio = $fechaInicio.val();

      if (fFin && fFin !== '') {

        // activar reprog
        $check.prop('checked', true);

        $radios.show();
        $fechas.show();

        // guardar estado
        if (!$estado.data('original')) {
          $estado.data('original', $estado.val());
        }

        // respetar estado existente
        const estadoActual = parseInt($estado.val());

        if (!ESTADOS_REPROGRAMADOS.includes(estadoActual)) {
          $estado.val(3);
        }



        // decidir radio
        if (fInicio && fInicio !== '') {

          // ambas
          $opAmbas.prop('checked', true);

        } else {

          // solo
          $opSolo.prop('checked', true);

        }

      } else {

        resetearTodo();

      }

      // forzar vista correcta
      controlarFechas();

    });

  });
</script>

<script>
  /* ===============================
   BOTON AUDITORIA
================================ */

  $(document).on('click', '.btn-auditoria', function() {

    let id = $(this).data('id');

    $('#modalAuditoria').modal('show');

    cargarAuditoria(id);

  });

  function formatearFechaSimple(fecha) {

    if (!fecha || fecha === 'null' || fecha === '') return '-';

    let f = new Date(fecha);

    if (isNaN(f.getTime())) return fecha; // por si no es fecha

    let dia = String(f.getDate()).padStart(2, '0');
    let mes = String(f.getMonth() + 1).padStart(2, '0');
    let anio = f.getFullYear();

    return `${dia}/${mes}/${anio}`;
  }



  /* ===============================
     CARGAR AUDITORIA AJAX
  ================================ */

  function cargarAuditoria(id) {

    $.ajax({

      url: 'actividades_auditoria_list.php',
      type: 'POST',

      data: {
        id: id
      },

      dataType: 'json',

      success: function(data) {

        let html = '';

        if (data.length === 0) {

          html = `
          <tr>
            <td colspan="8" class="text-center text-muted">
              No hay registros
            </td>
          </tr>
        `;

        } else {

          data.forEach(function(row) {

            // ===============================
            // TRANSFORMACIONES
            // ===============================

            // ACCION
            let accion = row.accion;

            if (accion === 'UPDATE') {
              accion = 'REPROGRAMÓ';
            }


            // CAMPO
            let campo = row.campo;

            if (campo === 'fecha_reprogramada') {
              campo = 'Fecha Fin Reprogramada';
            }

            if (campo === 'fecha_reprogramada_inicio') {
              campo = 'Fecha Inicio Reprogramada';
            }


            // FECHA (-6 horas / formato)
            let fechaFormateada = '-';

            if (row.fecha) {

              let fechaBD = new Date(row.fecha.replace(' ', 'T'));

              // restar 6 horas
              fechaBD.setHours(fechaBD.getHours() - 6);

              let dia = String(fechaBD.getDate()).padStart(2, '0');
              let mes = String(fechaBD.getMonth() + 1).padStart(2, '0');
              let anio = fechaBD.getFullYear();

              let hora = String(fechaBD.getHours()).padStart(2, '0');
              let min = String(fechaBD.getMinutes()).padStart(2, '0');

              fechaFormateada = `${dia}/${mes}/${anio} ${hora}:${min}`;
            }



            // ===============================
            // FILA
            // ===============================

            html += `
                <tr>

                  <td>${row.id}</td>

                  <td>${row.nombre_completo_usuario ?? '-'}</td>

                  <td>${row.nombre_area ?? '-'}</td>

                  <td><b class="text-primary">${accion}</b></td>

                  <td>${campo}</td>

                  <td>${formatearFechaSimple(row.valor_anterior)}</td>

                  <td>${formatearFechaSimple(row.valor_nuevo)}</td>


                  <td>${fechaFormateada}</td>

                </tr>
              `;


          });

        }

        $('#tablaAuditoria tbody').html(html);


        // DataTable (solo 1 vez)
        if (!$.fn.DataTable.isDataTable('#tablaAuditoria')) {

          $('#tablaAuditoria').DataTable({

            responsive: true,
            paging: true,
            searching: true,
            ordering: false,
            info: true,
            pageLength: 10,
            destroy: true

          });

        }

      }

    });

  }
</script>