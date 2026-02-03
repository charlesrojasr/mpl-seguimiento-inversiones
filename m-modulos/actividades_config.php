<?php

include 'config.php'; // Conexión DB

$alertas = [];

$sqlAlertas = "SELECT 
    i.id,
    i.proyecto_id,
    i.etapa_id,
    i.area_id,
    i.estado_id,
    i.actividad,
    p.nombre AS proyecto_name,
    e.nombre AS etapa_name,
    a.nombre AS area_name,
    es.descripcion AS estado_name,
    i.fecha_final,
    i.fecha_reprogramada,
    i.fecha_reprogramada_inicio,

    CASE 
        WHEN i.estado_id = 1 THEN DATEDIFF(i.fecha_final, CURDATE())
        WHEN i.estado_id = 3 THEN DATEDIFF(i.fecha_reprogramada, CURDATE())
        WHEN i.estado_id = 4 THEN DATEDIFF(i.fecha_reprogramada, CURDATE())
        WHEN i.estado_id = 5 THEN DATEDIFF(i.fecha_reprogramada, CURDATE())
    END AS dias_restantes

FROM inversiones_seg_inversiones i

LEFT JOIN inversiones_seg_proyecto p 
    ON i.proyecto_id = p.id
LEFT JOIN inversiones_seg_etapa e 
    ON i.etapa_id = e.id
LEFT JOIN inversiones_seg_area a 
    ON i.area_id = a.id
LEFT JOIN inversiones_seg_estado es 
    ON i.estado_id = es.id

WHERE 
(
    i.estado_id = 1
    AND i.fecha_final IS NOT NULL
    AND DATEDIFF(i.fecha_final, CURDATE()) BETWEEN 0 AND 3
)
OR
(
    i.estado_id = 3
    AND i.fecha_reprogramada IS NOT NULL
    AND DATEDIFF(i.fecha_reprogramada, CURDATE()) BETWEEN 0 AND 3
)
OR
(
    i.estado_id = 4
    AND i.fecha_reprogramada IS NOT NULL
    AND DATEDIFF(i.fecha_reprogramada, CURDATE()) BETWEEN 0 AND 3
)
OR
(
    i.estado_id = 5
    AND i.fecha_reprogramada IS NOT NULL
    AND DATEDIFF(i.fecha_reprogramada, CURDATE()) BETWEEN 0 AND 3
);";


$resAlertas = $conn->query($sqlAlertas);

while ($row = $resAlertas->fetch_assoc()) {
    $alertas[] = $row;
}




$idiomaM = "es";


$titulocampobd1  = 'id';
$titulocampobd2  = 'proyecto_name';
$titulocampobd3  = 'etapa_name';
$titulocampobd4  = 'area_name';
$titulocampobd5  = 'responsable_nombre_completo';
$titulocampobd6  = 'actividad';
$titulocampobd7  = 'fecha_inicio';
$titulocampobd8  = 'dias';
$titulocampobd9  = 'fecha_final';
$titulocampobd10 = 'estado_name';
$titulocampobd11 = 'fecha_reprogramada';
$titulocampobd12  = 'responsable_nombre';
$titulocampobd13  = 'responsable_apellidop';
$titulocampobd14  = 'responsable_apellidom';
$titulocampobd15  = 'fecha_reprogramada_inicio';


/*
|--------------------------------------------------------------------------
| TITULOS DE TABLA
|--------------------------------------------------------------------------
*/

$titulocampobd1P  = 'Nro';
$titulocampobd2P  = 'Inversión';
$titulocampobd3P  = 'Etapa';
$titulocampobd4P  = 'Unidad Orgánica';
$titulocampobd5P  = 'Responsable';
$titulocampobd6P  = 'Actividad';
$titulocampobd7P  = 'Fecha Inicio';
$titulocampobd8P  = 'Días';
$titulocampobd9P  = 'Fecha Final';
$titulocampobd10P = 'Estado';
$titulocampobd11P = 'Fecha Fin Reprogramada';
$titulocampobd15P = 'Fecha Inicio Reprogramada';


/*
|--------------------------------------------------------------------------
| CONSULTA PRINCIPAL
|--------------------------------------------------------------------------
*/

$sql = "SELECT 
    i.id,
    i.proyecto_id,
    p.nombre AS proyecto_name,
    i.etapa_id,
    e.nombre AS etapa_name,
    i.area_id,
    a.nombre AS area_name,
    i.estado_id,
    es.descripcion AS estado_name,
    CONCAT(
        COALESCE(i.responsable_nombre, ''),
        ' ',
        COALESCE(i.responsable_apellidop, ''),
        ' ',
        COALESCE(i.responsable_apellidom, '')
    ) AS responsable_nombre_completo,
    i.actividad,
    i.fecha_inicio,
    i.fecha_final,
    i.dias,
    i.fecha_reprogramada,
    i.fecha_reprogramada_inicio

FROM inversiones_seg_inversiones i

LEFT JOIN inversiones_seg_proyecto p 
    ON i.proyecto_id = p.id

LEFT JOIN inversiones_seg_etapa e 
    ON i.etapa_id = e.id

LEFT JOIN inversiones_seg_area a 
    ON i.area_id = a.id

LEFT JOIN inversiones_seg_estado es 
    ON i.estado_id = es.id

ORDER BY 
    i.proyecto_id ASC,
    i.etapa_id ASC,
    i.id ASC
";

$getAllMotoTaxy = $conn->query($sql);

if (!$getAllMotoTaxy) {

    die("Error en la consulta: " . $conn->error);
}
