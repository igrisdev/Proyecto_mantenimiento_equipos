<?php

require("../../db/base_de_datos.php");

$conn = connection();

if (!isset($_POST['id'])) {
  echo "Falta el Id";
  $conn->close();
  return;
}

if (!isset($_POST['tipo_mantenimiento'])) {
  echo "Falta el Tipo De Mantenimiento";
  $conn->close();
  return;
}

if (!isset($_POST['problema'])) {
  echo "Falta el Problema";
  $conn->close();
  return;
}

if (!isset($_POST['descripcion'])) {
  echo "Falta la Descripción";
  $conn->close();
  return;
}

if (!isset($_POST['idEquipo'])) {
  echo "Falta el id ";
  $conn->close();
  return;
}

if (!isset($_POST['quienCC'])) {
  echo "Falta la Sede";
  $conn->close();
  return;
}

$id = $_POST['id'];
$tipo_mantenimiento = $_POST['tipo_mantenimiento'];
$problema = $_POST['problema'];
$descripcion = $_POST['descripcion'];
$idEquipo = $_POST['idEquipo'];
$quienCC = $_POST['quienCC'];

$query = "UPDATE `mantenimientos` SET `tipo_mantenimiento`='$tipo_mantenimiento',`problema`='$problema',`descripcion`='$descripcion',`idEquipo`='$idEquipo', `quienCC`='$quienCC' WHERE `id`=$id";

try {
  $conn->query($query);
  echo "Mantenimiento  $id actualizado";
} catch (\Throwable $th) {
  echo "Error al actualizar el Mantenimiento";
}

$conn->close();
