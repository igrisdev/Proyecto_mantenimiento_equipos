<?php

include("../../db/database.php");

$conn = connection();

if (!isset($_POST['nombre'])) {
  echo "Falta el Nombre";
  $conn->close();
  return;
}

$nombre = $_POST['nombre'];

$query = "INSERT INTO `sedes` (`id`, `nombre`) VALUES (NULL, '$nombre');";

try {
  $conn->query($query);
  echo "Sede Creada";
} catch (\Throwable $th) {
  echo "Error al crear la Sede";
}
