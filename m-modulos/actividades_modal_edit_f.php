<?php
include 'actividades_config.php';
include 'actividades_auditoria_helper.php';

if (isset($_POST['edit'])) {

    // ----------------------------------------------------
    // FUNCIÓN DE LIMPIEZA
    // ----------------------------------------------------
    function limpiar($conn, $texto)
    {
        return mysqli_real_escape_string($conn, trim($texto));
    }

    // ----------------------------------------------------
    // 1. RECIBIR ID
    // ----------------------------------------------------
    $id = intval($_POST['id']);

    // ----------------------------------------------------
    // 2. CONTROL DE ÁREA / ROL (UNIFICADO)
    // ----------------------------------------------------
    if ($isAreaUser) {

        // Todo lo sensible se toma desde BD / sesión
        $area_id = $_SESSION['area_id'];

        $stmt = $conn->prepare("
        SELECT meta, actividad, indicadores 
        FROM $primaryTable 
        WHERE id = ?
    ");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->bind_result($meta, $actividad, $indicadores);
        $stmt->fetch();
        $stmt->close();
    } else {

        // Admin u otros roles
        $area_id     = intval($_POST['area_id']);
        $meta        = floatval($_POST[$titulocampobd9]);
        $actividad   = limpiar($conn, $_POST[$titulocampobd3]);
        $indicadores = limpiar($conn, $_POST[$titulocampobd8]);
    }


    // ----------------------------------------------------
    // 3. CAMPOS DEL FORMULARIO
    // ----------------------------------------------------
    $detalle = limpiar($conn, $_POST[$titulocampobd4]);
    $avance  = floatval($_POST[$titulocampobd10]);


    // ----------------------------------------------------
    // 4. CÁLCULO DE PORCENTAJE
    // ----------------------------------------------------
    if ($meta > 0) {
        $porcentaje = round(($avance / $meta) * 100);
    } else {
        $porcentaje = 0;
    }

    // ----------------------------------------------------
    // 5. ESTADO AUTOMÁTICO
    // ----------------------------------------------------
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

    // Si marcó "otra estrategia", fuerza estado 5
    if (isset($_POST['otra_estrategia'])) {
        $estado_id = 5;
    }

    // ----------------------------------------------------
    // 6. OBTENER VALORES ANTERIORES (AUDITORÍA)
    // ----------------------------------------------------
    $old = [];
    $res = $conn->query("SELECT * FROM $primaryTable WHERE id = $id");
    if ($res && $res->num_rows === 1) {
        $old = $res->fetch_assoc();
    }

    // ----------------------------------------------------
    // 7. UPDATE PRINCIPAL
    // ----------------------------------------------------
    $sql = "UPDATE $primaryTable SET 
        actividad   = '$actividad',
        detalle     = '$detalle',
        indicadores = '$indicadores',
        meta        = '$meta',
        avance      = '$avance',
        porcentaje  = '$porcentaje',
        area_id     = '$area_id',
        estado_id   = '$estado_id'
        WHERE id    = '$id'";

    // ----------------------------------------------------
    // 8. TRANSACCIÓN + AUDITORÍA
    // ----------------------------------------------------
    $conn->begin_transaction();

    try {

        if (!$conn->query($sql)) {
            throw new Exception($conn->error);
        }

        // Campos auditables
        $nuevos = [
            'actividad'   => $actividad,
            'detalle'     => $detalle,
            'indicadores' => $indicadores,
            'meta'        => $meta,
            'avance'      => $avance,
            //'porcentaje'  => $porcentaje,
            //'estado_id'   => $estado_id
            'area_id'     => $area_id
        ];

        foreach ($nuevos as $campo => $valor_nuevo) {

            $valor_anterior = $old[$campo] ?? null;

            // Comparación robusta
            if (is_numeric($valor_anterior) && is_numeric($valor_nuevo)) {
                $cambio = ((float)$valor_anterior !== (float)$valor_nuevo);
            } else {
                $cambio = ((string)$valor_anterior !== (string)$valor_nuevo);
            }

            if ($cambio) {
                registrarAuditoria(
                    $conn,
                    'UPDATE',
                    $primaryTable,
                    $id,
                    $campo,
                    (string)$valor_anterior,
                    (string)$valor_nuevo
                );
            }
        }

        $conn->commit();

        echo "<script>
            alert('Actividad actualizada correctamente');
            window.location = 'actividades.php';
        </script>";
    } catch (Exception $e) {

        $conn->rollback();

        echo "<script>
            alert('Error al actualizar: {$e->getMessage()}');
            window.location = 'actividades.php';
        </script>";
    }
}
