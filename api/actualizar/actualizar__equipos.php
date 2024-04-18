<?php

include("../../db/database.php");

$conn = connection();

if (!isset($_POST['id'])) {
  echo "Falta el Id";
  $conn->close();
  return;
}

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

$id = $_POST['id'];
$tipo = $_POST['tipo'];
$idMarca = $_POST['idMarca'];
$idSala = $_POST['idSala'];

$query = "UPDATE `equipos` SET `tipo` = '$tipo', `idMarca` = '$idMarca', `idSala` = '$idSala' WHERE `equipos`.`id` = $id;";

try {
  $conn->query($query);

  echo "Equipo $id Actualizado";
} catch (\Throwable $th) {
  echo "Error al actualizar el Equipo";
}

$conn->close();
