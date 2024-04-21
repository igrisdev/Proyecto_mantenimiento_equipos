<?php

$tablas = [
  ['nombre' => 'Sedes', 'columnas' => ['Id', 'Nombre'], 'id' => 'sedes'],
  ['nombre' => 'Salas', 'columnas' => ['Id', 'Nombre', 'Sede'], 'id' => 'salas'],
  ['nombre' => 'Marcas', 'columnas' => ['Id', 'Nombre'], 'id' => 'marcas'],
  ['nombre' => 'Equipos', 'columnas' => ['Id', 'Tipo', 'Marca', 'Sala', 'Código', 'Fecha Ingreso', 'Estado'], 'id' => 'equipos'],
  ['nombre' => 'Monitores', 'columnas' => ['Id' => 'Cédula', 'Nombre'], 'id' => 'monitores'],
  ['nombre' => 'Mantenimiento', 'columnas' => ['Id', 'Tipo Mantenimiento', 'Problema', 'Descripción', 'Fecha Creación', 'Equipo', 'Monitor', 'Fecha Fin'], 'id' => 'mantenimientos'],
];
