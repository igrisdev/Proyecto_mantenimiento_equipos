<?php

include("../../db/database.php");

$conn = connection();

if (!isset($_POST['tabla'])) {
  echo "Falta la tabla";
  $conn->close();
  return;
}

$tabla = $_POST['tabla'];

$query = "SELECT * FROM `$tabla`";

try {
  $result = $conn->query($query);
  echo json_encode($result->fetch_all(MYSQLI_ASSOC));
} catch (\Throwable $th) {
  echo "Error al obtener la información de sedes";
}

$conn->close();
