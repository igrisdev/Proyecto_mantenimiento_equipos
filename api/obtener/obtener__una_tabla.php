<?php

require("../../db/database.php");

$conn = connection();

if (!isset($_POST['tabla'])) {
  echo "No esta definida la tabla";
  return;
}

$tabla = $_POST['tabla'];

$query = "SELECT * FROM `$tabla`";

try {
  $result = $conn->query($query);
  echo json_encode($result->fetch_all(MYSQLI_ASSOC));
} catch (mysqli_sql_exception $exception) {
  echo "Error interno";
}

$conn->close();
