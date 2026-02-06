<?php
function registrarAuditoria(
    $conn,
    $accion,
    $tabla,
    $registro_id,
    $campo,
    $valor_anterior,
    $valor_nuevo,
    $observacion = null // 🔥 NUEVO
) {

    if (!isset($_SESSION['user_id'])) {
        return;
    }

    $usuario_id = $_SESSION['user_id'];
    $area_id    = $_SESSION['area_id'] ?? 0; // 🔥 evitar NULL

    $ip = $_SERVER['REMOTE_ADDR'] ?? null;

    if ($ip === '::1') {
        $ip = '127.0.0.1';
    }

    $agent = $_SERVER['HTTP_USER_AGENT'] ?? null;
    $fecha = date('Y-m-d H:i:s');

    $stmt = $conn->prepare("

        INSERT INTO inversiones_seg_auditoria
        (
            usuario_id,
            area_id,
            accion,
            tabla_afectada,
            registro_id,
            campo,
            valor_anterior,
            valor_nuevo,
            observacion,       -- 🔥
            fecha,
            ip_usuario,
            user_agent
        )

        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)

    ");

    $stmt->bind_param(
        "iississsssss",
        $usuario_id,
        $area_id,
        $accion,
        $tabla,
        $registro_id,
        $campo,
        $valor_anterior,
        $valor_nuevo,
        $observacion, // 🔥
        $fecha,
        $ip,
        $agent
    );

    $stmt->execute();
    $stmt->close();
}
?>