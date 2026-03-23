<?php
session_start();
include 'config.php';
include 'actividades_auditoria_helper.php';

$response = ['success' => false, 'message' => ''];

if (!isset($_POST['id'])) {
    $response['message'] = 'ID no válido';
    echo json_encode($response);
    exit;
}

$id = intval($_POST['id']);
$role = $_SESSION['role_id'];
$userArea = $_SESSION['area_id'] ?? 0;

/* ======================================
   OBTENER DATA (ANTES DE BORRAR)
====================================== */

$sql = "SELECT * FROM inversiones_seg_inversiones WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$res = $stmt->get_result();

if ($res->num_rows === 0) {
    $response['message'] = 'Actividad no encontrada';
    echo json_encode($response);
    exit;
}

$oldData = $res->fetch_assoc();
$areaActividad = intval($oldData['area_id']);

/* ======================================
   VALIDAR PERMISOS
====================================== */

$puedeEliminar = false;

if ($role == 1) {
    $puedeEliminar = true;
}

if ($role == 2 && $areaActividad == $userArea) {
    $puedeEliminar = true;
}

if (!$puedeEliminar) {
    $response['message'] = 'No tienes permisos para eliminar esta actividad';
    echo json_encode($response);
    exit;
}

/* ======================================
   ELIMINAR
====================================== */

$delete = $conn->prepare("DELETE FROM inversiones_seg_inversiones WHERE id = ?");
$delete->bind_param("i", $id);

if ($delete->execute()) {

    /* ======================================
       AUDITORÍA (UN SOLO REGISTRO)
    ====================================== */

    $observacion = "Eliminación de actividad nro $id";

    $snapshot = json_encode(
        $oldData,
        JSON_UNESCAPED_UNICODE | JSON_PARTIAL_OUTPUT_ON_ERROR
    );

    registrarAuditoria(
        $conn,
        'DELETE',
        'inversiones_seg_inversiones',
        $id,
        'ELIMINACION',
        $snapshot,   // 🔥 TODO el registro antes de borrar
        '',
        $observacion
    );

    $response['success'] = true;
    $response['message'] = 'Actividad eliminada correctamente';

} else {
    $response['message'] = 'Error al eliminar: ' . $conn->error;
}

echo json_encode($response);