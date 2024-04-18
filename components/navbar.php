<?php

include('ui/buttonDialog.php');

include('./lib/objetoNabar.php');

?>

<header class="flex lg:flex-row flex-col items-center justify-between max-w-6xl mx-auto lg:h-20 px-2 md:p-0">
  <a href="/Proyecto_mantenimiento_equipos" class="h-20">
    <svg>
      <text x="50%" y="50%" dy=".35em" text-anchor="middle">
        Mantenimiento de Equipos
      </text>
    </svg>
  </a>

  <nav>
    <ul class="flex gap-2 flex-wrap">
      <?php foreach ($navItems as $item) : ?>
        <li>
          <?php ButtonDialog::render($item['label'], $item['id']) ?>
        </li>
      <?php endforeach; ?>
    </ul>
  </nav>
</header>

<script>
  const navItems = <?= json_encode($navItems) ?>;

  navItems.map(({
    id
  }) => {
    $(
      function() {
        openDialog(id);
        closeDialog(id);
        formSubmit(id);
      }
    )
  })

  const openDialog = (id) => {
    $(`#button__open-${id}`).on('click', () => {
      document.getElementById(`dialog__${id}`).showModal();
    });
  }

  const closeDialog = (id) => {
    $(`#button__close-${id}`).on('click', () => {
      document.getElementById(`dialog__${id}`).close();
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

      isUpdate = button.attr('data-actualizar')
      isId = button.attr('id')

      const formData = {}


      if (isUpdate && isId) {

        inputs.each(function() {
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

      createDataAjax(tabla, formData, inputs)
    });
  }
</script>