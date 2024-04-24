<?php

require("../../db/database.php");

$conn = connection();

if (!isset($_POST['cc'])) {
  echo "Falta el Id";
  $conn->close();
  return;
}

if (!isset($_POST['cc'])) {
  echo "Falta el Nombre";
  $conn->close();
  return;
}

if (!isset($_POST['nombre'])) {
  echo "Falta el Nombre";
  $conn->close();
  return;
}

$id = $_POST['cc'];
$cc = $_POST['cc'];
$nombre = $_POST['nombre'];


$query = "UPDATE monitores SET cc='$cc', nombre='$nombre' WHERE cc=$id";

try {
  $conn->query($query);
  echo "Monitor $id Actualizado";
} catch (\Throwable $th) {
  echo "Error al crear el Monitor";
}
