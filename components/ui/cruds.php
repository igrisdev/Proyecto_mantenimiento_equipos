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
  // Array de botones de crear
  const navItems = <?= json_encode($navItems) ?>;
</script>