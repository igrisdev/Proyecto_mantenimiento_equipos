<?php

include("../../db/database.php");

$conn = connection();

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

$cc = $_POST['cc'];
$nombre = $_POST['nombre'];

$query = "INSERT INTO `monitores` (`cc`, `nombre`) VALUES ('$cc', '$nombre');";

try {
  $conn->query($query);
  echo "Monitor Creada";
} catch (\Throwable $th) {
  echo "Error al crear el Monitor";
}
