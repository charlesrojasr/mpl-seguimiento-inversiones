<?php
include 'config.php';

if (isset($_POST['edit'])) {

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
       FECHAS
       ========================= */
    $fecha_inicio       = $_POST['fecha_inicio'] ?? null;
    $fecha_final        = $_POST['fecha_final'] ?? null;
    $fecha_reprogramada = $_POST['fecha_reprogramada'] ?? null;

    /* =========================
       FECHA REPROGRAMADA ACTUAL
       ========================= */
    $sqlOld = "
        SELECT fecha_reprogramada
        FROM inversiones_seg_inversiones
        WHERE id = $id
    ";
    $resOld = $conn->query($sqlOld);

    $oldFechaReprog = null;
    if ($resOld && $resOld->num_rows === 1) {
        $oldFechaReprog = $resOld->fetch_assoc()['fecha_reprogramada'];
    }

    /* =========================
       LÓGICA REPROGRAMACIÓN
       ========================= */
    if (!empty($fecha_reprogramada)) {

        $estado_id = 3;

    } elseif (!empty($oldFechaReprog)) {

        $fecha_reprogramada = $oldFechaReprog;
        $estado_id = 3;

    } else {

        $fecha_reprogramada = null;
    }

    /* =========================
       UPDATE
       ========================= */
    $campos = [];

    $campos[] = "area_id = '$area_id'";
    $campos[] = "estado_id = '$estado_id'";
    $campos[] = "actividad = '$actividad'";

    $campos[] = "responsable_nombre = '$responsable_nombre'";
    $campos[] = "responsable_apellidop = '$responsable_apellidop'";
    $campos[] = "responsable_apellidom = '$responsable_apellidom'";

    if (!empty($fecha_inicio)) {
        $campos[] = "fecha_inicio = '$fecha_inicio'";
    }

    // 🔒 NO borrar fecha_final
    if (!empty($fecha_final)) {
        $campos[] = "fecha_final = '$fecha_final'";
    }

    if ($fecha_reprogramada !== null) {
        $campos[] = "fecha_reprogramada = '$fecha_reprogramada'";
    } else {
        $campos[] = "fecha_reprogramada = NULL";
    }

    $sql = "
        UPDATE inversiones_seg_inversiones
        SET " . implode(', ', $campos) . "
        WHERE id = '$id'
    ";

    if ($conn->query($sql)) {

        echo "<script>
            alert('Actividad actualizada correctamente');
            window.location = 'actividades.php';
        </script>";

    } else {

        echo "<script>
            alert('Error al actualizar: {$conn->error}');
            window.location = 'actividades.php';
        </script>";
    }
}
