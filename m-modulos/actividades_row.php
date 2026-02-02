<?php

include '../00_includes/conn.php';

if (isset($_POST['id'])) {

    $id = (int) $_POST['id'];

    $sql = "SELECT 
        i.id,
        i.proyecto_id,
        i.etapa_id,
        i.area_id,
        i.estado_id,
        p.nombre AS proyecto_name,
        e.nombre AS etapa_name,
        a.nombre AS area_name,
        es.descripcion AS estado_name,
        i.responsable_nombre,
        i.responsable_apellidop,
        i.responsable_apellidom,
        CONCAT(
            COALESCE(i.responsable_nombre, ''), ' ',
            COALESCE(i.responsable_apellidop, ''), ' ',
            COALESCE(i.responsable_apellidom, '')
        ) AS responsable_nombre_completo,
        i.actividad,
        i.fecha_inicio,
        i.fecha_final,
        i.dias,
        i.fecha_reprogramada,
        i.fecha_reprogramada_inicio
    FROM inversiones_seg_inversiones i
    LEFT JOIN inversiones_seg_proyecto p ON i.proyecto_id = p.id
    LEFT JOIN inversiones_seg_etapa e ON i.etapa_id = e.id
    LEFT JOIN inversiones_seg_area a ON i.area_id = a.id
    LEFT JOIN inversiones_seg_estado es ON i.estado_id = es.id
    WHERE i.id = ?
    LIMIT 1";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();

    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    echo json_encode($row);
}
