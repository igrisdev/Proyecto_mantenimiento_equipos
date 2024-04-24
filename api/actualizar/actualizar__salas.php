<?php

require("../../db/base_de_datos.php");

$conn = connection();

if (!isset($_POST['id'])) {
  echo "Falta el Nombre";
  $conn->close();
  return;
}

if (!isset($_POST['nombre'])) {
  echo "Falta el Nombre";
  $conn->close();
  return;
}

if (!isset($_POST['idSede'])) {
  echo "Falta la Sede";
  $conn->close();
  return;
}

$id = $_POST['id'];
$nombre = $_POST['nombre'];
$idSede = $_POST['idSede'];

$query = "UPDATE `salas` SET `nombre` = '$nombre', `idSede` = '$idSede' WHERE `salas`.`id` = $id;";

try {
  $conn->query($query);
  echo "Sala $id actualizada";
} catch (\Throwable $th) {
  echo "Error al actualizar la Sala";
}

$conn->close();
