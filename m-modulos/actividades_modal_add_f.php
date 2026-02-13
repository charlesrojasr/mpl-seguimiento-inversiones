


<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'actividades_config.php';
include 'actividades_auditoria_helper.php';

if (isset($_POST['add'])) {

    function limpiar($conn, $texto)
    {
        return mysqli_real_escape_string($conn, trim($texto));
    }

    /* =====================================
       1️⃣ CAMPOS BASE
    ===================================== */

    // PROYECTO (obligatorio)
    $proyecto_id = intval($_POST['proyecto_id'] ?? 0);

    if ($proyecto_id <= 0) {
        die("Proyecto inválido.");
    }

    // ÁREA
    if ($isAreaUser) {
        $area_id = $_SESSION['area_id'];
    } else {
        $area_id = intval($_POST['area_id'] ?? 0);
    }

    // ETAPA
    $etapa_id = intval($_POST['etapa_id'] ?? 0);

    // ACTIVIDAD
    $actividad = limpiar($conn, $_POST[$titulocampobd6] ?? '');

    // DÍAS (NULL si viene vacío)
    $dias = $_POST[$titulocampobd8] ?? null;
    $dias = ($dias === '' || $dias === null) ? "NULL" : intval($dias);

    // FECHA INICIO
    $fecha_inicio = $_POST[$titulocampobd7] ?? null;
    $fecha_inicio = !empty($fecha_inicio) ? "'$fecha_inicio'" : "NULL";

    // FECHA FINAL
    $fecha_final_post = $_POST[$titulocampobd9] ?? null;

    if ($dias !== "NULL" && $fecha_inicio !== "NULL") {

        // Si hay días → calcular automáticamente
        $fecha_final_calc = date(
            'Y-m-d',
            strtotime(trim($fecha_inicio, "'") . " + $dias days")
        );

        $fecha_final = "'$fecha_final_calc'";
    } else {

        // Si NO hay días → usar la fecha enviada por el usuario
        if (!empty($fecha_final_post)) {
            $fecha_final = "'$fecha_final_post'";
        } else {
            $fecha_final = "NULL";
        }
    }


    // ESTADO INICIAL = SIN INICIAR (1)
    $estado_id = 1;

    /* =====================================
       2️⃣ INSERT
    ===================================== */

    /* =====================================
   2️⃣ INSERT
===================================== */

    $sql = "INSERT INTO inversiones_seg_inversiones (
        proyecto_id,
        etapa_id,
        area_id,
        actividad,
        dias,
        fecha_inicio,
        fecha_final,
        estado_id
    )
    VALUES (
        '$proyecto_id',
        '$etapa_id',
        '$area_id',
        '$actividad',
        $dias,
        $fecha_inicio,
        $fecha_final,
        '1'
    ) ";


    if ($conn->query($sql)) {

        $registro_id = $conn->insert_id;

        /* =====================================
           3️⃣ AUDITORÍA
        ===================================== */

        $camposAuditar = [
            'proyecto_id' => $proyecto_id,
            'etapa_id'    => $etapa_id,
            'area_id'     => $area_id,
            'actividad'   => $actividad,
            'dias'        => ($dias === "NULL") ? null : $dias,
            'fecha_inicio' => trim($fecha_inicio, "'"),
            'fecha_final' => trim($fecha_final, "'"),
            'estado_id'   => $estado_id
        ];

        foreach ($camposAuditar as $campo => $valor) {

            registrarAuditoria(
                $conn,
                'INSERT',
                'inversiones_seg_inversiones',
                $registro_id,
                $campo,
                null,
                (string)$valor
            );
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
    } else {

        echo "<script>
            alert('Error al registrar: " . $conn->error . "');
            window.location = 'actividades.php';
        </script>";
    }
}
