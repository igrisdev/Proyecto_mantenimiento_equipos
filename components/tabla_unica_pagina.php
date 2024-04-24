<?php

require('./lib/objetoInfoTablas.php');

if (!isset($_GET['tabla'])) {
  echo 'No hay tabla';
  return;
}

if (!isset($_GET['id'])) {
  echo 'No hay id';
  return;
}

$t = $_GET['tabla'];
$id = $_GET['id'];

?>

<main class="flex flex-col min-h-screen gap-6 max-w-screen-2xl mx-auto px-2 2xl:p-0 py-5">
  <?php foreach ($tablas as $tabla) : ?>
    <?php if ($tabla['id'] === 'mantenimientos') : ?>
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
            <tbody id="contenedorFilasTablaUnica_<?= $tabla['id'] ?>">
            </tbody>
          </table>
        </div>
      </section>
    <?php endif; ?>
  <?php endforeach; ?>
</main>

<script>
  // obtener el id del equipo a buscar en los mantenimientos
  const idDetalles = <?= $id ?>;

  // convertir el array de tablas en php a uno que puede usar javascript
  const tablas = <?= json_encode($tablas) ?>;

  // ir a la carpeta js/script.js para ver la funcionalidad
</script>