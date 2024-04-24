<?php

function connection()
{
  $conn = new mysqli("localhost", "root", "", "db_pme");

  if ($conn->connect_error) {
    die("Error de conexión" . $conn->connect_error);
  }

  return $conn;
}