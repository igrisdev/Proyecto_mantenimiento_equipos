<?php

require("../../db/base_de_datos.php");

$conn = connection();

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

$nombre = $_POST['nombre'];
$idSede = $_POST['idSede'];

$query = "INSERT INTO `salas` (`id`, `nombre`, `idSede`) VALUES (NULL, '$nombre', '$idSede');";

try {
  $conn->query($query);
  echo "Sala Creada";
} catch (\Throwable $th) {
  echo "Error al crear la Sala";
}

$conn->close();
