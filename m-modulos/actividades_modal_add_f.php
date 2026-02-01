<?php
include 'actividades_config.php';
include 'actividades_auditoria_helper.php';

if (isset($_POST['add'])) {

    // Sanitización base
    function limpiar($conn, $texto)
    {
        return mysqli_real_escape_string($conn, trim($texto));
    }

    // 1. CAMPOS DEL FORM – CONTROL DE ÁREA POR ROL
    if ($isAreaUser) {
        // Usuario de área: el área se toma EXCLUSIVAMENTE de la sesión
        $area_id = $_SESSION['area_id'];
    } else {
        // Admin u otros roles
        $area_id = $_POST['area_id'];
    }


    $actividad    = limpiar($conn, $_POST[$titulocampobd3]);
    $detalle      = limpiar($conn, $_POST[$titulocampobd4]);
    $indicadores  = limpiar($conn, $_POST[$titulocampobd8]);

    $meta   = floatval($_POST[$titulocampobd9]);  // Cambiar a float
    $avance = floatval($_POST[$titulocampobd10]);  // Cambiar a float


    // 2. CÁLCULOS AUTOMÁTICOS
    if ($meta > 0) {
        $porcentaje = round(($avance / $meta) * 100);  // <-- REDONDEO REAL
    } else {
        $porcentaje = 0;
    }

    // Estado automático
    if ($porcentaje == 0) {
        $estado_id = 1;
    } elseif ($porcentaje > 0 && $porcentaje < 50) {
        $estado_id = 2;
    } elseif ($porcentaje >= 50 && $porcentaje < 100) {
        $estado_id = 3;
    } elseif ($porcentaje >= 100) {
        $estado_id = 4;
    } else {
        $estado_id = 5;
    }

    // REVISAR SI MARCÓ "OTRA ESTRATEGIA"
    if (isset($_POST['otra_estrategia'])) {
        $estado_id = 5; // fuerza estado_id = 4
    }


    // 3. Fecha
    $fecha_actual = date("Y-m-d H:i:s");

    // 4. INSERT FINAL
    $sql = "INSERT INTO $primaryTable
(area_id, $titulocampobd3, $titulocampobd4,
   $titulocampobd8, $titulocampobd9, $titulocampobd10,
   $titulocampobd5, estado_id, $titulocampobd7)
VALUES
('$area_id', '$actividad', '$detalle',
   '$indicadores', '$meta', '$avance',
   '$porcentaje', '$estado_id', '$fecha_actual')";

    if ($conn->query($sql)) {

        $registro_id = $conn->insert_id;

        // Campos auditables
        $campos = [
            //'area_id'     => $area_id,
            'actividad'   => $actividad,
            'detalle'     => $detalle,
            'indicadores' => $indicadores,
            'meta'        => $meta,
            'avance'      => $avance
            //'porcentaje'  => $porcentaje,
            //'estado_id'   => $estado_id
            
        ];

        foreach ($campos as $campo => $valor) {
            registrarAuditoria(
                $conn,
                'INSERT',
                $primaryTable,
                $registro_id,
                $campo,
                null,
                (string)$valor
            );
        }

        echo "<script>
        alert('Actividad registrada correctamente');
        window.location = 'actividades.php';
    </script>";
    } else {
        echo "<script>
    alert('Error al registrar: " . $conn->error . "');
    window.location = 'actividades.php';
    </script>";
    }
}
