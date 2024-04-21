<?php

include("../../db/database.php");

$conn = connection();

if (!isset($_POST['nombre'])) {
  echo "Falta el Nombre";
  $conn->close();
  return;
}

$nombre = $_POST['nombre'];

$query = "INSERT INTO `marcas` (`id`, `nombre`) VALUES (NULL, '$nombre');";

try {
  $conn->query($query);
  echo "Marca Creada";
} catch (mysqli_sql_exception $exception) {
  if ($exception->getCode() == 1062) {
    echo "La Marca ya existe";
    return;
  }

  echo "Error al crear la Marca: Por ";
}

$conn->close();
