<?php
include '../00_includes/conn.php';

function obtenerEtapasConId() {
    global $conn;

    $query = "SELECT id, nombre 
              FROM inversiones_seg_etapa 
              ORDER BY id ASC";

    $result = $conn->query($query);

    $etapas = [];

    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $etapas[] = [
                'id' => $row['id'],
                'nombre' => $row['nombre']
            ];
        }
    }

    return $etapas;
}
?>
