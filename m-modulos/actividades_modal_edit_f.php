<?php
include 'config.php';
include 'actividades_auditoria_helper.php';

if (isset($_POST['edit'])) {

    /* =========================
       FUNCIÓN LIMPIAR
    ========================= */
    function limpiar($conn, $texto)
    {
        return mysqli_real_escape_string($conn, trim($texto));
    }

    /* =========================
       ID
    ========================= */
    $id = intval($_POST['id']);

    /* =========================
       CAMPOS PRINCIPALES
    ========================= */
    $area_id   = intval($_POST['area_id']);
    $estado_id = intval($_POST['estado_id']);

    $actividad = limpiar($conn, $_POST['actividad'] ?? '');

    /* =========================
       RESPONSABLE
    ========================= */
    $responsable_nombre    = limpiar($conn, $_POST['responsable_nombre'] ?? '');
    $responsable_apellidop = limpiar($conn, $_POST['responsable_apellidop'] ?? '');
    $responsable_apellidom = limpiar($conn, $_POST['responsable_apellidom'] ?? '');

    /* =========================
       FECHAS NORMALES
    ========================= */
    $fecha_inicio = $_POST['fecha_inicio'] ?? null;
    $fecha_final  = $_POST['fecha_final'] ?? null;

    /* =========================
       FECHAS REPROGRAMADAS
    ========================= */
    $fecha_reprogramada     = $_POST['fecha_reprogramada'] ?? null;
    $fecha_inicio_reprog    = $_POST['fecha_reprogramada_inicio'] ?? null;
    $observacion = limpiar($conn, $_POST['observacion'] ?? '');




    /* =========================
   OBTENER DATOS ANTIGUOS
========================= */

    $sqlOld = "SELECT *
    FROM inversiones_seg_inversiones
    WHERE id = $id
    LIMIT 1
";

    $resOld = $conn->query($sqlOld);

    $oldData = null;

    if ($resOld && $resOld->num_rows === 1) {
        $oldData = $resOld->fetch_assoc();
    } else {
        die("Registro no encontrado para auditoría.");
    }

    /* =========================
   CAMPOS A AUDITAR
========================= */

    $camposAuditar = [
        'area_id'                 => $area_id,
        'estado_id'               => $estado_id,
        'actividad'               => $actividad,

        'responsable_nombre'      => $responsable_nombre,
        'responsable_apellidop'   => $responsable_apellidop,
        'responsable_apellidom'   => $responsable_apellidom,

        'fecha_inicio'            => $fecha_inicio,
        'fecha_final'             => $fecha_final,

        'fecha_reprogramada'      => $fecha_reprogramada,
        'fecha_reprogramada_inicio' => $fecha_inicio_reprog,
        'observacion' => $observacion
    ];


    $reprogramo = false;


    $oldFechaFinReprog     = $oldData['fecha_reprogramada'] ?? null;
    $oldFechaInicioReprog = $oldData['fecha_reprogramada_inicio'] ?? null;


    $oldFechaFinReprog     = $oldData['fecha_reprogramada'] ?? null;
    $oldFechaInicioReprog = $oldData['fecha_reprogramada_inicio'] ?? null;


    // ---- FECHA FIN ----
    if ((string)$fecha_reprogramada !== (string)$oldFechaFinReprog) {
        $reprogramo = true;
    }

    // ---- FECHA INICIO ----
    if ((string)$fecha_inicio_reprog !== (string)$oldFechaInicioReprog) {
        $reprogramo = true;
    }



    // ---- CAMBIAR ESTADO SOLO SI HUBO CAMBIO ----
    if ($reprogramo) {
        $estado_id = 4;
    }


    /* =========================
       ARMAR UPDATE
    ========================= */

    $campos = [];

    // principales
    $campos[] = "area_id = '$area_id'";
    $campos[] = "estado_id = '$estado_id'";
    $campos[] = "actividad = '$actividad'";
    $campos[] = "observacion = '$observacion'";



    // responsable
    $campos[] = "responsable_nombre = '$responsable_nombre'";
    $campos[] = "responsable_apellidop = '$responsable_apellidop'";
    $campos[] = "responsable_apellidom = '$responsable_apellidom'";


    // fechas normales
    if (!empty($fecha_inicio)) {
        $campos[] = "fecha_inicio = '$fecha_inicio'";
    }

    if (!empty($fecha_final)) {
        $campos[] = "fecha_final = '$fecha_final'";
    }


    // fecha fin reprogramada
    if (!empty($fecha_reprogramada)) {
        $campos[] = "fecha_reprogramada = '$fecha_reprogramada'";
    } else {
        $campos[] = "fecha_reprogramada = NULL";
    }


    // fecha inicio reprogramada
    if (!empty($fecha_inicio_reprog)) {
        $campos[] = "fecha_reprogramada_inicio = '$fecha_inicio_reprog'";
    } else {
        $campos[] = "fecha_reprogramada_inicio = NULL";
    }



    /* =========================
       EJECUTAR UPDATE
    ========================= */

    $sql = "
        UPDATE inversiones_seg_inversiones
        SET " . implode(', ', $campos) . "
        WHERE id = '$id'
    ";



    if ($conn->query($sql)) {

        /* =========================
       REGISTRAR AUDITORÍA
    ========================= */

        foreach ($camposAuditar as $campo => $nuevoValor) {

            $valorAnterior = $oldData[$campo] ?? null;

            // Normalizar vacíos
            if ($valorAnterior === '') $valorAnterior = null;
            if ($nuevoValor === '')    $nuevoValor    = null;

            // Solo registrar si cambió
            if ((string)$valorAnterior !== (string)$nuevoValor) {

                registrarAuditoria(
                    $conn,
                    'UPDATE',
                    'inversiones_seg_inversiones',
                    $id,
                    $campo,
                    $valorAnterior,
                    $nuevoValor,
                    $observacion
                );
            }
        }


        echo "<script>

            if (typeof guardarFiltrosActuales === 'function') {
                guardarFiltrosActuales();
            }

            alert('Actividad actualizada correctamente');

            // 🔥 REDIRIGIR CON FILTROS
            let params = sessionStorage.getItem('filtrosURL') || '';
            window.location = 'actividades.php?' + params;

            </script>";
                }
}
