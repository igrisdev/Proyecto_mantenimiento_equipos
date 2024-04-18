<?php

include("../../db/database.php");

$conn = connection();

if (!isset($_POST['tabla'])) {
  echo "No esta definida la tabla";
  return;
}

if (!isset($_POST['id'])) {
  echo "No hay texto en el buscador";
  return;
}

$tabla = $_POST['tabla'];
$id = $_POST['id'];

if ($tabla !== 'monitores') {
  $query = "SELECT * FROM `$tabla` WHERE `id` LIKE '%$id%'";
}

if ($tabla === 'monitores') {
  $query = "SELECT * FROM `$tabla` WHERE `cc` LIKE '%$id%'";
}

try {
  $result = $conn->query($query);
  echo json_encode($result->fetch_all(MYSQLI_ASSOC));
} catch (mysqli_sql_exception $exception) {
  echo "Error interno" . $exception;
}

$conn->close();
