<?php

include("../../db/database.php");

$conn = connection();

if (!isset($_POST['tipo_mantenimiento'])) {
  echo "Falta el Tipo De Mantenimiento";
  $conn->close();
  return;
}

if (!isset($_POST['problema'])) {
  echo "Falta el Problema";
  $conn->close();
  return;
}

if (!isset($_POST['descripcion'])) {
  echo "Falta la Descripción";
  $conn->close();
  return;
}

if (!isset($_POST['idEquipo'])) {
  echo "Falta el id ";
  $conn->close();
  return;
}

if (!isset($_POST['quienCC'])) {
  echo "Falta la Sede";
  $conn->close();
  return;
}

$tipo_mantenimiento = $_POST['tipo_mantenimiento'];
$problema = $_POST['problema'];
$descripcion = $_POST['descripcion'];
$idEquipo = $_POST['idEquipo'];
$quienCC = $_POST['quienCC'];

$query = "INSERT INTO `mantenimientos` (`id`, `tipo_mantenimiento`, `problema`, `descripcion`, `idEquipo`, `quienCC`) VALUES (NULL, '$tipo_mantenimiento', '$problema', '$descripcion', '$idEquipo', '$quienCC');";

try {
  $conn->query($query);
  echo "Mantenimiento Creado";
  // } catch (\Throwable $th) {
} catch (mysqli_sql_exception $exception) {
  echo "Error al crear el Mantenimiento" . $exception;
}

$conn->close();
