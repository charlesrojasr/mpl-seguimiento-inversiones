<?php

include '../00_includes/conn.php';

$id = $_POST['id'] ?? 0;

if (!$id) {
    echo json_encode([]);
    exit;
}


/* ===============================
   QUERY
================================ */

$sql = "SELECT
    a.id,

    CONCAT(
        u.nombre,' ',
        u.apellido_paterno,' ',
        u.apellido_materno
    ) AS nombre_completo_usuario,

    ar.nombre AS nombre_area,

    a.accion,
    a.tabla_afectada,
    a.registro_id,
    a.campo,
    a.valor_anterior,
    a.valor_nuevo,
    a.fecha

FROM inversiones_seg_auditoria a

LEFT JOIN inversiones_seg_user_profile u
    ON u.user_id = a.usuario_id

LEFT JOIN inversiones_seg_area ar
    ON ar.id = a.area_id


WHERE a.registro_id = ?
AND a.campo IN (
    'fecha_reprogramada',
    'fecha_reprogramada_inicio'
)

ORDER BY a.id DESC

";


$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();

$result = $stmt->get_result();

$data = [];

while ($row = $result->fetch_assoc()) {

    $data[] = $row;

}

echo json_encode($data, JSON_UNESCAPED_UNICODE);
