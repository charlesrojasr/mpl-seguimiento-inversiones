<?php
include '../00_includes/conn.php';

// Datos del usuario a insertar
$username = 'hperez'; // Cambia el nombre de usuario aquí
$password = '07795707'; // Cambia la contraseña aquí
$role_id = 3; // Asignar el rol de administrador (ID 1)

// Encriptar la contraseña
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Preparar la consulta
$stmt = $conn->prepare("INSERT INTO dashboard_seg_users (username, password, role_id) VALUES (?, ?, ?)");
if (!$stmt) {
    die("Error en la preparación de la consulta: " . $conn->error);
}

$stmt->bind_param("ssi", $username, $hashed_password, $role_id);

if ($stmt->execute()) {
    echo "Usuario insertado correctamente.";
} else {
    echo "Error al insertar usuario: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
