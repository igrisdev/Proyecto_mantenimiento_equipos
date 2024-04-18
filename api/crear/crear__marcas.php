<?php

include("../../db/database.php");

$conn = connection();

if (!isset($_POST['nombre'])) {
  echo "Falta el Nombre";
  $conn->close();
  return;
}

$nombre = $_POST['nombre'];

$query = "INSERT INTO `marcas` (`id`, `nombre`) VALUES (NULL, '$nombre');";

try {
  $conn->query($query);
  echo "Marca Creada";
} catch (\Throwable $th) {
  echo "Error al crear la Marca";
}
