<?php

require('./components/head.php');

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

<main class="flex flex-col min-h-screen gap-6 max-w-screen-2xl mx-auto px-2 2xl:p-0 2xl:pb-10 pb-10">
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
            <tbody id="containerRows__<?= $tabla['id'] ?>">
            </tbody>
          </table>
        </div>
      </section>
    <?php endif; ?>
  <?php endforeach; ?>
</main>

<?php require('./components/foot.php'); ?>

<script>
  const tablas = <?= json_encode($tablas) ?>;

  const addElement = (text) => {
    return `<th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
              ${text}
            </th>`;
  }

  const capitalice = (text) => {
    return text.charAt(0).toUpperCase() + text.slice(1);
  }

  const addEventListenerButtonsTable = (tabla, res) => {
    res.map(item => {
      $(`#eliminar__${tabla}-${item.id ?? item.cc}`).on('click', () => {
        deleteDataAjax(tabla, item.id ?? item.cc);
      })

      $(`#actualizar__${tabla}-${item.id ?? item.cc}`).on('click', () => {
        document.getElementById(`dialog__${tabla}`).showModal();

        const button = $(`#form__${tabla} button`)
        const inputs = $(`#form__${tabla} input`)
        const selects = $(`#form__${tabla} select`)

        button.attr('id', `${item.id ?? item.cc}`)
        button.attr('data-actualizar', true)
        button.html(`Actualizar ${capitalice(tabla)}`)

        inputs.each(function() {
          if ($(this).attr('name') in item) {
            $(this).val(item[$(this).attr('name')]);
          }
        })

        selects.each(function() {
          if ($(this).attr('name') in item) {
            $(this).val(item[$(this).attr('name')]);
          }
        })
      });
    })
  }

  const getDataAjax = (tabla, id) => {
    let element
    $.ajax({
      url: `/Proyecto_mantenimiento_equipos/api/obtener/obtener__una_tabla.php`,
      data: {
        tabla,
        id
      },
      method: 'POST',
      success: (data) => {
        const res = JSON.parse(data);

        const filas = res.map(item => {
          let fila = '';

          for (const key in item) {
            fila += addElement(item[key]);
          }

          if (tabla !== 'equipos') {
            fila += `<td class="px-6 py-4 flex flex-wrap gap-x-6 gap-y-2">
                      <button type="submit" id="actualizar__${tabla}-${item.id ?? item.cc}" class="font-medium text-blue-600 hover:underline">Actualizar</button>
                      <button type="submit" id="eliminar__${tabla}-${item.id ?? item.cc}" class="font-medium text-red-600 hover:underline">Eliminar</button>
                      </td>`;
          }

          if (tabla === 'equipos') {
            fila += `<td class="px-6 py-4 flex flex-wrap gap-x-6 gap-y-2">
                      <button type="submit" id="actualizar__${tabla}-${item.id ?? item.cc}" class="font-medium text-blue-600 hover:underline">Actualizar</button>
                      <button type="submit" id="eliminar__${tabla}-${item.id ?? item.cc}" class="font-medium text-red-600 hover:underline">Eliminar</button>
                      <a href='details_equipos.php?table=${tabla}&id=${item.id}' type="submit" id="eliminar__${tabla}-${item.id ?? item.cc}" class="font-medium text-green-600 hover:underline">Ver Detalles</a>
                      </td>`;
          }

          return `<tr class="bg-white border-b hover:bg-gray-50">${fila}</tr>`;
        }).join('');


        $(`#containerRows__${tabla}`).html(filas);

        addEventListenerButtonsTable(tabla, res)
      },
      error: (error) => {
        alert(error);
      }
    })
  }

  const updateDataAjax = (tabla, formData, inputs, selects) => {
    $.ajax({
      url: `/Proyecto_mantenimiento_equipos/api/actualizar/actualizar__${tabla}.php`,
      data: formData,
      method: 'POST',
      success: (data) => {
        alert(data);
        document.getElementById(`dialog__${tabla}`).close();

        const button = $(`#form__${tabla} button`)

        button.removeAttr('id')
        button.removeAttr('data-actualizar')
        button.html(`Crear ${capitalice(tabla)}`)

        inputs.each(function() {
          $(this).val('');
        });

        selects.each(function() {
          $(this).val('');
        });
        // función declarada en main.php
        allTables()
      },
      error: (error) => {
        alert(error);
      }
    })
  }

  const deleteDataAjax = (id, itemId) => {
    $.ajax({
      url: `/Proyecto_mantenimiento_equipos/api/eliminar/eliminar__fila.php`,
      data: {
        tabla: id,
        id: itemId
      },
      method: 'POST',
      success: (data) => {
        alert(data)
        allTables()
      },
      error: (error) => {
        alert(error);
      }
    })
  }

  $(function() {
    const tabla = 'mantenimientos'
    const id = <?= $id ?>;
    getDataAjax(tabla, id)
  })
</script>