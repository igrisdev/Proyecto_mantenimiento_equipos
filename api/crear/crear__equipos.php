<?php

include("../../db/database.php");

$conn = connection();

if (!isset($_POST['tipo'])) {
  echo "Falta el Tipo";
  $conn->close();
  return;
}

if (!isset($_POST['idMarca'])) {
  echo "Falta la Sede";
  $conn->close();
  return;
}

if (!isset($_POST['idSala'])) {
  echo "Falta la Sede";
  $conn->close();
  return;
}

$tipo = $_POST['tipo'];
$idMarca = $_POST['idMarca'];
$idSala = $_POST['idSala'];

$query = "INSERT INTO `equipos` (`id`, `tipo`, `idMarca`, `idSala`) VALUES (NULL, '$tipo', '$idMarca', '$idSala');";

try {
  $conn->query($query);
  echo "Equipo Creado";
} catch (\Throwable $th) {
  echo "Error al crear el Equipo";
}

$conn->close();
