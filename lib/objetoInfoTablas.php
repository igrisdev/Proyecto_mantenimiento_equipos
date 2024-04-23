<?php

$tablas = [
  ['nombre' => 'Sedes', 'columnas' => ['Id', 'Nombre'], 'id' => 'sedes'],
  ['nombre' => 'Salas', 'columnas' => ['Id', 'Nombre', 'Sede'], 'id' => 'salas'],
  ['nombre' => 'Marcas', 'columnas' => ['Id', 'Nombre'], 'id' => 'marcas'],
  ['nombre' => 'Equipos', 'columnas' => ['Id', 'Código', 'Tipo', 'Marca', 'Sala', 'Sede', 'Fecha Ingreso', 'Ultimo Mantenimiento', 'Siguiente Mantenimiento', 'Estado'], 'id' => 'equipos'],
  ['nombre' => 'Monitores', 'columnas' => ['Id' => 'Cédula', 'Nombre'], 'id' => 'monitores'],
  ['nombre' => 'Mantenimiento', 'columnas' => ['Id', 'Tipo Mantenimiento', 'Problema', 'Descripción', 'Fecha Inicio', 'Equipo', 'Monitor', 'Fecha Fin'], 'id' => 'mantenimientos'],
];
