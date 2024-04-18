<?php

include('./lib/objetoInfoTablas.php');

?>

<main class="flex flex-col min-h-screen gap-6 max-w-6xl mx-auto px-2 md:p-0">
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
          <tbody id="containerRows__<?= $tabla['id'] ?>">
          </tbody>
        </table>
      </div>
    </section>
  <?php endforeach; ?>
</main>

<script>
  const tablas = <?= json_encode($tablas) ?>;

  const addElement = (text) => {
    return `<th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
              ${text}
            </th>`;
  }

  const searchAjax = (id, buscar) => {
    let element
    $.ajax({
      url: `/Proyecto_mantenimiento_equipos/api/obtener/buscar.php`,
      data: {
        tabla: id,
        buscar
      },
      method: 'POST',
      success: (data) => {

        const res = JSON.parse(data);

        const filas = res.map(item => {
          let fila = '';

          for (const key in item) {
            fila += addElement(item[key]);
          }

          fila += `<td class="px-6 py-4 flex flex-wrap gap-x-6 gap-y-2">
                    <button type="submit" id="actualizar__${id}-${item.id ?? item.cc}" class="font-medium text-blue-600 hover:underline">Actualizar</button>
                    <button type="submit" id="eliminar__${id}-${item.id ?? item.cc}" class="font-medium text-blue-600 hover:underline">Eliminar</button>
                  </td>`;

          return `<tr class="bg-white border-b hover:bg-gray-50">${fila}</tr>`;
        })


        const containerRowsElement = $(`#containerRows__${id}`);
        containerRowsElement.html(filas);
        const parentElement = containerRowsElement.parent().parent().parent();

        if (filas.length == 0) {
          parentElement.hide()
        } else {
          parentElement.show()
        }
      },
      error: (error) => {
        alert(error);
      }
    })
  }

  const getOneDataAjax = (tabla, id) => {
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
        const form = $(`#form__${tabla} input`)

        res.map(item => {
          for (const key in item) {
            console.log(form);
            // input.val(item[key])
          }
        })

      },
      error: (error) => {
        alert(error);
      }
    })
  }

  const getDataAjax = (tabla) => {
    let element
    $.ajax({
      url: `/Proyecto_mantenimiento_equipos/api/obtener/obtener__tablas.php`,
      data: {
        tabla
      },
      method: 'POST',
      success: (data) => {
        const res = JSON.parse(data);

        const filas = res.map(item => {
          let fila = '';

          for (const key in item) {
            fila += addElement(item[key]);
          }

          fila += `<td class="px-6 py-4 flex flex-wrap gap-x-6 gap-y-2">
                    <button type="submit" id="actualizar__${tabla}-${item.id ?? item.cc}" class="font-medium text-blue-600 hover:underline">Actualizar</button>
                    <button type="submit" id="eliminar__${tabla}-${item.id ?? item.cc}" class="font-medium text-blue-600 hover:underline">Eliminar</button>
                  </td>`;


          return `<tr class="bg-white border-b hover:bg-gray-50">${fila}</tr>`;
        }).join('');


        $(`#containerRows__${tabla}`).html(filas);

        res.map(item => {
          $(`#eliminar__${tabla}-${item.id ?? item.cc}`).on('click', () => {
            deleteDataAjax(id, item.id ?? item.cc);
          })
          $(`#actualizar__${tabla}-${item.id ?? item.cc}`).on('click', () => {
            document.getElementById(`dialog__${tabla}`).showModal();

            const inputs = $(`#form__${tabla} input`)
            const button = $(`#form__${tabla} button`)
            button.attr('id', `${item.id ?? item.cc}`)
            button.attr('isUpdate', true)

            inputs.each(function() {
              if ($(this).attr('name') in item) {
                $(this).val(item[$(this).attr('name')]);
              }
            })
          });
        })
      },
      error: (error) => {
        alert(error);
      }
    })
  }

  const updateDataAjax = (id, formData, inputs) => {
    $.ajax({
      url: `/Proyecto_mantenimiento_equipos/api/actualizar/actualizar__sedes.php`,
      data: formData,
      method: 'POST',
      success: (data) => {
        alert(data);
        document.getElementById(`dialog__${id}`).close();
        inputs.each(function() {
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

  const allTables = () => {
    tablas.map(({
      id
    }) => {
      $(function() {
        getDataAjax(id)
      })
    })
  }

  $(function() {
    allTables()

    $('#table-search').keyup(event => {
      const buscar = event.target.value

      tablas.map(({
        id
      }) => {
        searchAjax(id, buscar)
      })
    })
  })
</script>