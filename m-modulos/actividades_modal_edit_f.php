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
    $area_id   = isset($_POST['area_id']) ? intval($_POST['area_id']) : $oldData['area_id'];
    $estado_id = isset($_POST['estado_id']) ? intval($_POST['estado_id']) : $oldData['estado_id'];


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
   DETECTAR CAMBIO EN DIAS
========================= */
    $dias_nuevo    = isset($_POST['dias']) ? intval($_POST['dias']) : $oldData['dias'];
    $dias_antiguo  = $oldData['dias'];

    $cambioDias = ((string)$dias_nuevo !== (string)$dias_antiguo);


    /* =========================
   CAMPOS A AUDITAR
========================= */

    $camposAuditar = [
        'area_id'                 => $area_id,
        'estado_id'               => $estado_id,
        'actividad'               => $actividad,
        'dias' => $dias_nuevo,

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

    $reprogramarCronograma = $reprogramo || $cambioDias;

    $observacion_auto = $cambioDias
    ? 'Se actualizó la cantidad de días en el nro ' . $id
    : 'Añadida por reprogramación de nro ' . $id;


    /* =========================
   PASO 4: RECALCULAR FECHA FIN
   SI CAMBIAN LOS DÍAS
========================= */
    if ($cambioDias) {

        // 1️⃣ Definir desde qué fecha se calcula
        // Prioridad: reprogramada > normal
        $base_inicio =
            $fecha_inicio_reprog
            ?? $oldData['fecha_reprogramada_inicio']
            ?? $fecha_inicio
            ?? $oldData['fecha_inicio'];

        // 2️⃣ Recalcular fecha fin automáticamente
        if (!empty($base_inicio)) {

            $fecha_reprogramada = date(
                'Y-m-d',
                strtotime($base_inicio . " + {$dias_nuevo} days")
            );

            // 3️⃣ Forzar estado reprogramado
            $estado_id = 4;
        }
    }



    if ($reprogramo && !empty($fecha_reprogramada)) {

        // Fecha base: fin reprogramado de la actividad editada
        $fechaBase = $fecha_reprogramada;

        // Obtener TODAS las actividades siguientes del mismo proyecto
        $sqlNexts = "
        SELECT *
        FROM inversiones_seg_inversiones
        WHERE proyecto_id = {$oldData['proyecto_id']}
          AND id > $id
        ORDER BY id ASC
    ";

        $resNexts = $conn->query($sqlNexts);

        while ($resNexts && $next = $resNexts->fetch_assoc()) {

            // ➕ 1 día desde la fecha anterior
            $nueva_fecha_inicio = date(
                'Y-m-d',
                strtotime($fechaBase . ' +1 day')
            );

            // Calcular fecha fin automáticamente
            if (!empty($next['dias'])) {
                $nueva_fecha_fin = date(
                    'Y-m-d',
                    strtotime($nueva_fecha_inicio . " + {$next['dias']} days")
                );
            } else {
                $nueva_fecha_fin = null;
            }

            // UPDATE
            $sqlUpdate = "
            UPDATE inversiones_seg_inversiones
            SET
                fecha_reprogramada_inicio = '$nueva_fecha_inicio',
                fecha_reprogramada = " . ($nueva_fecha_fin ? "'$nueva_fecha_fin'" : "NULL") . ",
                estado_id = 4,
                observacion = '$observacion_auto'

            WHERE id = {$next['id']}
        ";

            if ($conn->query($sqlUpdate)) {

                // AUDITORÍA
                registrarAuditoria(
                    $conn,
                    'UPDATE',
                    'inversiones_seg_inversiones',
                    $next['id'],
                    'fecha_reprogramada_inicio',
                    $next['fecha_reprogramada_inicio'],
                    $nueva_fecha_inicio,
                    $observacion_auto
                );

                registrarAuditoria(
                    $conn,
                    'UPDATE',
                    'inversiones_seg_inversiones',
                    $next['id'],
                    'fecha_reprogramada',
                    $next['fecha_reprogramada'],
                    $nueva_fecha_fin,
                    $observacion_auto
                );

                registrarAuditoria(
                    $conn,
                    'UPDATE',
                    'inversiones_seg_inversiones',
                    $next['id'],
                    'estado_id',
                    $next['estado_id'],
                    4,
                    $observacion_auto
                );
            }

            // La fecha base pasa a ser el fin de esta actividad
            $fechaBase = $nueva_fecha_fin ?? $nueva_fecha_inicio;
        }
    }




    /* =========================
       ARMAR UPDATE
    ========================= */

    $campos = [];

    // principales
    if ($area_id !== null) {
        $campos[] = "area_id = '$area_id'";
    }

    if ($estado_id !== null) {
        $campos[] = "estado_id = '$estado_id'";
    }

    $campos[] = "actividad = '$actividad'";
    $campos[] = "observacion = '$observacion'";
    $campos[] = "dias = '$dias_nuevo'";

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

        /* =========================
   PASO 5: REPROGRAMACIÓN
   EN CASCADA
========================= */
        if ($reprogramarCronograma && !empty($fecha_reprogramada)) {

            // Fecha base: fin de la actividad actual
            $fechaBase = $fecha_reprogramada;

            // Obtener TODAS las actividades siguientes
            $sqlNexts = "SELECT *
                FROM inversiones_seg_inversiones
                WHERE proyecto_id = {$oldData['proyecto_id']}
                AND id > $id
                ORDER BY id ASC
            ";

            $resNexts = $conn->query($sqlNexts);

            while ($resNexts && $next = $resNexts->fetch_assoc()) {

                // 🔒 No tocar actividades finalizadas
                if ((int)$next['estado_id'] === 5) {
                    continue;
                }

                // 1️⃣ Inicio = fin anterior + 1 día
                $nueva_fecha_inicio = date(
                    'Y-m-d',
                    strtotime($fechaBase . ' +1 day')
                );

                // 2️⃣ Fin = inicio + días
                if (!empty($next['dias'])) {
                    $nueva_fecha_fin = date(
                        'Y-m-d',
                        strtotime($nueva_fecha_inicio . " + {$next['dias']} days")
                    );
                } else {
                    $nueva_fecha_fin = null;
                }

                // 3️⃣ Update automático
                $conn->query("UPDATE inversiones_seg_inversiones
                    SET
                        fecha_reprogramada_inicio = '$nueva_fecha_inicio',
                        fecha_reprogramada = " . ($nueva_fecha_fin ? "'$nueva_fecha_fin'" : "NULL") . ",
                        estado_id = 4,
                        observacion = '$observacion_auto'
                    WHERE id = {$next['id']}
                ");

                // 4️⃣ Auditoría resumida
                registrarAuditoria(
                    $conn,
                    'UPDATE',
                    'inversiones_seg_inversiones',
                    $next['id'],
                    'cronograma',
                    'AUTO',
                    'AUTO',
                    $observacion_auto
                );

                // 5️⃣ Avanzar la cadena
                $fechaBase = $nueva_fecha_fin ?? $nueva_fecha_inicio;
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
