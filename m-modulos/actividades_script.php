<script>
  const USER_ROLE = <?= (int)$_SESSION['role_id'] ?>;
  const USER_AREA = <?= (int)($_SESSION['area_id'] ?? 0) ?>;
</script>



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

      responsive: false, // obligatorio con scrollX
      autoWidth: true, // 🔥 CAMBIA ESTO
      pageLength: 35,

      scrollY: "60vh",
      scrollX: true,
      scrollCollapse: true,
      fixedHeader: true,

      buttons: [{
          text: '',
          className: 'btn-proyecto-nombre',
          attr: {
            id: 'btnNombreProyecto'
          },
          action: function(e, dt, node, config) {
            // No hace nada, solo visual
          }
        },
        {
          extend: 'excel',
          text: '<i class="fa-solid fa-file-excel"></i> Exportar',
          className: 'btn btn-success btn-sm',
          exportOptions: {
            modifier: {
              search: 'applied'
            }
          }
        },
        {
          text: '<i class="fa-solid fa-plus"></i> Añadir actividad',
          className: 'btn btn-dark btn-sm',
          attr: {
            'data-toggle': 'modal',
            'data-target': '#addnew'
          }
        }
      ],



      drawCallback: function() {

        if ($("#filtrosSecundarios").is(":visible")) {
          cargarFiltrosSecundarios();
        }

      }

    });

    dt.buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

    $('#btnNombreProyecto').hide();


    // 🔥 Recalcular columnas cuando cambia el tamaño de pantalla
    $(window).on('resize', function() {
      if (dt) {
        dt.columns.adjust().draw();
      }
    });



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

<style>
  table.dataTable {
    width: 100% !important;
  }
</style>

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

    $('#btnNombreProyecto')
      .text(proyecto)
      .show();

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

    // 🔥 FORZAR RECALCULO DE ANCHOS
    setTimeout(function() {
      dt.columns.adjust();
      dt.fixedHeader.adjust();
    }, 100);

    // Cargar filtros secundarios una sola vez
    cargarFiltrosSecundarios();

    $("#graficaAvance").show();
    cargarGraficoProyecto($("#proyectoFiltro").val());


  }


  /* =====================================================
     LIMPIAR FILTROS
  ===================================================== */

  function limpiarFiltros() {

    $("#proyectoFiltro").val("");

    limpiarTodo();

    $("#tablaDatos").hide();
    $("#graficaAvance").hide();
    $('#btnNombreProyecto').hide();


    setTimeout(function() {
      dt.columns.adjust();
      dt.fixedHeader.adjust();
    }, 100);

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
    $("#graficaAvance").hide();

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
        aplicarPermisosEdicion(response.area_id);

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
        // Tipo de días
        $('#edit_tipo_calendario').prop('checked', false);
        $('#edit_tipo_habiles').prop('checked', false);

        if (response.dias_tipo == 1) {
          $('#edit_tipo_calendario').prop('checked', true);
        } else if (response.dias_tipo == 2) {
          $('#edit_tipo_habiles').prop('checked', true);
        }


        $("#edit_<?php echo $titulocampobd9; ?>").val(response.fecha_final);
        $("#edit_<?php echo $titulocampobd10; ?>").val(response.estado_name);
        $("#edit_<?php echo $titulocampobd11; ?>").val(response.fecha_reprogramada);



        $('#edit_area_id').val(response.area_id).trigger('change');
        $('#edit_estado_id').val(response.estado_id).trigger('change');

        $('#edit_<?php echo $titulocampobd12; ?>').val(response.responsable_nombre);
        $('#edit_<?php echo $titulocampobd13; ?>').val(response.responsable_apellidop);
        $('#edit_<?php echo $titulocampobd14; ?>').val(response.responsable_apellidom);
        $('#edit_<?php echo $titulocampobd15; ?>').val(response.fecha_reprogramada_inicio);
        $('#edit_<?php echo $titulocampobd16; ?>').val(response.observacion);




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
      proyecto: $('#proyectoFiltro').val() || '',
      etapa: $('#etapaFiltro').val() || '',
      area: $('#areaFiltro').val() || '',
      estado: $('#estadoFiltro').val() || ''
    };

    // Guardar en localStorage (backup)
    localStorage.setItem('filtrosActividades', JSON.stringify(filtros));

    // Convertir en query string
    const params = new URLSearchParams(filtros).toString();

    // Guardar también en sessionStorage
    sessionStorage.setItem('filtrosURL', params);
  }
</script>

<script>
  $(document).ready(function() {

    const filtrosGuardados = localStorage.getItem('filtrosActividades');

    if (!filtrosGuardados) return;

    const filtros = JSON.parse(filtrosGuardados);

    // Esperar a DataTable
    let espera = setInterval(function() {

      if (window.dt) {

        clearInterval(espera);

        // Filtro principal
        if (filtros.proyecto) {
          $('#proyectoFiltro').val(filtros.proyecto);
        }

        // Ejecutar búsqueda principal
        buscarTabla();

        // Esperar filtros secundarios
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

          // Limpiar storage
          localStorage.removeItem('filtrosActividades');

        }, 500);

      }

    }, 200);

  });
</script>

<script>
  $(function() {

    const ESTADOS_REPROGRAMADOS = [3, 4, 5];

    const $modal = $('#edit');

    const $check = $('#check_reprogramar');

    const $radios = $('#contenedor_radios');
    const $fechas = $('#contenedor_fechas');

    const $opAmbas = $('#opcion2');
    const $opSolo = $('#opcion1');

    const $fechaFin = $('#edit_<?php echo $titulocampobd11; ?>');
    const $fechaInicio = $('#edit_<?php echo $titulocampobd15; ?>');

    const $contFecha2 = $('#contenedor_fecha2');

    const $estado = $('#edit_estado_id');

    /* OBSERVACION */
    const $rowObs = $('#row_observacion_reprog');
    const $obs = $('#edit_<?php echo $titulocampobd16; ?>');
    const $btnLimpiar = $('#btn_limpiar_observacion');


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
        $rowObs.slideDown();


        // guardar estado original
        if (!$estado.data('original')) {
          $estado.data('original', $estado.val());
        }

        // forzar estado
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

      // radios
      $opSolo.prop('checked', true);
      $opAmbas.prop('checked', false);

      // fechas
      $fechaFin.val('');
      $fechaInicio.val('');

      // observacion
      $obs.val('');

      // ocultar
      $radios.hide();
      $fechas.hide();
      $contFecha2.hide();
      $rowObs.hide();

      // restaurar estado
      if ($estado.data('original')) {
        $estado.val($estado.data('original'));
        $estado.removeData('original');
      }

    }


    /* ===============================
       BOTON LIMPIAR OBS
    =============================== */
    $btnLimpiar.on('click', function() {

      Swal.fire({
        title: '¿Limpiar observación?',
        text: 'Se borrará el contenido actual',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Sí, limpiar',
        cancelButtonText: 'Cancelar',
        confirmButtonColor: '#d33'
      }).then((result) => {

        if (result.isConfirmed) {
          $obs.val('');
        }

      });

    });


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
        $rowObs.show();


        // guardar estado
        if (!$estado.data('original')) {
          $estado.data('original', $estado.val());
        }

        // respetar estado
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

                  <td>${row.observacion ?? '-'}</td>   <!-- 🔥 -->


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


<script>
  let chartAvance = null;

  function renderGrafica(labels, data) {

    const ctx = document.getElementById('line-chart').getContext('2d');

    if (window.chartAvance) {
      window.chartAvance.destroy();
    }

    window.chartAvance = new Chart(ctx, {
      type: 'line',
      data: {
        labels: labels,
        datasets: [{
          label: 'Avance del Proyecto (%)',
          data: data,
          borderColor: '#3bc8db', // celeste medio
          backgroundColor: 'transparent',
          tension: 0.3,
          pointRadius: 4
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
          y: {
            min: 0,
            max: 100,
            ticks: {
              callback: v => v + '%'
            }
          }
        }
      }
    });
  }
</script>

<script>
  function cargarGraficoProyecto(proyecto) {

    $.ajax({
      url: 'actividades_chart_proyecto.php',
      type: 'POST',
      data: {
        proyecto: proyecto
      },
      dataType: 'json',

      success: function(resp) {

        renderGraficaLinea(resp.labels, resp.linea);

        renderDona('dona-etapa-1', resp.donas[1].avance, '#00c0ef');
        renderDona('dona-etapa-2', resp.donas[2].avance, '#00a65a');
        renderDona('dona-etapa-3', resp.donas[3].avance, '#f39c12');

      }

    });
  }
</script>

<script>
  function renderGraficaLinea(labels, data) {

    const ctx = document.getElementById('line-chart').getContext('2d');

    if (window.chartLinea) {
      window.chartLinea.destroy();
    }

    // 🔥 CLONAR para no mutar el array original
    let labelsGraf = [...labels];
    let dataGraf = [...data];

    // 🔥 Forzar punto inicial (0,0) si no existe
    if (dataGraf.length > 0 && dataGraf[0] > 0) {
      labelsGraf.unshift('Inicio');
      dataGraf.unshift(0);
    }

    const avanceFinal = dataGraf.length ?
      dataGraf[dataGraf.length - 1].toFixed(1) :
      0;

    window.chartLinea = new Chart(ctx, {
      type: 'line',
      data: {
        labels: labelsGraf,
        datasets: [{
          label: `Avance del Proyecto (%) = ${avanceFinal}%`,
          data: dataGraf,
          borderColor: '#3bc8db',
          backgroundColor: 'transparent',
          tension: 0.3,
          pointRadius: 4
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: {
            labels: {
              font: {
                weight: 'bold'
              }
            }
          }
        },
        scales: {
          y: {
            min: 0,
            max: 100,
            ticks: {
              callback: v => v + '%'
            }
          }
        }
      }
    });
  }
</script>


<script>
  // 1️⃣ contenedor global (hoisteado)
  var donaCharts = {};

  // 2️⃣ plugin texto centrado (compatible v2/v3)
  const doughnutCenterText = {
    id: 'doughnutCenterText',
    beforeDraw(chart) {

      if (chart.config.type !== 'doughnut') return;

      const ctx = chart.ctx || chart.chart.ctx;
      const width = chart.width || chart.chart.width;
      const height = chart.height || chart.chart.height;

      const dataset = chart.data.datasets[0];
      if (!dataset || !dataset.data) return;

      const value = Math.round(dataset.data[0]); // 🔥 entero

      ctx.save();

      const fontSize = Math.round(height / 8); // más aire
      ctx.font = `bold ${fontSize}px Arial`;
      ctx.fillStyle = '#333333';
      ctx.textAlign = 'center';
      ctx.textBaseline = 'middle';

      ctx.fillText(value + '%', width / 2, (height / 2) - 4);

      ctx.restore();
    }
  };



  // registrar plugin
  if (Chart.register) {
    Chart.register(doughnutCenterText);
  } else if (Chart.plugins && Chart.plugins.register) {
    Chart.plugins.register(doughnutCenterText);
  }

  // 3️⃣ función DONA
  function renderDona(idCanvas, avance, color) {

    const canvas = document.getElementById(idCanvas);
    if (!canvas) return;

    const ctx = canvas.getContext('2d');

    if (donaCharts[idCanvas]) {
      donaCharts[idCanvas].destroy();
    }

    donaCharts[idCanvas] = new Chart(ctx, {
      type: 'doughnut',
      data: {
        datasets: [{
          data: [avance, 100 - avance],
          backgroundColor: [color, '#e6e6e6'],
          borderWidth: 0
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        cutoutPercentage: 70, // AdminLTE / v2
        plugins: {
          legend: {
            display: false
          },
          tooltip: {
            enabled: false
          }
        }
      }
    });
  }
</script>

<script>
  $(document).ready(function() {

    const urlParams = new URLSearchParams(window.location.search);

    if (!urlParams.toString()) return;

    const filtros = {
      proyecto: urlParams.get('proyecto') || '',
      etapa: urlParams.get('etapa') || '',
      area: urlParams.get('area') || '',
      estado: urlParams.get('estado') || ''
    };

    // Esperar DataTable
    let espera = setInterval(function() {

      if (window.dt) {

        clearInterval(espera);

        // Proyecto
        if (filtros.proyecto) {
          $('#proyectoFiltro').val(filtros.proyecto);
        }

        buscarTabla();

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

          sessionStorage.removeItem('filtrosURL');


        }, 500);

      }

    }, 200);

  });
</script>

<script>
  function aplicarPermisosEdicion(areaActividad) {

    const role = USER_ROLE;
    const userArea = USER_AREA;
    const areaAct = parseInt(areaActividad);

    const esAdmin = (role === 1);
    const esAreaUser = (role === 2);

    const puedeEditar =
      esAdmin ||
      (esAreaUser && areaAct === userArea);

    if (esAdmin) {

      // inputs y textarea
      $('#edit input, #edit textarea')
        .prop('readonly', false);

      // selects
      $('#edit select')
        .removeClass('select-bloqueado');

      // botón guardar
      $('#edit button[type="submit"]')
        .prop('disabled', false);

      return; // ⛔ salir, no aplicar reglas de área
    }


    /* ===============================
       RESET GENERAL
    =============================== */

    // inputs y textarea
    $('#edit input, #edit textarea')
      .prop('readonly', true);

    // selects
    $('#edit select')
      .addClass('select-bloqueado');

    // botón guardar (por defecto bloqueado)
    $('#edit button[type="submit"]')
      .prop('disabled', true);

    /* ===============================
       PERMITIR EDICIÓN
    =============================== */

    if (puedeEditar) {

      // inputs / textarea editables
      $('#edit .editable-area')
        .prop('readonly', false);

      // selects editables
      $('#edit select.editable-area')
        .removeClass('select-bloqueado');

      // botón guardar
      $('#edit button[type="submit"]')
        .prop('disabled', false);
    }

    /* ===============================
       BOTONES SIEMPRE ACTIVOS
    =============================== */

    $('#edit .close, #edit button[data-dismiss="modal"]')
      .prop('disabled', false);
  }
</script>

<script>
  $('#addnew').on('show.bs.modal', function() {

    const proyectoNombre = $('#proyectoFiltro').val();

    if (!proyectoNombre) {
      alert('Debe seleccionar un proyecto primero');
      return false;
    }

    // Mostrar nombre
    $('#add_proyecto_nombre').val(proyectoNombre);

    // Obtener ID real vía AJAX
    $.ajax({
      url: 'actividades_obtener_proyecto_id.php',
      type: 'POST',
      data: {
        nombre: proyectoNombre
      },
      dataType: 'json',
      success: function(resp) {
        if (resp.id) {
          $('#add_proyecto_id').val(resp.id);
        } else {
          alert('Proyecto no encontrado');
        }
      }
    });

  });
</script>

<style>
  .select-bloqueado {
    pointer-events: none;
    /* no se puede interactuar */
    background-color: #e9ecef;
    opacity: 1;
  }

  .btn-proyecto-nombre {
    background: #00c0ef !important;
    padding: 6px 18px !important;
    font-weight: bold;
  }
</style>