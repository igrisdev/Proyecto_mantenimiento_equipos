<?php

include("../../db/database.php");

$conn = connection();

if (!isset($_POST['nombre'])) {
  echo "Falta el Nombre";
  $conn->close();
  return;
}

$nombre = $_POST['nombre'];

$query = "INSERT INTO `sedes` (`id`, `nombre`) VALUES (NULL, '$nombre');";

try {
  $conn->query($query);
  echo "Sede Creada";
} catch (mysqli_sql_exception  $exception) {
  if ($exception->getCode() == 1062) {
    echo "La Sede ya existe";
    return;
  }
  echo "Error al crear la Sede";
}

$conn->close();
