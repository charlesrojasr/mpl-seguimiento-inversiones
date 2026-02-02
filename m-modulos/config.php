<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include '../00_includes/conn.php';

$idiomaM = "es";

$appModulo = "SEGUIMIENTO DE INVERSIONES"; 


// 1️⃣ Validación de sesión
if (!isset($_SESSION['user_id'], $_SESSION['role_id'])) {
    header('Location: ../m-admin/index.php');
    exit();
}

// 2️⃣ AHORA sí, leemos las variables de sesión
$role_id = $_SESSION['role_id'];
$area_id = $_SESSION['area_id'] ?? null;

// 3️⃣ Flags de rol (después de asignar)
$isAdmin    = ($role_id == 1);
$isAreaUser = ($role_id == 2);

// 4️⃣ Validación opcional por área
if ($isAreaUser && empty($area_id)) {
    die("Usuario sin área asignada.");
}
// Obtener permisos del usuario (data-driven)
$stmt = $conn->prepare("
    SELECT p.permission_name, p.permission_modulo
    FROM inversiones_seg_permissions p
    JOIN inversiones_seg_role_permissions rp
         ON p.id = rp.permission_id
    WHERE rp.role_id = ?
");

if (!$stmt) {
    die("Error SQL: " . $conn->error);
}

$stmt->bind_param("i", $role_id);
$stmt->execute();
$permissions = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
?>
