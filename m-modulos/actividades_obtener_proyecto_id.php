<?php
include '../00_includes/conn.php';

if(isset($_POST['nombre'])){

    $nombre = $conn->real_escape_string($_POST['nombre']);

    $q = $conn->query("
        SELECT id 
        FROM inversiones_seg_proyecto 
        WHERE nombre = '$nombre'
        LIMIT 1
    ");

    if($q && $q->num_rows > 0){
        $row = $q->fetch_assoc();
        echo json_encode($row);
    } else {
        echo json_encode(['id' => null]);
    }
}
?>
