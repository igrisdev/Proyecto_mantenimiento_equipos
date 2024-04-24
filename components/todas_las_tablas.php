<?php

// array con información de las tablas
require('./lib/array_informacion_tablas.php');

?>

<main class="flex flex-col min-h-screen gap-6 max-w-screen-2xl mx-auto px-2 2xl:p-0 2xl:pb-10 pb-10">
  <!-- sección de búsqueda -->
  <section class="mt-4">
    <div class="relative">
      <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
        <svg class="w-4 h-4 text-gray-500 " aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
          <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
        </svg>
      </div>
      <input type="text" id="table-search" class="block w-full p-2 pl-8 pr-2 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500" placeholder="Buscar por id, nombre, problema, descripción, cédula, tipo de mantenimiento">
    </div>
  </section>

  <!-- sección de todas las tablas -->
  <?php foreach ($tablas as $tabla) : ?>
    <section>
      <h3 class="mb-2">Tabla de <?= $tabla['nombre'] ?></h3>
      <div class="relative overflow-x-auto sm:rounded-lg">
        <table class="w-full text-sm text-left text-gray-500">
          <thead class="text-xs text-gray-700 uppercase bg-gray-50">
            <tr>
              <?php foreach ($tabla['columnas'] as $columna) : ?>
                <th scope="col" class="px-6 py-3">
                  <?= $columna ?>
                </th>
              <?php endforeach; ?>

              <th scope="col" class="px-6 py-3">
                Acciones
              </th>
            </tr>
          </thead>
          <tbody id="contenedor_filas_<?= $tabla['id'] ?>">
          </tbody>
        </table>
      </div>
    </section>
  <?php endforeach; ?>
</main>

<script>
  // convertir el array de tablas en php a uno que puede usar javascript
  const tablas = <?= json_encode($tablas) ?>;

  // ir a la carpeta js/script.js para ver la funcionalidad
</script>