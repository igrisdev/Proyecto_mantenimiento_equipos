<?php

require("../../db/base_de_datos.php");

$conn = connection();

if (!isset($_POST['tabla'])) {
  echo "Falta la tabla";
  $conn->close();
  return;
}

$tabla = $_POST['tabla'];

if ($tabla === "equipos") {
  $query = "SELECT equipos.id, equipos.codigo, equipos.tipo, equipos.idMarca, salas.id as idSala, salas.idSede, equipos.fecha_ingreso as 'fecha_ingreso', IF(mantenimientos.fecha_inicio IS NOT NULL, mantenimientos.fecha_inicio, '') as 'ultimo mantenimiento', if(mantenimientos.fecha_inicio IS NOT NULL, DATE_ADD(mantenimientos.fecha_inicio, INTERVAL 6 MONTH), DATE_ADD(equipos.fecha_ingreso, INTERVAL 6 MONTH)) as 'siguiente mantenimiento', equipos.estado FROM equipos LEFT JOIN salas ON equipos.idSala = salas.id LEFT JOIN mantenimientos ON equipos.id = mantenimientos.idEquipo";
}

if ($tabla !== "equipos") {
  $query = "SELECT * FROM `$tabla`";
}

try {
  $result = $conn->query($query);
  echo json_encode($result->fetch_all(MYSQLI_ASSOC));
} catch (\Throwable $th) {
  echo "Error al obtener la información de sedes";
}

$conn->close();
