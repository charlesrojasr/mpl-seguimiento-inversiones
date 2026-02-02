<?php
include 'actividades_config.php';

if (isset($_POST['edit'])) {

    // ----------------------------------------------------
    // FUNCIÓN DE LIMPIEZA
    // ----------------------------------------------------
    function limpiar($conn, $texto)
    {
        return mysqli_real_escape_string($conn, trim($texto));
    }

    // ----------------------------------------------------
    // 1. ID
    // ----------------------------------------------------
    $id = intval($_POST['id']);

    // ----------------------------------------------------
    // 2. CAMPOS DEL FORMULARIO
    // ----------------------------------------------------
    $area_id   = intval($_POST['area_id']);
    $estado_id = intval($_POST['estado_id']);

    $nombre_resp = limpiar($conn, $_POST[$titulocampobd12] ?? '');
    $apep_resp   = limpiar($conn, $_POST[$titulocampobd13] ?? '');
    $apem_resp   = limpiar($conn, $_POST[$titulocampobd14] ?? '');

    $actividad = limpiar($conn, $_POST[$titulocampobd6] ?? '');

    $fecha_inicio = $_POST[$titulocampobd7] ?: null;
    $fecha_final  = $_POST[$titulocampobd9] ?: null;

    // ----------------------------------------------------
    // 3. UPDATE
    // ----------------------------------------------------
    $sql = "
        UPDATE inversiones_seg_inversiones SET
            area_id              = '$area_id',
            estado_id            = '$estado_id',
            {$titulocampobd12}   = '$nombre_resp',
            {$titulocampobd13}   = '$apep_resp',
            {$titulocampobd14}   = '$apem_resp',
            {$titulocampobd6}    = '$actividad',
            {$titulocampobd7}    = " . ($fecha_inicio ? "'$fecha_inicio'" : "NULL") . ",
            {$titulocampobd9}    = " . ($fecha_final ? "'$fecha_final'" : "NULL") . "
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
