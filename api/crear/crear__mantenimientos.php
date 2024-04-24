<?php

require("../../db/base_de_datos.php");

$conn = connection();

if (!isset($_POST['idEquipo'])) {
  echo "Falta el id ";
  $conn->close();
  return;
}

if (!isset($_POST['tipo_mantenimiento'])) {
  echo "Falta el Tipo De Mantenimiento";
  $conn->close();
  return;
}
if (!isset($_POST['fecha_inicio'])) {
  echo "Falta la Fecha de Inicio";
  $conn->close();
  return;
}

if (!isset($_POST['problema'])) {
  echo "Falta el Problema";
  $conn->close();
  return;
}

if (!isset($_POST['quienCC'])) {
  echo "Falta la Sede";
  $conn->close();
  return;
}

$idEquipo = $_POST['idEquipo'];
$tipo_mantenimiento = $_POST['tipo_mantenimiento'];
$fecha_inicio = $_POST['fecha_inicio'];
$problema = $_POST['problema'];
$quienCC = $_POST['quienCC'];

$query = "INSERT INTO `mantenimientos` (`id`, `tipo_mantenimiento`, `fecha_inicio`, `problema`, `idEquipo`, `quienCC`) VALUES (NULL, '$tipo_mantenimiento', '$fecha_inicio', '$problema', '$idEquipo', '$quienCC');";

$query2 = "UPDATE `equipos` SET  `estado` = '1' WHERE `equipos`.`id` = $idEquipo;";

try {
  $conn->query($query);
  $conn->query($query2);
  echo "Mantenimiento Creado para el equipo $idEquipo";
  // } catch (\Throwable $th) {
} catch (mysqli_sql_exception $exception) {
  echo "Error al crear el Mantenimiento" . $exception;
}

$conn->close();
