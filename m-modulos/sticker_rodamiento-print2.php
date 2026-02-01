<?php

include('../fpdf/fpdf.php');

class PDF extends FPDF
{
    function Header()
    {
        // Colocar la imagen de fondo (Formato de Emprendedores)
        $this->Image('https://portal.muniplibre.gob.pe/wp-content/uploads/2025/03/FORMATO-EMPRENDEDORES.png', 0, 0, 595, 842);
    }
}

// Iniciar el PDF en formato A4, orientación vertical
$pdf = new PDF('P', 'pt', 'A4');

// Asignar los datos desde el formulario
$id = $_POST['id'];
/*$nroauto = $_POST['nroauto'];
$nroexpe = $_POST['nroexpe'];
$nroresol = $_POST['nroresol'];


$fototitu = $_POST['fototitu'];


$nombretitu = $_POST['nombretitu'];
$apellidostitu = $_POST['apellidostitu'];
$dnititu = $_POST['dnititu'];
$ubititu = $_POST['ubititu'];
$giro = $_POST['giro'];
$horario = $_POST['horario'];
$horario_sin_br = str_replace('<br />', '', $horario);
$vige = $_POST['vige'];

$fechaemi = $_POST['fechaemi']; 
$date = DateTime::createFromFormat('Y-m-d', $fechaemi);
$fechaemi_formateada = $date->format('d-m-Y');

// Agregar página al PDF
$pdf->AddPage();

// Configurar fuente
$pdf->SetFont('Arial', 'B', 11);

// Aquí se especifican las posiciones y estilos de forma individual

// Primer campo: nroauto
$pdf->SetXY(180, 190);
$pdf->Cell(100, 20, utf8_decode($nroauto), 0, 1, 'L');

// Segundo campo: nroexpe
$pdf->SetXY(165, 220);
$pdf->Cell(100, 20, utf8_decode($nroexpe), 0, 1, 'L');

// Tercer campo: nroresol
$pdf->SetXY(165, 252);
$pdf->Cell(100, 20, utf8_decode($nroresol), 0, 1, 'L');

// Concatenar apellido y nombre
$nombre_completo = utf8_decode($apellidostitu . ' ' . $nombretitu);

$pdf->SetXY(225, 382);
$ancho_maximo = 300; 
$pdf->MultiCell($ancho_maximo, 20, $nombre_completo, 0, 'J'); 

// Quinto campo: dnititu
$pdf->SetXY(110, 413);
$pdf->Cell(100, 20, utf8_decode($dnititu), 0, 1, 'L');

// Sexto campo: ubtit
$pdf->SetXY(130, 440); // Ajusta la coordenada X para acercar el texto
$pdf->MultiCell(400, 12, utf8_decode($ubititu), 0, 'J'); // Ajusta la altura de la celda (por ejemplo, 10)


$pdf->SetXY(170, 481); // Ajusta la coordenada X para acercar el texto
$pdf->MultiCell(360, 15, $giro, 0, 'J'); // Ajusta la altura de la celda (por ejemplo, 10)

// Octavo campo: horario
$pdf->SetXY(240, 515); // Ajusta la coordenada X para acercar el texto
$pdf->MultiCell(290, 15, $horario_sin_br, 0, 'J'); // Ajusta la altura de la celda (por ejemplo, 10)

// Noveno campo: vige
$pdf->SetXY(130, 546);
$pdf->Cell(100, 20, utf8_decode($vige), 0, 1, 'L');


// Décimo campo: fechaemi
$pdf->SetXY(110, 750);
$pdf->Cell(100, 20, utf8_decode($fechaemi_formateada), 0, 1, 'L');

// Agregar imagen del usuario si existe
$user_image = '../temp/user_' . $id . '.png';
if (file_exists($user_image)) {
    $pdf->Image($user_image, 440, 180, 100, 100, 'PNG');
} else {
    $pdf->SetXY(150, 350);
    $pdf->Cell(150, 20, "Imagen no disponible", 0, 1, 'L');
}


$user_image1 = '../dist/fotosTitulares/' . $fototitu;
if (file_exists($user_image1)) {
    $pdf->Image($user_image1, 478, 24, 90, 90);
} else {
    $pdf->SetXY(150, 350);
    $pdf->Cell(150, 20, "Imagen no disponible", 0, 1, 'L');
}*/

// Salida del PDF
$pdf->Output();

?>
