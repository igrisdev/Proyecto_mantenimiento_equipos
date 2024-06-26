<?php

require('./lib/array_navegacion.php');

?>

<header class="flex lg:flex-row flex-col items-center justify-between max-w-screen-2xl mx-auto lg:h-20 px-2 2xl:p-0">
  <a href="/Proyecto_mantenimiento_equipos" class="h-20 max-w-[266px]">
    <svg>
      <text x="50%" y="50%" dy=".35em" text-anchor="middle">
        Mantenimiento de Equipos
      </text>
    </svg>
  </a>

  <nav>
    <ul class="flex gap-4 flex-wrap">
      <a href="/Proyecto_mantenimiento_equipos" class="text-lg font-semibold text-black hover:text-gray-500 hover:underline" >Todas las tablas</a>
      <?php foreach ($navItems as $item) : ?>
        <li>
          <a href="<?= $item['href'] ?>.php?tabla=<?= $item['id'] ?>" class="text-lg font-semibold text-black hover:text-gray-500 hover:underline" ><?= $item['label'] ?></a>
        </li>
      <?php endforeach; ?>
    </ul>
  </nav>
</header>