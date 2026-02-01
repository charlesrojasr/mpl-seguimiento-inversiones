<?php
include 'config.php';   // 👈 ESTO ES CLAVE


$idiomaM = "es";

$primaryTable = "dashboard_seg_actividad";

$titulocampobd1 = 'id';
$titulocampobd2 = 'area_nombre';
$titulocampobd3 = 'actividad';

$titulocampobd8 = 'indicadores';
$titulocampobd9 = 'meta';
$titulocampobd10 = 'avance';

$titulocampobd4 = 'detalle';
$titulocampobd5 = 'porcentaje';
$titulocampobd6 = 'estado_descripcion';
$titulocampobd7 = 'fecha_registro';

$titulocampobd11 = 'area_id';
$titulocampobd12 = 'estado_id';



$titulocampobd1P = 'Actividad';
$titulocampobd2P = 'Área Responsable';
$titulocampobd3P = 'Actividad Propuesta/Ofrecida';
$titulocampobd8P = 'Indicadores';
$titulocampobd9P = 'Meta';
$titulocampobd10P = 'Avance';
$titulocampobd4P = 'Detalles Complementarios';
$titulocampobd5P = 'Porcentaje (avanzado/previsto)';
$titulocampobd6P = 'Estado';
$titulocampobd7P = 'Fecha de Registro';



$modulo_add = "actividades_modal_add_f.php";
$modulo_edit = "actividades_modal_edit_f.php";
$modulo_add_meses = "actividades_modal_add_meses_f.php";

$sql = "
SELECT 
    act.id,
    act.area_id,
    ar.nombre AS area_nombre,
    act.actividad,
    act.indicadores,
    act.meta,
    act.avance,
    act.detalle,
    act.porcentaje,
    act.estado_id,
    es.descripcion AS estado_descripcion,
    act.fecha_registro
FROM dashboard_seg_actividad act
JOIN dashboard_seg_area ar ON act.area_id = ar.id
JOIN dashboard_seg_estado es ON act.estado_id = es.id
";

if ($isAreaUser) {
    $sql .= " WHERE act.area_id = ?";
}

$sql .= " ORDER BY act.id DESC";

$stmt = $conn->prepare($sql);

if ($isAreaUser) {
    $stmt->bind_param("i", $area_id);
}

$stmt->execute();
$getAllMotoTaxy = $stmt->get_result();


?>