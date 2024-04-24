<?php

require("../../db/base_de_datos.php");

$conn = connection();

if (!isset($_POST['tabla'])) {
  echo "No esta definida la tabla";
  return;
}

if (!isset($_POST['buscar'])) {
  echo "No hay texto en el buscador";
  return;
}

$tabla = $_POST['tabla'];
$buscar = $_POST['buscar'];

if ($tabla !== 'equipos' && $tabla !== 'mantenimientos' && $tabla !== 'monitores') {
  $query = "SELECT * FROM `$tabla` WHERE `id` LIKE '%$buscar%' OR `nombre` LIKE '%$buscar%'";
}

if ($tabla === 'monitores') {
  $query = "SELECT * FROM `$tabla` WHERE `cc` LIKE '%$buscar%' OR `nombre` LIKE '%$buscar%'";
}

if ($tabla === 'equipos') {
  $query = "SELECT equipos.id, equipos.codigo, equipos.tipo, equipos.idMarca, salas.id as idSala, salas.idSede, equipos.fecha_ingreso as 'fecha_ingreso', IF(mantenimientos.fecha_inicio IS NOT NULL, mantenimientos.fecha_inicio, '') as 'ultimo mantenimiento', if(mantenimientos.fecha_inicio IS NOT NULL, DATE_ADD(mantenimientos.fecha_inicio, INTERVAL 6 MONTH), DATE_ADD(equipos.fecha_ingreso, INTERVAL 6 MONTH)) as 'siguiente mantenimiento', equipos.estado FROM equipos LEFT JOIN salas ON equipos.idSala = salas.id LEFT JOIN mantenimientos ON equipos.id = mantenimientos.idEquipo WHERE equipos.id LIKE '%$buscar%' OR equipos.codigo LIKE '%$buscar%' OR equipos.tipo LIKE '%$buscar%' OR equipos.idMarca LIKE '%$buscar%'";
}

if ($tabla === 'mantenimientos') {
  $query = "SELECT * FROM `$tabla` WHERE `id` LIKE '%$buscar%' OR `problema` LIKE '%$buscar%' OR `tipo_mantenimiento` LIKE '%$buscar%' OR `descripcion` LIKE '%$buscar%'";
}

try {
  $result = $conn->query($query);
  echo json_encode($result->fetch_all(MYSQLI_ASSOC));
} catch (mysqli_sql_exception $exception) {
  echo "Error interno" . $exception;
}

$conn->close();
