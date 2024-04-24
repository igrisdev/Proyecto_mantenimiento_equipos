<?php

require('buttonDialog.php');

require('./lib/array_botones_crear.php');

?>

<section class="flex mt-4 lg:mt-0 gap-4 items-center justify-center lg:justify-between max-w-screen-2xl	mx-auto px-2 2xl:p-0">
  <h2 class="text-xl font-medium flex gap-3">
    Crear <span class="hidden lg:block">-></span>
  </h2>

  <ul class="flex gap-2 flex-wrap">
    <?php foreach ($navCruds as $item) : ?>
      <li>
        <?php ButtonDialog::render($item['label'], $item['id']) ?>
      </li>
    <?php endforeach; ?>
  </ul>
</section>

<script>
  const navItems = <?= json_encode($navItems) ?>;

  navItems.map(({
    id: tabla
  }) => {
    $(
      function() {
        openDialog(tabla);
        closeDialog(tabla);
        formSubmit(tabla);
      }
    )
  })

  const getOneDataAjax = (tabla, nameTable, selects) => {
    $.ajax({
      url: `/Proyecto_mantenimiento_equipos/api/obtener/obtener__una_tabla.php`,
      data: {
        tabla: nameTable
      },
      method: 'POST',
      success: (data) => {
        const res = JSON.parse(data);

        setSelect(tabla, res, selects)
      },
      error: (error) => {
        alert(error);
      }
    })
  }

  const setSelect = (tabla, res, selects) => {
    selects.each(function() {
      $(this).empty();
      $(this).append(`<option value="" selected require>Seleccione</option>`);
      for (let item of res) {
        if (!item.estado) {
          $(this).append(`<option value="${item.id ?? item.cc}">${item.nombre}</option>`);
        }

        if (item.estado == '0') {
          $(this).append(`<option value="${item.id}">${item.codigo}</option>`);
        }

      }
    })
  }

  const openDialog = (tabla) => {
    $(`#button__open-${tabla}`).on('click', () => {
      document.getElementById(`dialog__${tabla}`).showModal();
    });

    const selects = $(`#form__${tabla} select`)

    selects.each(function() {
      if ($(this).attr('data-nombre-tabla')) {
        const nameTable = $(this).attr('data-nombre-tabla')
        getOneDataAjax(tabla, nameTable, $(this))
      }
    })

  }

  const closeDialog = (tabla) => {
    $(`#button__close-${tabla}`).on('click', () => {
      document.getElementById(`dialog__${tabla}`).close();

      const button = $(`#form__${tabla} button`)
      const inputs = $(`#form__${tabla} input`)
      const selects = $(`#form__${tabla} select`)

      button.removeAttr('id')
      button.removeAttr('data-actualizar')
      button.html(`Crear ${capitalice(tabla)}`)

      inputs.each(function() {
        $(this).val('');
      })

      selects.each(function() {
        $(this).val('');
      })
    })
  }

  const createDataAjax = (id, formData, inputs, selects, textarea) => {
    console.log(formData);
    $.ajax({
      url: `/Proyecto_mantenimiento_equipos/api/crear/crear__${id}.php`,
      data: formData,
      method: 'POST',
      success: (data) => {
        alert(data);

        document.getElementById(`dialog__${id}`).close();

        inputs.each(function() {
          $(this).val('');
        });

        selects.each(function() {
          $(this).val('');
        });

        textarea.each(function() {
          $(this).val('');
        })

        // función declarada en todas_las_tablas.php
        allTables()
      },
      error: (error) => {
        alert(error);
      }
    })
  }

  const formSubmit = (tabla) => {
    $(`#form__${tabla}`).submit((e) => {
      e.preventDefault();
      const button = $(`#form__${tabla} button`);
      const inputs = $(`#form__${tabla} input`);
      const selects = $(`#form__${tabla} select`);
      const textarea = $(`#form__${tabla} textarea`);

      isUpdate = button.attr('data-actualizar')
      isId = button.attr('id')

      const formData = {}

      if (isUpdate && isId) {

        inputs.each(function() {
          formData[$(this).attr('name')] = $(this).val();
        })

        selects.each(function() {
          formData[$(this).attr('name')] = $(this).val();
        })

        formData['id'] = isId

        updateDataAjax(tabla, formData, inputs, selects)
        return
      }

      inputs.each(function() {
        formData[$(this).attr('name')] = $(this).val();
      });

      selects.each(function() {
        formData[$(this).attr('name')] = $(this).val();
      })

      textarea.each(function() {
        formData[$(this).attr('name')] = $(this).val();
      })

      createDataAjax(tabla, formData, inputs, selects, textarea)
    });
  }
</script>