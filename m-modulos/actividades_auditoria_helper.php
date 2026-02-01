<?php
function registrarAuditoria(
    $conn,
    $accion,            // INSERT | UPDATE | DELETE
    $tabla,
    $registro_id,
    $campo,
    $valor_anterior,
    $valor_nuevo
) {
    if (!isset($_SESSION['user_id'])) {
        return; // fail-safe
    }

    $usuario_id = $_SESSION['user_id'];
    $area_id    = $_SESSION['area_id'] ?? null;

    $ip = $_SERVER['REMOTE_ADDR'] ?? null;

    // Normalizar IPv6 localhost
    if ($ip === '::1') {
        $ip = '127.0.0.1';
    }



    $agent      = $_SERVER['HTTP_USER_AGENT'] ?? null;
    $fecha      = date('Y-m-d H:i:s');

    $stmt = $conn->prepare("
        INSERT INTO dashboard_seg_auditoria
        (usuario_id, area_id, accion, tabla_afectada, registro_id, campo,
         valor_anterior, valor_nuevo, fecha, ip_usuario, user_agent)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
    ");

    $stmt->bind_param(
        "iississssss",
        $usuario_id,
        $area_id,
        $accion,
        $tabla,
        $registro_id,
        $campo,
        $valor_anterior,
        $valor_nuevo,
        $fecha,
        $ip,
        $agent
    );

    $stmt->execute();
    $stmt->close();
}
