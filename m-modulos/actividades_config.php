<?php

include 'config.php'; // Conexión DB

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
$titulocampobd11P = 'Fecha Reprogramada';


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
    i.fecha_reprogramada

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

?>