<?php

require("../../db/database.php");

$conn = connection();

if (!isset($_POST['tipo'])) {
  echo "Falta el Tipo";
  $conn->close();
  return;
}

if (!isset($_POST['idMarca'])) {
  echo "Falta la Marca";
  $conn->close();
  return;
}

if (!isset($_POST['idSala'])) {
  echo "Falta la Sala";
  $conn->close();
  return;
}

if (!isset($_POST['codigo'])) {
  echo "Falta el Codigo";
  $conn->close();
  return;
}

if (!isset($_POST['fecha_ingreso'])) {
  echo "Falta la fecha de ingreso";
  $conn->close();
  return;
}

if (!isset($_POST['estado'])) {
  echo "Falta el estado";
  $conn->close();
  return;
}

$tipo = $_POST['tipo'];
$idMarca = $_POST['idMarca'];
$idSala = $_POST['idSala'];
$codigo = $_POST['codigo'];
$fecha_ingreso = $_POST['fecha_ingreso'];
$estado = $_POST['estado'];

$query = "INSERT INTO `equipos` (`id`, `tipo`, `idMarca`, `idSala`, `codigo`, `fecha_ingreso`, `estado`) VALUES (NULL,  '$tipo', '$idMarca', '$idSala', '$codigo', '$fecha_ingreso', '$estado')";


try {
  $conn->query($query);
  echo "Equipo Creado";
} catch (\Throwable $th) {
  echo "Error al crear el Equipo";
}

$conn->close();
