<?php

class ButtonDialog
{
  public static function render($label, $id)
  {
    echo "<dialog class='w-[500px] p-2 rounded-lg max-w-md bg-gray-800 rounded-lg shadow-md p-6' id='dialog__{$id}'>
    <button type='button' id='button__close-{$id}' class='block text-sm w-7 h-7 text-center ml-auto p-1 text-white bg-red-500 rounded-lg'>X</button>
    <h2 class='text-2xl font-bold text-gray-200 mb-4'>{$label}</h2>";

    if ($id === "sedes") {
      echo "
      <form class='flex flex-col gap-2' id='form__{$id}'>
        <label class='flex flex-col'>
          <span class='text-white'>Nombre</span>
          <input require placeholder='Bicentenario ...' autofocus name='nombre' class='bg-gray-700 text-gray-200 border-0 rounded-md p-2 mb-4 focus:bg-gray-600 focus:outline-none focus:ring-1 focus:ring-blue-500 transition ease-in-out duration-150' type='text'>
        </label>

        <button class='bg-gradient-to-r from-indigo-500 to-blue-500 text-white font-bold py-2 px-4 rounded-md hover:bg-indigo-600 hover:to-blue-600 transition ease-in-out duration-150' type='submit'>Crear {$label}</button>
      </form>";
    };

    if ($id === "salas") {
      echo "
      <form class='flex flex-col gap-2' id='form__{$id}'>
        <label class='flex flex-col'>
          <span class='text-white'>Nombre</span>
          <input require placeholder='Bicentenario ...' autofocus name='nombre' class='bg-gray-700 text-gray-200 border-0 rounded-md p-2 mb-4 focus:bg-gray-600 focus:outline-none focus:ring-1 focus:ring-blue-500 transition ease-in-out duration-150' type='text'>
        </label>

        <label class='flex flex-col'>
          <span class='text-white'>Sede</span>
          <select name='idSede' data-nombre-tabla='sedes' class='bg-gray-700 text-gray-200 border-0 rounded-md p-2 mb-4 focus:bg-gray-600 focus:outline-none focus:ring-1 focus:ring-blue-500 transition ease-in-out duration-150' id='idSede' require>
            <option value='' selected>Error</option>
          </select>
        </label>

        <button class='bg-gradient-to-r from-indigo-500 to-blue-500 text-white font-bold py-2 px-4 rounded-md hover:bg-indigo-600 hover:to-blue-600 transition ease-in-out duration-150' type='submit'>Crear {$label}</button>
      </form>";
    };

    if ($id === "marcas") {
      echo "
      <form class='flex flex-col gap-2' id='form__{$id}'>
        <label class='flex flex-col'>
          <span class='text-white'>Nombre</span>
          <input require placeholder='Bicentenario ...' autofocus name='nombre' class='bg-gray-700 text-gray-200 border-0 rounded-md p-2 mb-4 focus:bg-gray-600 focus:outline-none focus:ring-1 focus:ring-blue-500 transition ease-in-out duration-150' type='text'>
        </label>

        <button class='bg-gradient-to-r from-indigo-500 to-blue-500 text-white font-bold py-2 px-4 rounded-md hover:bg-indigo-600 hover:to-blue-600 transition ease-in-out duration-150' type='submit'>Crear {$label}</button>
      </form>";
    };

    if ($id === "equipos") {
      echo "
      <form class='flex flex-col gap-2' id='form__{$id}'>
        <label class='flex flex-col'>
          <span class='text-white'>Código de equipo</span>
          <input require placeholder='Bicentenario ...' autofocus name='codigo' class='bg-gray-700 text-gray-200 border-0 rounded-md p-2 mb-4 focus:bg-gray-600 focus:outline-none focus:ring-1 focus:ring-blue-500 transition ease-in-out duration-150' type='text'>
        </label>

        <label class='flex flex-col'>
          <span class='text-white'>Tipo</span>
          <select name='tipo' class='bg-gray-700 text-gray-200 border-0 rounded-md p-2 mb-4 focus:bg-gray-600 focus:outline-none focus:ring-1 focus:ring-blue-500 transition ease-in-out duration-150' id='tipo' require>
            <option value='' selected>Seleccionar</option>
            <option value='portatil'>Portátil</option>
            <option value='pc'>PC</option>
          </select>
        </label>

        <label class='flex flex-col'>
          <span class='text-white'>Marca</span>
          <select name='idMarca' data-nombre-tabla='marcas' class='bg-gray-700 text-gray-200 border-0 rounded-md p-2 mb-4 focus:bg-gray-600 focus:outline-none focus:ring-1 focus:ring-blue-500 transition ease-in-out duration-150' id='idMarca' require>
            <option value='' selected>Error</option>
          </select>
        </label>

        <label class='flex flex-col'>
          <span class='text-white'>Fecha de ingreso</span>
          <input require placeholder='Bicentenario ...' name='fecha_ingreso' class='bg-gray-700 text-gray-200 border-0 rounded-md p-2 mb-4 focus:bg-gray-600 focus:outline-none focus:ring-1 focus:ring-blue-500 transition ease-in-out duration-150' type='date'>
        </label>

        <label class='flex flex-col'>
          <span class='text-white'>Salas</span>
          <select name='idSala' data-nombre-tabla='salas' class='bg-gray-700 text-gray-200 border-0 rounded-md p-2 mb-4 focus:bg-gray-600 focus:outline-none focus:ring-1 focus:ring-blue-500 transition ease-in-out duration-150' id='idSala' require>
            <option value='' selected>Error</option>
          </select>
        </label>

        <label class='flex flex-col'>
          <span class='text-white'>Estado</span>
          <select name='estado' class='bg-gray-700 text-gray-200 border-0 rounded-md p-2 mb-4 focus:bg-gray-600 focus:outline-none focus:ring-1 focus:ring-blue-500 transition ease-in-out duration-150' id='estado' require>
            <option value='' selected>Seleccionar</option>
            <option value='1'>Mantenimiento</option>
            <option value='0'>Funcionando</option>
          </select>
        </label>

        <button class='bg-gradient-to-r from-indigo-500 to-blue-500 text-white font-bold py-2 px-4 rounded-md hover:bg-indigo-600 hover:to-blue-600 transition ease-in-out duration-150' type='submit'>Crear {$label}</button>
      </form>";
    };

    if ($id === "monitores") {
      echo "
      <form class='flex flex-col gap-2' id='form__{$id}'>
        <label class='flex flex-col'>
          <span class='text-white'>Cédula</span>
          <input require placeholder='Bicentenario ...' autofocus name='cc' class='bg-gray-700 text-gray-200 border-0 rounded-md p-2 mb-4 focus:bg-gray-600 focus:outline-none focus:ring-1 focus:ring-blue-500 transition ease-in-out duration-150' type='text'>
        </label>

        <label class='flex flex-col'>
          <span class='text-white'>Nombre</span>
          <input require placeholder='Bicentenario ...' name='nombre' class='bg-gray-700 text-gray-200 border-0 rounded-md p-2 mb-4 focus:bg-gray-600 focus:outline-none focus:ring-1 focus:ring-blue-500 transition ease-in-out duration-150' type='text'>
        </label>

        <button class='bg-gradient-to-r from-indigo-500 to-blue-500 text-white font-bold py-2 px-4 rounded-md hover:bg-indigo-600 hover:to-blue-600 transition ease-in-out duration-150' type='submit'>Crear {$label}</button>
      </form>";
    };

    if ($id === "mantenimientos") {
      echo "
      <form class='flex flex-col gap-2' id='form__{$id}'>
         <label class='flex flex-col'>
          <span class='text-white'>Equipo</span>
          <select autofocus name='idEquipo' data-nombre-tabla='equipos' class='bg-gray-700 text-gray-200 border-0 rounded-md p-2 mb-4 focus:bg-gray-600 focus:outline-none focus:ring-1 focus:ring-blue-500 transition ease-in-out duration-150' id='idEquipo' require>
            <option value='' selected>Error</option>
          </select>
        </label>

        <label class='flex flex-col'>
          <span class='text-white'>Tipo De Mantenimiento</span>
          <select name='tipo_mantenimiento' class='bg-gray-700 text-gray-200 border-0 rounded-md p-2 mb-4 focus:bg-gray-600 focus:outline-none focus:ring-1 focus:ring-blue-500 transition ease-in-out duration-150' id='tipo_mantenimiento' require>
            <option value='' selected>Seleccionar</option>
            <option value='correctivo' >Correctivo</option>
            <option value='preventivo'>Preventivo</option>
          </select>
        </label>

        <label class='flex flex-col'>
          <span class='text-white'>Fecha de inicio mantenimiento</span>
          <input require placeholder='Bicentenario ...' name='fecha_inicio' class='bg-gray-700 text-gray-200 border-0 rounded-md p-2 mb-4 focus:bg-gray-600 focus:outline-none focus:ring-1 focus:ring-blue-500 transition ease-in-out duration-150' type='date'>
        </label>

        <label class='flex flex-col'>
          <span class='text-white'>Problema</span>
          <textarea placeholder='Feedback' class='bg-gray-700 text-gray-200 border-0 rounded-md p-2 mb-4 focus:bg-gray-600 focus:outline-none focus:ring-1 focus:ring-blue-500 transition ease-in-out duration-150' name='problema'></textarea>
        </label>


        <label class='flex flex-col'>
          <span class='text-white'>Monitor</span>
          <select name='quienCC' data-nombre-tabla='monitores' class='bg-gray-700 text-gray-200 border-0 rounded-md p-2 mb-4 focus:bg-gray-600 focus:outline-none focus:ring-1 focus:ring-blue-500 transition ease-in-out duration-150' id='quienCC' require>
            <option value='' selected>Error</option>
          </select>
        </label>

        <button class='bg-gradient-to-r from-indigo-500 to-blue-500 text-white font-bold py-2 px-4 rounded-md hover:bg-indigo-600 hover:to-blue-600 transition ease-in-out duration-150' type='submit'>Crear {$label}</button>
      </form>";
    };

    echo "</dialog>";

    echo "
    <button type='button' id='button__open-{$id}' class='overflow-hidden rounded-lg relative p-2 pr-6 cursor-pointer flex items-center border border-green-500 bg-green-500 group hover:bg-green-500 active:bg-green-500 active:border-green-500'>
    <span class='text-sm text-gray-200 font-semibold transform group-hover:translate-x-40 transition-all duration-300'>{$label}</span>
    <span class='absolute w-5 right-0 bg-green-500 flex items-center justify-center transition-all duration-300 group-hover:w-full'>
    <svg class='svg w-4 text-white' fill='none' height='24' stroke='currentColor' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' viewBox='0 0 24 24' width='24' xmlns='http://www.w3.org/2000/svg'>
        <line x1='12' x2='12' y1='5' y2='19'></line>
        <line x1='5' x2='19' y1='12' y2='12'></line>
      </svg>
    </span>
    </button>
    ";
  }
}
