<?php

require("../../db/base_de_datos.php");

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
} catch (mysqli_sql_exception $exception) {
  if ($exception->getCode() == 1062) {
    echo "Monitor ya existe";
    return;
  }
  echo "Error al crear el Monitor";
}

$conn->close();
