<?php

include("../../db/database.php");

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
  $query = "SELECT * FROM `$tabla` WHERE `tipo` LIKE '%$buscar%'";
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
