<?php

include 'config.php';

$proyecto = $_POST['proyecto'] ?? '';

$sql = "
SELECT
  i.id,
  i.estado_id,
  i.etapa_id,
  i.fecha_inicio,
  i.fecha_final,
  i.fecha_reprogramada
FROM inversiones_seg_inversiones i
JOIN inversiones_seg_proyecto p ON p.id = i.proyecto_id
WHERE p.nombre = ?
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $proyecto);
$stmt->execute();
$res = $stmt->get_result();

$actividades = [];
$porEtapa = [1 => [], 2 => [], 3 => []];

while ($r = $res->fetch_assoc()) {
  $actividades[] = $r;
  if (isset($porEtapa[$r['etapa_id']])) {
    $porEtapa[$r['etapa_id']][] = $r;
  }
}

$totalActividades = count($actividades);

/* ======================================================
   LINEA: AVANCE POR FECHAS (LÓGICA CORRECTA)
====================================================== */

$totalCompletadas = 0;
$completadasSinFecha = 0;
$eventos = [];

// 1️⃣ Clasificar actividades completadas
foreach ($actividades as $a) {

  if ($a['estado_id'] == 2) { // COMPLETADO
    $totalCompletadas++;

    $fecha = $a['fecha_reprogramada'] ?: $a['fecha_final'];

    if ($fecha) {
      if (!isset($eventos[$fecha])) {
        $eventos[$fecha] = 0;
      }
      $eventos[$fecha]++;
    } else {
      // completadas SIN fecha
      $completadasSinFecha++;
    }
  }
}

// 2️⃣ Ordenar eventos por fecha
ksort($eventos);

// 3️⃣ Construir línea de avance
$labels = [];
$dataLinea = [];

// avance base (sin fecha)
$acumulado = $completadasSinFecha;

// si hay eventos con fecha, el primer punto ya arranca con base
foreach ($eventos as $fecha => $cantidad) {

  $acumulado += $cantidad;

  $avance = ($totalActividades > 0)
    ? ($acumulado / $totalActividades) * 100
    : 0;

  $labels[] = date('d/m/Y', strtotime($fecha));
  $dataLinea[] = round($avance, 2);
}

// si NO hay fechas pero sí avance
if (empty($labels) && $totalCompletadas > 0) {
  $labels[] = 'Avance actual';
  $dataLinea[] = round(($totalCompletadas / $totalActividades) * 100, 2);
}

/* ======================================================
   DONAS: AVANCE POR ETAPA (SIN CAMBIOS)
====================================================== */

$donas = [];

foreach ($porEtapa as $etapa => $acts) {

  $total = count($acts);
  $completadas = 0;

  foreach ($acts as $a) {
    if ($a['estado_id'] == 2) {
      $completadas++;
    }
  }

  $donas[$etapa] = [
    'avance'   => $total > 0 ? round(($completadas / $total) * 100, 2) : 0,
    'restante' => $total > 0 ? round(100 - (($completadas / $total) * 100), 2) : 100
  ];
}

echo json_encode([
  'labels' => $labels,
  'linea'  => $dataLinea,
  'donas'  => $donas
], JSON_UNESCAPED_UNICODE);
