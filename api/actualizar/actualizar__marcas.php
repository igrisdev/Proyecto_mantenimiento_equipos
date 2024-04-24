<?php

require("../../db/base_de_datos.php");

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

$query = "UPDATE `marcas` SET `nombre` = '$nombre' WHERE `marcas`.`id` = $id;";

try {
  $conn->query($query);
  echo "Marca $id Actualizada";
} catch (\Throwable $th) {
  echo "Error al actualizar la Marca";
}
