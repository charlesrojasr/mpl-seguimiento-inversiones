<?php
include '../00_includes/conn.php';

// Función para obtener áreas con id y nombre
function obtenerAreasConId() {
    global $conn;
    $queryAreas = "SELECT id, nombre FROM inversiones_seg_area WHERE estado = 1 ORDER BY nombre ASC";
    $resultAreas = $conn->query($queryAreas);

    // Verificar si la consulta fue exitosa
    if ($resultAreas && $resultAreas->num_rows > 0) {
        $areas = [];
        while ($row = $resultAreas->fetch_assoc()) {
            // Devolver un array con el id y nombre de las áreas
            $areas[] = ['id' => $row['id'], 'nombre' => $row['nombre']];
        }
        return $areas;
    } else {
        return []; // Devuelve un array vacío si no hay resultados
    }
}
?>
