//validacion de formulario
//Crear
$(document).ready(function () 
{
    $.validator.setDefaults(
    {
        submitHandler: function () 
        {
            var nombre = document.getElementById('inputNombre').value;

            var itemUnidad = document.getElementById('selectUnidad');
            var unidadId = itemUnidad.value;
            var unidad = itemUnidad.options[unidadId].text

            var itemCategoria = document.getElementById('selectCategoria');
            var categoriaId = itemCategoria.value;
            var categoria = itemCategoria.options[categoriaId].text

            var precio = document.getElementById('inputPrecio').value;
            var igv = document.getElementById('inputIGV').value;
            var margen = document.getElementById('inputMargen').value;
            
            crearProductos(nombre, unidadId, unidad, categoriaId, categoria, precio, igv, margen);
            
            $('#modalCrearProducto').modal('hide');
            
            document.getElementById('inputNombre').value = "";
            document.getElementById('selectUnidad').value = "";
            document.getElementById('selectCategoria').value = "";
            document.getElementById('inputPrecio').value = "";
            document.getElementById('inputIGV').value = "";
            document.getElementById('inputMargen').value = "";
        }
    });
    $('#formCrearProducto').validate(
    {
        rules: 
        {
            nombre: 
            {
                required: true,
            },
            unidad: 
            {
                required: true,
            },
            categoria: 
            {
                required: true,
            },
            precio: 
            {
                required: true,
                number: true,
            },
            margen: 
            {
                required: true,
                number: true,
            }
        },
        messages: 
        {
            nombre: 
            {
                required: "Ingrese un nombre de producto",
            },
            unidad: 
            {
                required: "Seleccione alguna unidad",
            },
            categoria: 
            {
                required: "Seleccione alguna categoría",
            },
            precio: 
            {
                required: "Ingrese un precio de producto",
                number: "Ingrese un precio válido"
            },
            margen: 
            {
                required: "Ingrese un margen de producto",
                number: "Ingrese un margen válido"
            }
        },
        errorElement: 'span',
        errorPlacement: function (error, element) 
        {
            error.addClass('invalid-feedback');
            element.closest('.form-group').append(error);
        },
        highlight: function (element, errorClass, validClass) 
        {
            $(element).addClass('is-invalid');
        },
        unhighlight: function (element, errorClass, validClass) 
        {
            $(element).removeClass('is-invalid');
        }
    });
});

//Editar
$(document).ready(function () 
{
    $.validator.setDefaults(
    {
        submitHandler: function () 
        {
            editarProducto();
            $('#modalEditarProducto').modal('hide');
        }
    });
    $('#formEditarProducto').validate(
    {
        rules: 
        {
            nombre: 
            {
                required: true,
            },
            precio: 
            {
                required: true,
                number: true,
            },
            margen: 
            {
                required: true,
                number: true,
            }
        },
        messages: 
        {
            nombre: 
            {
                required: "Ingrese un nombre de producto",
            },
            precio: 
            {
                required: "Ingrese un precio de producto",
                number: "Ingrese un precio válido"
            },
            margen: 
            {
                required: "Ingrese un margen de producto",
                number: "Ingrese un margen válido"
            }
        },
        errorElement: 'span',
        errorPlacement: function (error, element) 
        {
            error.addClass('invalid-feedback');
            element.closest('.form-group').append(error);
        },
        highlight: function (element, errorClass, validClass) 
        {
            $(element).addClass('is-invalid');
        },
        unhighlight: function (element, errorClass, validClass) 
        {
            $(element).removeClass('is-invalid');
        }
    });
});


//Accionar el select
$('#selectCategoria').on('select2:select', function (e) 
{
    var data = e.params.data;
    if(data.title==0)
    {
        document.getElementById('inputIGV').value = "Sin IGV";
    }
    else
    {
        document.getElementById('inputIGV').value = "Con IGV";
    }

});

//Activar tabla
$(function () 
{
    //Initialize Select2 Elements
    $('.select2bs4').select2({
        theme: 'bootstrap4'
    })

    $('.tablaDinamico').DataTable( 
    {
        scrollY:        '50vh',
        scrollCollapse: true,
        "lengthMenu": [[5, 25, 50, -1], [5, 25, 50, "Todo"]],
        language: 
        {
            processing:     "En curso ...",
            search:         "Buscar:",
            lengthMenu:    "Mostrando _MENU_ entradas",
            info:           "Mostrando del _START_ a _END_ elementos, de _TOTAL_ en total.",
            infoEmpty:      "Sin elementos",
            infoFiltered:   "(filtrado de _MAX_ elementos total)",
            infoPostFix:    "",
            loadingRecords: "Cargando ...",
            zeroRecords:    "",
            emptyTable:     "No hay datos disponibles en la tabla.",
            paginate: 
            {
                first:      "Primera",
                previous:   "Previo",
                next:       "Siguiente",
                last:       "Ultimo"
            },
            aria: 
            {
                sortAscending:  ": active para ordenar la columna en orden ascendente",
                sortDescending: ": active para ordenar la columna en orden descendente"
            }
        }
        
    } );
})




function crearProductos(nombre, unidadId, unidad, categoriaId, categoria, precio, igv, margen)
{
    var table = $('#tabla'+categoriaId).DataTable();

    $.ajax(
    {
        async: true,
        crossDomain: true,

        type:'put',
        url: urlBase+"/api/productos/create",
        data: {
            'nombre': nombre,
            'precio': precio,
            'margen': margen,
            'categorias_id': categoriaId,
            'unidad_id': unidadId,
            'token': token
        },
        success:function(data)
        {
            if(data!=null)
            {
                idProducto = data;
                table.row.add( 
                [
                    nombre,
                    unidad,
                    categoria,
                    igv,
                    precio,
                    margen,
                    `<button class="btn btn-warning btnEdit" data-toggle="modal" data-target="#modalEditarProducto"
                        onclick="abrirEditarProducto(${categoriaId}, ${idProducto})">Editar</button>`,
                    `<button class="btn btn-danger btnDelete" data-toggle="modal" data-target="#modalEliminarProducto" 
                    onclick="seleccionarRowEliminar(${categoriaId}, ${idProducto})">Eliminar</button>`
                ]).draw( false );
                
                toastr.success('Producto creado exitosamente!')
            }
            else
            {
                toastr.error('Error de creación!')
            }
        },
        error: function(data)
        {
            console.log(data);
            alert("error");
        }
    });
 
    
}

//toastr.info('Lorem ipsum dolor sit amet, consetetur sadipscing elitr.')
//toastr.warning('Lorem ipsum dolor sit amet, consetetur sadipscing elitr.')

var rowEditar = "";
function abrirEditarProducto(categoriaId, idProducto)
{
    document.getElementById('inputIdEditar').value = idProducto;

    var table = $('#tabla'+categoriaId).DataTable();
    $('#tabla'+categoriaId+' tbody').on( 'click', 'button.btnEdit', function () 
    {
        rowEditar = table.row( $(this).parents('tr') );
        rowData = rowEditar.data();
        document.getElementById('inputNombreEditar').value = rowData[0];
        document.getElementById('inputPrecioEditar').value = rowData[4];
        document.getElementById('inputMargenEditar').value = rowData[5];
    } );
}
function editarProducto()
{
    var idProducto = document.getElementById('inputIdEditar').value;
    nombre = document.getElementById('inputNombreEditar').value;
    precio = document.getElementById('inputPrecioEditar').value;
    margen = document.getElementById('inputMargenEditar').value;
 
    $.ajax(
    {
        async: true,
        crossDomain: true,

        type:'put',
        //url:"https://facturacion.gdsoluciones.com/public/api/productos/edit",
        url: urlBase+"/api/productos/edit",
        data: {
            "id": idProducto,
            'nombre': nombre,
            'precio': precio,
            'margen': margen,
            'token': token
        },
        success:function(data)
        {
            if(data!=null)
            {
                rowData = rowEditar.data();
                rowEditar
                .data( 
                    [
                        nombre,
                        rowData[1],
                        rowData[2],
                        rowData[3],
                        precio,
                        margen,
                        rowData[6],
                        rowData[7]
                    ])
                .draw();

                toastr.success('Producto editado exitosamente!')
            }
            else
            {
                toastr.error('Error de edición!')
            }
        },
        error: function(data)
        {
            console.log(data);
            alert("error");
        }
    });
}



var rowEliminar = "";
function seleccionarRowEliminar(categoriaId, idProducto)
{
    document.getElementById('inputIdEliminar').value = idProducto;
    var table = $('#tabla'+categoriaId).DataTable();
    $('#tabla'+categoriaId+' tbody').on( 'click', 'button.btnDelete', function () 
    {
        rowEliminar = table.row( $(this).parents('tr') );
    } );
}
function eliminarProducto()
{
    var idProducto = document.getElementById('inputIdEliminar').value;
    $.ajax(
    {
        async: true,
        crossDomain: true,

        type:'delete',
        url: urlBase+"/api/productos/destroy",
        data: {
            "id": idProducto,
            'token': token
        },
        success:function(data)
        {
            
            if(data=="1")
            {
                rowEliminar.remove().draw();
                toastr.success('Producto eliminado exitosamente!')
            }
            else
            {
                toastr.error('Error al eliminar!')
            }
        },
        error: function(data)
        {
            console.log(data);
            alert("error");
        }
    });
    
}

