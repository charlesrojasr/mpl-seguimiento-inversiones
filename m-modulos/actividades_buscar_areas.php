<?php
include '../00_includes/conn.php';

// Función para obtener las áreas
function obtenerAreas() {
    global $conn;
    $queryAreas = "SELECT nombre FROM dashboard_seg_area WHERE estado = 1 ORDER BY nombre ASC";  // Corregí el WHERE aquí
    $resultAreas = $conn->query($queryAreas);

    // Verificar si la consulta fue exitosa
    if ($resultAreas && $resultAreas->num_rows > 0) {
        $areas = [];
        while ($row = $resultAreas->fetch_assoc()) {
            $areas[] = $row['nombre'];
        }
        return $areas;
    } else {
        return []; // Devuelve un array vacío si no hay resultados
    }
}
?>
