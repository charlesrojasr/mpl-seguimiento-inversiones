<?php
	//include '../00_includes/session.php';
include '../00_includes/conn.php';

if(isset($_POST['id'])&&isset($_POST['tabla'])){
	$tabla1= $_POST['tabla'];
	$id = $_POST['id'];
	

	$sql = "SELECT 
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
 FROM 
    dashboard_seg_actividad AS act
JOIN 
    dashboard_seg_area AS ar ON act.area_id = ar.id
JOIN 
    dashboard_seg_estado AS es ON act.estado_id = es.id
 WHERE act.id = '$id'
 ORDER BY 
    act.id DESC;";
    $query = $conn->query($sql);
    $row = $query->fetch_assoc();


    echo json_encode($row);
}
?>