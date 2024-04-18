<?php

include("../../db/database.php");

$conn = connection();

if (!isset($_POST['tabla'])) {
  echo 'Falta la Tabla';
  return;
};

if (!isset($_POST['id'])) {
  echo 'Falta el Id';
  return;
};

$tabla = $_POST['tabla'];
$id = $_POST['id'];


if ($tabla !== 'monitores') {
  $query = "DELETE FROM $tabla WHERE `$tabla`.`id` = $id";
}

if ($tabla === 'monitores') {
  $query = "DELETE FROM $tabla WHERE `$tabla`.`cc` = $id";
}

try {
  $result = $conn->query($query);

  if ($result) {
    echo "Objetivo eliminado de la tabla -> $tabla con el id -> $id ";
    return;
  }

  echo "Existe un error";
} catch (\Throwable $th) {
  echo 'No se elimino el objetivo porque esta en uso en otra tabla';
}

$conn->close();
