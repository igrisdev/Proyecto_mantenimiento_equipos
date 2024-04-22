<?php

include('buttonDialog.php');

include('./lib/objetoCruds.php');

?>

<section class="flex mt-4 lg:mt-0 gap-4 items-center justify-center lg:justify-between max-w-6xl mx-auto px-2 md:p-0">
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

  const getOneDataAjax = (tabla, nameTable) => {
    $.ajax({
      url: `/Proyecto_mantenimiento_equipos/api/obtener/obtener__una_tabla.php`,
      data: {
        tabla: nameTable
      },
      method: 'POST',
      success: (data) => {
        const res = JSON.parse(data);

        setSelect(tabla, res)
      },
      error: (error) => {
        alert(error);
      }
    })
  }

  const setSelect = (tabla, res) => {
    const select = $(`#form__${tabla} select`)

    select.each(function() {
      $(this).empty();
      $(this).append(`<option value="" selected>Seleccione</option>`);
      res.map(item => {
        $(this).append(`<option value="${item.id ?? item.cc}">${item.nombre}</option>`);
      })
    })
  }

  const openDialog = (tabla) => {
    $(`#button__open-${tabla}`).on('click', () => {
      document.getElementById(`dialog__${tabla}`).showModal();
    });

    const select = $(`#form__${tabla} select`)
    select.each(function() {
      const nameTable = select.attr('data-nombre-tabla')
      getOneDataAjax(tabla, nameTable)
    })

  }

  const closeDialog = (tabla) => {
    $(`#button__close-${tabla}`).on('click', () => {
      document.getElementById(`dialog__${tabla}`).close();
    })
  }

  const createDataAjax = (id, formData, inputs) => {
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
        // función declarada en main.php
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
      const inputs = $(`#form__${tabla} input`);
      const button = $(`#form__${tabla} button`);
      const select = $(`#form__${tabla} select`);

      isUpdate = button.attr('data-actualizar')
      isId = button.attr('id')

      const formData = {}


      if (isUpdate && isId) {

        inputs.each(function() {
          formData[$(this).attr('name')] = $(this).val();
        })

        select.each(function() {
          formData[$(this).attr('name')] = $(this).val();
        })

        formData['id'] = isId

        updateDataAjax(tabla, formData, inputs)
        return
      }

      document.getElementById(`form__${tabla}`)

      inputs.each(function() {
        formData[$(this).attr('name')] = $(this).val();
      });

      select.each(function() {
        formData[$(this).attr('name')] = $(this).val();
      })

      createDataAjax(tabla, formData, inputs)
    });
  }
</script>