// codigo del crud
navItems.map(({ id: tabla }) => {
  $(function () {
    openDialog(tabla)
    closeDialog(tabla)
    formSubmit(tabla)
  })
})

const getOneDataAjax = (tabla, nameTable, selects) => {
  $.ajax({
    url: `/Proyecto_mantenimiento_equipos/api/obtener/obtener__una_tabla.php`,
    data: {
      tabla: nameTable,
    },
    method: 'POST',
    success: (data) => {
      const res = JSON.parse(data)

      setSelect(tabla, res, selects)
    },
    error: (error) => {
      alert(error)
    },
  })
}

const setSelect = (tabla, res, selects) => {
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

const openDialog = (tabla) => {
  $(`#button__open-${tabla}`).on('click', () => {
    document.getElementById(`dialog__${tabla}`).showModal()
  })

  const selects = $(`#form__${tabla} select`)

  selects.each(function () {
    if ($(this).attr('data-nombre-tabla')) {
      const nameTable = $(this).attr('data-nombre-tabla')
      getOneDataAjax(tabla, nameTable, $(this))
    }
  })
}

const closeDialog = (tabla) => {
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

const createDataAjax = (id, formData, inputs, selects, textarea) => {
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
      allTables()
    },
    error: (error) => {
      alert(error)
    },
  })
}

const formSubmit = (tabla) => {
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

      updateDataAjax(tabla, formData, inputs, selects)
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

    createDataAjax(tabla, formData, inputs, selects, textarea)
  })
}

// codigo de la pagina de todas las tablas

const addElement = (text) => {
  return `<th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
              ${text}
            </th>`
}

const searchAjax = (tabla, buscar) => {
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
          fila += addElement(item[key])
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

      addEventListenerButtonsTable(tabla, res)
    },
    error: (error) => {
      alert(error)
    },
  })
}

const capitalice = (text) => {
  return text.charAt(0).toUpperCase() + text.slice(1)
}

const addEventListenerButtonsTable = (tabla, res) => {
  res.map((item) => {
    $(`#eliminar__${tabla}-${item.id ?? item.cc}`).on('click', () => {
      deleteDataAjax(tabla, item.id ?? item.cc)
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

const getDataAjax = (tabla) => {
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
            fila += addElement(item[key])
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

      addEventListenerButtonsTable(tabla, res)
    },
    error: (error) => {
      alert(error)
    },
  })
}

const updateDataAjax = (tabla, formData, inputs, selects) => {
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
      allTables()
    },
    error: (error) => {
      alert(error)
    },
  })
}

const deleteDataAjax = (id, itemId) => {
  $.ajax({
    url: `/Proyecto_mantenimiento_equipos/api/eliminar/eliminar__fila.php`,
    data: {
      tabla: id,
      id: itemId,
    },
    method: 'POST',
    success: (data) => {
      alert(data)
      allTables()
    },
    error: (error) => {
      alert(error)
    },
  })
}

const allTables = () => {
  tablas.map(({ id }) => {
    $(function () {
      getDataAjax(id)
    })
  })
}

$(function () {
  allTables()

  $('#table-search').keyup((event) => {
    const buscar = event.target.value

    tablas.map(({ id }) => {
      searchAjax(id, buscar)
    })
  })
})

// codigo de detalles de los equipos
const obtenerDetallesEquipo = (tabla, id) => {
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
            fila += addElement(item[key])
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

      addEventListenerButtonsTable(tabla, res)
    },
    error: (error) => {
      alert(error)
    },
  })
}

$(function () {
  const tabla = 'mantenimientos'
  obtenerDetallesEquipo(tabla, idDetalles)
})
