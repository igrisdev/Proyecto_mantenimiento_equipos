<?php

include("../../db/database.php");

$conn = connection();

if (!isset($_POST['nombre'])) {
  echo "Falta el Nombre";
  $conn->close();
  return;
}

$nombre = $_POST['nombre'];

$query = "UPDATE `sedes` SET `nombre` = '222' WHERE `sedes`.`id` = 2;";

try {
  $conn->query($query);
  echo "Sede Creada";
} catch (\Throwable $th) {
  echo "Error al crear la Sede";
}
