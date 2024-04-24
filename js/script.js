// codigo del crud
navItems.map(({ id: tabla }) => {
  $(function () {
    desplegar_dialog(tabla)
    cerrar_dialog(tabla)
    enviar_formulario(tabla)
  })
})

const obtener_informacion_una_tabla = (tabla, nameTable, selects) => {
  $.ajax({
    url: `/Proyecto_mantenimiento_equipos/api/obtener/obtener__una_tabla.php`,
    data: {
      tabla: nameTable,
    },
    method: 'POST',
    success: (data) => {
      const res = JSON.parse(data)

      añadiendo_informacion_formularios_select(tabla, res, selects)
    },
    error: (error) => {
      alert(error)
    },
  })
}

const añadiendo_informacion_formularios_select = (tabla, res, selects) => {
  selects.each(function () {
    $(this).empty()
    $(this).append(`<option value="" selected require>Seleccione</option>`)
    for (let item of res) {
      if (!item.estado) {
        $(this).append(
          `<option value="${item.id ?? item.cc}">${item.nombre}</option>`
        )
      }

      if (item.estado == '0') {
        $(this).append(`<option value="${item.id}">${item.codigo}</option>`)
      }
    }
  })
}

const desplegar_dialog = (tabla) => {
  $(`#button__open-${tabla}`).on('click', () => {
    document.getElementById(`dialog__${tabla}`).showModal()
  })

  const selects = $(`#form__${tabla} select`)

  selects.each(function () {
    if ($(this).attr('data-nombre-tabla')) {
      const nameTable = $(this).attr('data-nombre-tabla')
      obtener_informacion_una_tabla(tabla, nameTable, $(this))
    }
  })
}

const cerrar_dialog = (tabla) => {
  $(`#button__close-${tabla}`).on('click', () => {
    document.getElementById(`dialog__${tabla}`).close()

    const button = $(`#form__${tabla} button`)
    const inputs = $(`#form__${tabla} input`)
    const selects = $(`#form__${tabla} select`)

    button.removeAttr('id')
    button.removeAttr('data-actualizar')
    button.html(`Crear ${capitalice(tabla)}`)

    inputs.each(function () {
      $(this).val('')
    })

    selects.each(function () {
      $(this).val('')
    })
  })
}

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

      // función declarada en todas_las_tablas.php
      listar_todas_tablas()
    },
    error: (error) => {
      alert(error)
    },
  })
}

const enviar_formulario = (tabla) => {
  $(`#form__${tabla}`).submit((e) => {
    e.preventDefault()
    const button = $(`#form__${tabla} button`)
    const inputs = $(`#form__${tabla} input`)
    const selects = $(`#form__${tabla} select`)
    const textarea = $(`#form__${tabla} textarea`)

    isUpdate = button.attr('data-actualizar')
    isId = button.attr('id')

    const formData = {}

    if (isUpdate && isId) {
      inputs.each(function () {
        formData[$(this).attr('name')] = $(this).val()
      })

      selects.each(function () {
        formData[$(this).attr('name')] = $(this).val()
      })

      formData['id'] = isId

      actualizar_informacion_tabla_base_datos(tabla, formData, inputs, selects)
      return
    }

    inputs.each(function () {
      formData[$(this).attr('name')] = $(this).val()
    })

    selects.each(function () {
      formData[$(this).attr('name')] = $(this).val()
    })

    textarea.each(function () {
      formData[$(this).attr('name')] = $(this).val()
    })

    crear_informacion_base_datos(tabla, formData, inputs, selects, textarea)
  })
}

// codigo de la pagina de todas las tablas

const añadir_th_tabla = (text) => {
  return `<th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
              ${text}
            </th>`
}

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

      const filas = res.map((item) => {
        let fila = ''

        for (const key in item) {
          fila += añadir_th_tabla(item[key])
        }

        if (tabla !== 'equipos') {
          fila += `<td class="px-6 py-4 flex flex-wrap gap-x-6 gap-y-2">
                      <button type="submit" id="actualizar__${tabla}-${
            item.id ?? item.cc
          }" class="font-medium text-blue-600 hover:underline">Actualizar</button>
                      <button type="submit" id="eliminar__${tabla}-${
            item.id ?? item.cc
          }" class="font-medium text-red-600 hover:underline">Eliminar</button>
                      </td>`
        }

        if (tabla === 'equipos') {
          fila += `<td class="px-6 py-4 flex flex-wrap gap-x-6 gap-y-2">
                      <button type="submit" id="actualizar__${tabla}-${
            item.id ?? item.cc
          }" class="font-medium text-blue-600 hover:underline">Actualizar</button>
                      <button type="submit" id="eliminar__${tabla}-${
            item.id ?? item.cc
          }" class="font-medium text-red-600 hover:underline">Eliminar</button>
                      <a href='detalles_equipos.php?tabla=mantenimientos&id=${
                        item.id
                      }' type="submit" id="eliminar__${tabla}-${
            item.id ?? item.cc
          }" class="font-medium text-green-600 hover:underline">Ver Detalles</a>
                      </td>`
        }

        return `<tr class="bg-white border-b hover:bg-gray-50">${fila}</tr>`
      })

      const containerRowsElement = $(`#containerRows__${tabla}`)
      containerRowsElement.html(filas)
      const parentElement = containerRowsElement.parent().parent().parent()

      if (filas.length == 0) {
        parentElement.hide()
      } else {
        parentElement.show()
      }

      añadir_eventos_tabla_botones(tabla, res)
    },
    error: (error) => {
      alert(error)
    },
  })
}

const capitalice = (text) => {
  return text.charAt(0).toUpperCase() + text.slice(1)
}

const añadir_eventos_tabla_botones = (tabla, res) => {
  res.map((item) => {
    $(`#eliminar__${tabla}-${item.id ?? item.cc}`).on('click', () => {
      eliminar_informacion_tabla(tabla, item.id ?? item.cc)
    })

    $(`#actualizar__${tabla}-${item.id ?? item.cc}`).on('click', () => {
      document.getElementById(`dialog__${tabla}`).showModal()

      const button = $(`#form__${tabla} button`)
      const inputs = $(`#form__${tabla} input`)
      const selects = $(`#form__${tabla} select`)

      button.attr('id', `${item.id ?? item.cc}`)
      button.attr('data-actualizar', true)
      button.html(`Actualizar ${capitalice(tabla)}`)

      inputs.each(function () {
        if ($(this).attr('name') in item) {
          $(this).val(item[$(this).attr('name')])
        }
      })

      selects.each(function () {
        if ($(this).attr('name') in item) {
          $(this).val(item[$(this).attr('name')])
        }
      })
    })
  })
}

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
                      <button type="submit" id="actualizar__${tabla}-${
              item.id ?? item.cc
            }" class="font-medium text-blue-600 hover:underline">Actualizar</button>
                      <button type="submit" id="eliminar__${tabla}-${
              item.id ?? item.cc
            }" class="font-medium text-red-600 hover:underline">Eliminar</button>
                      </td>`
          }

          if (tabla === 'equipos') {
            fila += `<td class="px-6 py-4 flex flex-wrap gap-x-6 gap-y-2">
                      <button type="submit" id="actualizar__${tabla}-${
              item.id ?? item.cc
            }" class="font-medium text-blue-600 hover:underline">Actualizar</button>
                      <button type="submit" id="eliminar__${tabla}-${
              item.id ?? item.cc
            }" class="font-medium text-red-600 hover:underline">Eliminar</button>
                      <a href='detalles_equipos.php?tabla=mantenimientos&id=${
                        item.id
                      }' type="submit" id="eliminar__${tabla}-${
              item.id ?? item.cc
            }" class="font-medium text-green-600 hover:underline">Ver Detalles</a>
                      </td>`
          }

          return `<tr class="bg-white border-b hover:bg-gray-50">${fila}</tr>`
        })
        .join('')

      $(`#containerRows__${tabla}`).html(filas)

      añadir_eventos_tabla_botones(tabla, res)
    },
    error: (error) => {
      alert(error)
    },
  })
}

const actualizar_informacion_tabla_base_datos = (tabla, formData, inputs, selects) => {
  $.ajax({
    url: `/Proyecto_mantenimiento_equipos/api/actualizar/actualizar__${tabla}.php`,
    data: formData,
    method: 'POST',
    success: (data) => {
      alert(data)
      document.getElementById(`dialog__${tabla}`).close()

      const button = $(`#form__${tabla} button`)

      button.removeAttr('id')
      button.removeAttr('data-actualizar')
      button.html(`Crear ${capitalice(tabla)}`)

      inputs.each(function () {
        $(this).val('')
      })

      selects.each(function () {
        $(this).val('')
      })
      // función declarada en todas_las_tablas.php
      listar_todas_tablas()
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
                      <button type="submit" id="actualizar__${tabla}-${
              item.id ?? item.cc
            }" class="font-medium text-blue-600 hover:underline">Actualizar</button>
                      <button type="submit" id="eliminar__${tabla}-${
              item.id ?? item.cc
            }" class="font-medium text-red-600 hover:underline">Eliminar</button>
                      </td>`
          }

          if (tabla === 'equipos') {
            fila += `<td class="px-6 py-4 flex flex-wrap gap-x-6 gap-y-2">
                      <button type="submit" id="actualizar__${tabla}-${
              item.id ?? item.cc
            }" class="font-medium text-blue-600 hover:underline">Actualizar</button>
                      <button type="submit" id="eliminar__${tabla}-${
              item.id ?? item.cc
            }" class="font-medium text-red-600 hover:underline">Eliminar</button>
                      <a href='detalles_equipos.php?table=${tabla}&id=${
              item.id
            }' type="submit" id="eliminar__${tabla}-${
              item.id ?? item.cc
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
