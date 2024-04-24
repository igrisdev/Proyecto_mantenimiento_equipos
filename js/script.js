// FUNCIONES DEL ARCHIVO /components/ui/cruds

// Añadir las funciones de abrir, cerrar dialog del formulario y enviar la informacion
navItems.map(({ id: tabla }) => {
  $(function () {
    desplegar_dialog(tabla)
    cerrar_dialog(tabla)
    enviar_formulario(tabla)
  })
})

// Obtiene la informacion de una tabla en especifico con ajax
const obtener_informacion_una_tabla = (nombre_tabla, selects) => {
  $.ajax({
    url: `/Proyecto_mantenimiento_equipos/api/obtener/obtener__una_tabla.php`,
    data: {
      tabla: nombre_tabla,
    },
    method: 'POST',
    success: (data) => {
      const res = JSON.parse(data)
      console.log(nombre_tabla, res)

      añadiendo_informacion_formularios_select(res, selects)
    },
    error: (error) => {
      alert(error)
    },
  })
}

// Agrega la informacion a los select correspondientes de cada formulario
const añadiendo_informacion_formularios_select = (res, selects) => {
  selects.each(function () {
    $(this).empty()
    $(this).append(`<option value="" selected require>Seleccione</option>`)
    for (let item of res) {
      // Si el estado esta en funcionamiento es 1
      if (!item.estado) {
        $(this).append(
          `<option value="${item.id ?? item.cc}">${item.nombre}</option>`
        )
      }

      // Si el estado esta en mantenimiento es 0
      if (item.estado == '0') {
        $(this).append(`<option value="${item.id}">${item.codigo}</option>`)
      }
    }
  })
}

// Funcion que abre el dialog correspondiente a la tabla dada
const desplegar_dialog = (tabla) => {
  $(`#button__open-${tabla}`).on('click', () => {
    document.getElementById(`dialog__${tabla}`).showModal()
  })

  // Obtiene los selects de la tabla correspondiente
  const selects = $(`#form__${tabla} select`)

  // Recorre los selects y obtiene el nombre de la tabla de cada select para hacer un llamado
  // a la base de datos y pintar en los selects los valores adecuados
  selects.each(function () {
    if ($(this).attr('data-nombre-tabla')) {
      // Obtiene el nombre de la base de datos de el select que esta guardado en un atributo data-nombre-tabla
      const nombre_tabla = $(this).attr('data-nombre-tabla')

      obtener_informacion_una_tabla(nombre_tabla, $(this))
    }
  })
}

// Cierra los dialogs de la tabla correspondiente
const cerrar_dialog = (tabla) => {
  $(`#button__close-${tabla}`).on('click', () => {
    document.getElementById(`dialog__${tabla}`).close()

    // Obtener los elementos button, inputs, selects de un formulario
    const button = $(`#form__${tabla} button`)
    const inputs = $(`#form__${tabla} input`)
    const selects = $(`#form__${tabla} select`)

    // eliminar los atributos que permiten saber si se esta actualizando una tarea
    button.removeAttr('id')
    button.removeAttr('data-actualizar')
    button.html(`Crear ${capitalice(tabla)}`)

    // Vacia los inputs
    inputs.each(function () {
      $(this).val('')
    })

    // Vacia los selects
    selects.each(function () {
      $(this).val('')
    })
  })
}

// Inserta la informacion en la base de datos de cada formulario
const crear_informacion_base_datos = (id, formData, inputs, selects, textarea) => {
  console.log(formData)
  $.ajax({
    url: `/Proyecto_mantenimiento_equipos/api/crear/crear__${id}.php`,
    data: formData,
    method: 'POST',
    success: (data) => {
      alert(data)

      document.getElementById(`dialog__${id}`).close()

      inputs.each(function () {
        $(this).val('')
      })

      selects.each(function () {
        $(this).val('')
      })

      textarea.each(function () {
        $(this).val('')
      })

      listar_todas_tablas()
    },
    error: (error) => {
      alert(error)
    },
  })
}

// Envia el formulario y se crea o actualiza una informacion en la tabla correspondiente 
// de la base de datos
const enviar_formulario = (tabla) => {
  // Obtiene el formulario de la tabla dada
  $(`#form__${tabla}`).submit((e) => {
    e.preventDefault()

    // Obtener los elementos de los formularios
    const button = $(`#form__${tabla} button`)
    const inputs = $(`#form__${tabla} input`)
    const selects = $(`#form__${tabla} select`)
    const textarea = $(`#form__${tabla} textarea`)

    // Saber si se actualiza una informacion de una tabla
    isUpdate = button.attr('data-actualizar')

    // Obtiene el id de la fila a actualizar en la base de datos
    isId = button.attr('id')

    // Objetos donde se guardan todos los datos de los elementos de los formularios
    const formData = {}

    // Ingresa si se actualizar y existe un id
    if (isUpdate && isId) {
      // Pone los valores a los inputs
      inputs.each(function () {
        formData[$(this).attr('name')] = $(this).val()
      })

      // Pone los valores a los selects
      selects.each(function () {
        formData[$(this).attr('name')] = $(this).val()
      })

      // agrega el id
      formData['id'] = isId

      actualizar_informacion_tabla_base_datos(tabla, formData, inputs, selects)
      return
    }

    // Parte para crear informacion

    // Obtiene los valores de los inputs
    inputs.each(function () {
      formData[$(this).attr('name')] = $(this).val()
    })

    // Obtiene los valores de los selects
    selects.each(function () {
      formData[$(this).attr('name')] = $(this).val()
    })

    // Obtiene los valores de los textareas
    textarea.each(function () {
      formData[$(this).attr('name')] = $(this).val()
    })

    crear_informacion_base_datos(tabla, formData, inputs, selects, textarea)
  })
}

// Actualizar informacion en la base de datos de una fila con su id
const actualizar_informacion_tabla_base_datos = (tabla, formData, inputs, selects) => {
  $.ajax({
    url: `/Proyecto_mantenimiento_equipos/api/actualizar/actualizar__${tabla}.php`,
    data: formData,
    method: 'POST',
    success: (data) => {
      alert(data)
      document.getElementById(`dialog__${tabla}`).close()

      const button = $(`#form__${tabla} button`)

      // Remueve los atributos que indicaban si se actualizaba una fila
      button.removeAttr('id')
      button.removeAttr('data-actualizar')
      button.html(`Crear ${capitalice(tabla)}`)

      // Limpia los campos
      inputs.each(function () {
        $(this).val('')
      })

      selects.each(function () {
        $(this).val('')
      })

      // Refresca la informacion de las tablas, con los nuevos campos
      listar_todas_tablas()
    },
    error: (error) => {
      alert(error)
    },
  })
}

// FUNCIONES DEL ARCHIVO /components/todas_las_tablas

// Pinta un th en la tabla correspondiente con su campo de texto
const añadir_th_tabla = (text) => {
  return `<th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
              ${text}
            </th>`
}

// Busca la informacion en la base de datos y los filtra por tabla
const buscar_informacion_base_datos = (tabla, buscar) => {
  $.ajax({
    url: `/Proyecto_mantenimiento_equipos/api/obtener/buscar.php`,
    data: {
      tabla,
      buscar,
    },
    method: 'POST',
    success: (data) => {
      const res = JSON.parse(data)

      // Itera la respuesta
      const filas = res.map((item) => {

        // Variable que concatena las th de la tabla
        let fila = ''

        // Itera las columnas para agregar los th con su valor
        for (const key in item) {
          fila += añadir_th_tabla(item[key])
        }

        // Agregando los botones de acciones que son eliminar y actualizar para todas las tablas que no se llaman equipos
        if (tabla !== 'equipos') {
          fila += `<td class="px-6 py-4 flex flex-wrap gap-x-6 gap-y-2">
                      <button type="submit" id="actualizar__${tabla}-${item.id ?? item.cc
            }" class="font-medium text-blue-600 hover:underline">Actualizar</button>
                      <button type="submit" id="eliminar__${tabla}-${item.id ?? item.cc
            }" class="font-medium text-red-600 hover:underline">Eliminar</button>
                      </td>`
        }

        // Agregando los botones de acciones que son eliminar, actualizar y ver detalles para la tabla equipos
        if (tabla === 'equipos') {
          fila += `<td class="px-6 py-4 flex flex-wrap gap-x-6 gap-y-2">
                      <button type="submit" id="actualizar__${tabla}-${item.id ?? item.cc
            }" class="font-medium text-blue-600 hover:underline">Actualizar</button>
                      <button type="submit" id="eliminar__${tabla}-${item.id ?? item.cc
            }" class="font-medium text-red-600 hover:underline">Eliminar</button>
                      <a href='detalles_equipos.php?tabla=mantenimientos&id=${item.id
            }' type="submit" id="eliminar__${tabla}-${item.id ?? item.cc
            }" class="font-medium text-green-600 hover:underline">Ver Detalles</a>
                      </td>`
        }

        // Devuelve toda la fila 
        return `<tr class="bg-white border-b hover:bg-gray-50">${fila}</tr>`
      })

      // Obtiene el elemento donde se van insertar las filas
      const elemento_contenedor_filas = $(`#contenedor_filas_${tabla}`)

      // Pinta las filas en el html en su respectivo contenedor
      elemento_contenedor_filas.html(filas)

      // Obtenemos el elemento padre, para saber el nombre de la tabla
      const elemento_padre = elemento_contenedor_filas.parent().parent().parent()

      // Ocultamos la tabla si no tiene informacion
      if (filas.length == 0) {
        elemento_padre.hide()
      } else {
        elemento_padre.show()
      }

      añadir_eventos_tabla_botones(tabla, res)
    },
    error: (error) => {
      alert(error)
    },
  })
}


// Hace la primera letra mayuscula
const capitalice = (text) => {
  return text.charAt(0).toUpperCase() + text.slice(1)
}

// Agrega las funciones para eliminar o actualizar una fila
const añadir_eventos_tabla_botones = (tabla, res) => {
  res.map((item) => {
    // Eliminar la fila dada
    $(`#eliminar__${tabla}-${item.id ?? item.cc}`).on('click', () => {
      eliminar_informacion_tabla(tabla, item.id ?? item.cc)
    })

    // Abre el dialog y plasma la informacion de la fila para actualizarla
    $(`#actualizar__${tabla}-${item.id ?? item.cc}`).on('click', () => {
      document.getElementById(`dialog__${tabla}`).showModal()

      console.log(tabla, res)


      // Obtiene los elementos de los formularios
      const button = $(`#form__${tabla} button`)
      const inputs = $(`#form__${tabla} input`)
      const selects = $(`#form__${tabla} select`)

      // Agrega los actributos para indicar que se va a actualizar esa fila

      button.attr('id', `${item.id ?? item.cc}`)
      button.attr('data-actualizar', true)
      button.html(`Actualizar ${capitalice(tabla)}`)

      // Plasma la informacion en el formulario de los inputs
      inputs.each(function () {
        if ($(this).attr('name') in item) {
          $(this).val(item[$(this).attr('name')])
        }
      })

      // Plasma la informacion en el formulario de los selects
      selects.each(function () {
        if ($(this).attr('name') in item) {
          $(this).val(item[$(this).attr('name')])
        }
      })
    })
  })
}

// Optiene la informacion de todas las tablas en la base de datos
const obtener_informacion_todas_tablas = (tabla) => {
  $.ajax({
    url: `/Proyecto_mantenimiento_equipos/api/obtener/obtener__tablas.php`,
    data: {
      tabla,
    },
    method: 'POST',
    success: (data) => {
      const res = JSON.parse(data)

      const filas = res
        .map((item) => {
          let fila = ''

          for (const key in item) {
            fila += añadir_th_tabla(item[key])
          }

          if (tabla !== 'equipos') {
            fila += `<td class="px-6 py-4 flex flex-wrap gap-x-6 gap-y-2">
                      <button type="submit" id="actualizar__${tabla}-${item.id ?? item.cc
              }" class="font-medium text-blue-600 hover:underline">Actualizar</button>
                      <button type="submit" id="eliminar__${tabla}-${item.id ?? item.cc
              }" class="font-medium text-red-600 hover:underline">Eliminar</button>
                      </td>`
          }

          if (tabla === 'equipos') {
            fila += `<td class="px-6 py-4 flex flex-wrap gap-x-6 gap-y-2">
                      <button type="submit" id="actualizar__${tabla}-${item.id ?? item.cc
              }" class="font-medium text-blue-600 hover:underline">Actualizar</button>
                      <button type="submit" id="eliminar__${tabla}-${item.id ?? item.cc
              }" class="font-medium text-red-600 hover:underline">Eliminar</button>
                      <a href='detalles_equipos.php?tabla=mantenimientos&id=${item.id
              }' type="submit" id="eliminar__${tabla}-${item.id ?? item.cc
              }" class="font-medium text-green-600 hover:underline">Ver Detalles</a>
                      </td>`
          }

          return `<tr class="bg-white border-b hover:bg-gray-50">${fila}</tr>`
        })
        .join('')

      $(`#contenedor_filas_${tabla}`).html(filas)

      añadir_eventos_tabla_botones(tabla, res)
    },
    error: (error) => {
      alert(error)
    },
  })
}

const eliminar_informacion_tabla = (id, itemId) => {
  $.ajax({
    url: `/Proyecto_mantenimiento_equipos/api/eliminar/eliminar__fila.php`,
    data: {
      tabla: id,
      id: itemId,
    },
    method: 'POST',
    success: (data) => {
      alert(data)
      listar_todas_tablas()
    },
    error: (error) => {
      alert(error)
    },
  })
}

const listar_todas_tablas = () => {
  tablas.map(({ id }) => {
    $(function () {
      obtener_informacion_todas_tablas(id)
    })
  })
}

$(function () {
  listar_todas_tablas()

  $('#table-search').keyup((event) => {
    const buscar = event.target.value

    tablas.map(({ id }) => {
      buscar_informacion_base_datos(id, buscar)
    })
  })
})

// codigo de detalles de los equipos
const obtener_detalles_equipo = (tabla, id) => {
  $.ajax({
    url: `/Proyecto_mantenimiento_equipos/api/obtener/obtener__una_tabla.php`,
    data: {
      tabla,
      id,
    },
    method: 'POST',
    success: (data) => {
      const res = JSON.parse(data)

      const filas = res
        .map((item) => {
          let fila = ''

          for (const key in item) {
            fila += añadir_th_tabla(item[key])
          }

          if (tabla !== 'equipos') {
            fila += `<td class="px-6 py-4 flex flex-wrap gap-x-6 gap-y-2">
                      <button type="submit" id="actualizar__${tabla}-${item.id ?? item.cc
              }" class="font-medium text-blue-600 hover:underline">Actualizar</button>
                      <button type="submit" id="eliminar__${tabla}-${item.id ?? item.cc
              }" class="font-medium text-red-600 hover:underline">Eliminar</button>
                      </td>`
          }

          if (tabla === 'equipos') {
            fila += `<td class="px-6 py-4 flex flex-wrap gap-x-6 gap-y-2">
                      <button type="submit" id="actualizar__${tabla}-${item.id ?? item.cc
              }" class="font-medium text-blue-600 hover:underline">Actualizar</button>
                      <button type="submit" id="eliminar__${tabla}-${item.id ?? item.cc
              }" class="font-medium text-red-600 hover:underline">Eliminar</button>
                      <a href='detalles_equipos.php?table=${tabla}&id=${item.id
              }' type="submit" id="eliminar__${tabla}-${item.id ?? item.cc
              }" class="font-medium text-green-600 hover:underline">Ver Detalles</a>
                      </td>`
          }

          return `<tr class="bg-white border-b hover:bg-gray-50">${fila}</tr>`
        })
        .join('')

      $(`#contenedorFilasTablaUnica_${tabla}`).html(filas)

      añadir_eventos_tabla_botones(tabla, res)
    },
    error: (error) => {
      alert(error)
    },
  })
}

$(function () {
  const tabla = 'mantenimientos'
  obtener_detalles_equipo(tabla, idDetalles)
})
