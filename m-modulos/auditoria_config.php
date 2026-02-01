<?php
include 'config.php';   // 👈 ESTO ES CLAVE

$appModulo = "AUDITORÍA DE ACTIVIDADES";

$idiomaM = "es";

$primaryTable = "dashboard_seg_auditoria";

$titulocampobd1 = 'id';
$titulocampobd2 = 'nombre_completo_usuario';
$titulocampobd3 = 'nombre_area';
$titulocampobd4 = 'accion';
$titulocampobd5 = 'tabla_afectada';
$titulocampobd6 = 'registro_id';
$titulocampobd7 = 'campo';
$titulocampobd8 = 'valor_anterior';
$titulocampobd9 = 'valor_nuevo';
$titulocampobd10 = 'fecha';

$titulocampobd1P = 'id';
$titulocampobd2P = 'Usuario';
$titulocampobd3P = 'Área';
$titulocampobd4P = 'Acción';
$titulocampobd5P = 'Tabla';
$titulocampobd6P = 'Nro Actividad';
$titulocampobd7P = 'Campo';
$titulocampobd8P = 'Valor Anterior';
$titulocampobd9P = 'Valor Nuevo';
$titulocampobd10P = 'Fecha';



$sql = "
SELECT
    a.id,
    CONCAT(
        u.nombre, ' ',
        u.apellido_paterno, ' ',
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
FROM dashboard_seg_auditoria a
LEFT JOIN dashboard_seg_user_profile u
    ON u.user_id = a.usuario_id
LEFT JOIN dashboard_seg_area ar
    ON ar.id = a.area_id
ORDER BY a.id DESC;
";


$getAllMotoTaxy = $conn->query($sql);