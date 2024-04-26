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
$fecha_fin = $_POST['fecha_fin'];

$query = trim($fecha_fin) == '' ? "UPDATE `mantenimientos` SET `tipo_mantenimiento`='$tipo_mantenimiento',`problema`='$problema',`descripcion`='$descripcion',`idEquipo`='$idEquipo', `quienCC`='$quienCC', `fecha_fin`=NULL WHERE `id`=$id"
  :
  "UPDATE `mantenimientos` SET `tipo_mantenimiento`='$tipo_mantenimiento',`problema`='$problema',`descripcion`='$descripcion',`idEquipo`='$idEquipo', `quienCC`='$quienCC', `fecha_fin`='$fecha_fin' WHERE `id`=$id";

$query2 = trim($fecha_fin) == '' ? "UPDATE `equipos` SET  `estado` = '0' WHERE `equipos`.`id` = $idEquipo;"
  :
  "UPDATE `equipos` SET  `estado` = '1' WHERE `equipos`.`id` = $idEquipo;";

try {
  $conn->query($query);
  $conn->query($query2);
  echo "Mantenimiento  $id actualizado";
} catch (\Throwable $th) {
  echo "Error al actualizar el Mantenimiento";
}

$conn->close();
