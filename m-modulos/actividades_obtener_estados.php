<?php
include '../00_includes/conn.php';

function obtenerEstados() {
    global $conn;
    $q = $conn->query("SELECT id, descripcion FROM inversiones_seg_estado ORDER BY descripcion");
    $estados = [];
    while ($row = $q->fetch_assoc()) {
        $estados[] = $row;
    }
    return $estados;
}
