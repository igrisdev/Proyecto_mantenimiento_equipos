<?php

include("../../db/database.php");

$conn = connection();

if (!isset($_POST['id'])) {
  echo "Falta el Id";
  $conn->close();
  return;
}

if (!isset($_POST['nombre'])) {
  echo "Falta el Nombre";
  $conn->close();
  return;
}

$nombre = $_POST['nombre'];
$id = $_POST['id'];

$query = "UPDATE `sedes` SET `nombre` = '$nombre' WHERE `sedes`.`id` = $id;";

try {
  $conn->query($query);
  echo "Sede $id actualizada";
} catch (\Throwable $th) {
  echo "Error al actualizar la Sede";
}
