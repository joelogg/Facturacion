$(function () 
{
    //Initialize Select2 Elements
    $('#selectProductos').select2({
        theme: 'bootstrap4'
    })

    
    $('.tablaDinamico').DataTable( 
    {
        paging:   false,
        info:     false,
        searching: false,
        //scrollX: true,
        
        
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
            },
        },
        order: [[ 5, "desc" ]],
        columnDefs: 
        [
            {
                "targets": [ 0,1,2,3,4,5 ],
                "visible": false,
                "searchable": false
            }
        ]

    } );

    /*
    setTimeout(function(){ 
        vistaPreviaFactura();
        $('#modalVistaPreviaFactura').modal('show');
    }, 300);*/
})

//Accionar el select
$('#selectProductos').on('select2:select', function (e) 
{
    var data = e.params.data;
    var idProducto = data.id;
    var categoriaId = data.title;

    agregarProducto(categoriaId, idProducto);

});

var productosSeleccionados = []
function agregarProducto(categoriaId, idProducto)
{
    var table = $('#tabla'+categoriaId).DataTable();

    igv = 0;
    for (let i = 0; i < categorias.length; i++) 
    {
        if(categorias[i].id == categoriaId)
        {
            igv = categorias[i].igv;
            break;
        }
        
    }
    
    var tam = productos.length;
    for (let i = 0; i < tam; i++) 
    {
        producto = productos[i]
        if(producto.id==idProducto)
        {
            productosSeleccionados.push(producto);

            precio = parseFloat(producto.precio);
            margen = parseFloat(producto.margen);

            if(igv=="1" || igv==1)
            { 
                table.row.add( 
                [
                    i, //i 
                    idProducto,
                    igv,
                    0, //cantidad
                    precio, //precio
                    margen, //margen
                    producto.nombre, //nombre
                    `<input value="0" class="inputTablaCantidad" type="number">`, //cantidad input
                    producto.unidad, //unidad
                    `<input class="inputTablaPrecio" type="number" value="${precio}">`, //precio input
                    0, //ext
                    `<input class="inputTablaMargen" type="number" value="${margen}">`, //margen input
                    (precio * margen/100).toFixed(2), //util
                    (precio * margen/100 + precio ).toFixed(2),
                    0,
                    ((precio * margen/100 + precio )/valorIGV).toFixed(2), //pv sin igv
                    0, //ext sin igv
                    `<button class="btn btn-danger btnDelete" data-toggle="modal" data-target="#modalEliminarProducto" 
                                onclick="seleccionarRowEliminar(${categoriaId})">Eliminar</button>`
                ]).draw( false );
            }
            else
            {
                table.row.add( 
                [
                    i, //i 
                    idProducto,
                    igv,
                    0, //cantidad
                    precio, //precio
                    margen, //margen
                    producto.nombre, //nombre
                    `<input value="0" class="inputTablaCantidad" type="number">`, //cantidad input
                    producto.unidad, //unidad
                    `<input class="inputTablaPrecio" type="number" value="${precio}">`, //precio input
                    0, //ext
                    `<input class="inputTablaMargen" type="number" value="${margen}">`, //margen input
                    (precio * margen/100).toFixed(2), //util
                    (precio * margen/100 + precio ).toFixed(2), //pv sin igv
                    0, //ext sin igv
                    `<button class="btn btn-danger btnDelete" data-toggle="modal" data-target="#modalEliminarProducto" 
                                onclick="seleccionarRowEliminar(${categoriaId}, ${idProducto})">Eliminar</button>`
                ]).draw( false );
            }
    
            break;
        }
        
        
    }
}

//function cambiarCantidad(elemt, categoriaId, igv)
$(function () 
{
    for (let i = 0; i < categorias.length; i++) 
    {
    
        categoriaId = categorias[i].id;

        //---- Cambio por cantidad ----
        $('#tabla'+categoriaId+' tbody').on( 'change', 'input.inputTablaCantidad', function () 
        {
            var inputCantidad = $(this);
            var tablaId  = inputCantidad.parents('table').attr("id");
            var table = $('#'+tablaId).DataTable();
            rowEditar = table.row( inputCantidad.parents('tr') );
            rowData = rowEditar.data();
            
            cantidad = parseFloat(inputCantidad[0].value);
            precio = parseFloat(rowData[4]);
            margen = parseFloat(rowData[5]);
            util = precio*margen/100;
            ext = cantidad*precio;

            if(rowData[2]=="1" || rowData[2]==1)
            {
                var pvCigv = util+ precio;
                var pvExtCigv = pvCigv * cantidad;
                var pvSigv = pvCigv/valorIGV;
                var pvExtSigv = pvSigv * cantidad;

                rowEditar
                .data( 
                    [
                        //i
                        rowData[0], 
                        //idProd
                        rowData[1], 
                        //igv
                        rowData[2],
                        //cantidad
                        cantidad, 
                        //precio
                        precio, 
                        //margen
                        margen, 
                        //nombre
                        rowData[6], 
                        //cantidad input
                        `<input value="${cantidad}" class="inputTablaCantidad" type="number">`, 
                        //unidad
                        rowData[8], 
                        //precio input
                        rowData[9], 
                        //ext
                        ext.toFixed(2), 
                        //margen input
                        rowData[11], 
                        //util
                        util.toFixed(2),
                        //pv con igv
                        pvCigv.toFixed(2),
                        //ext con igv
                        pvExtCigv.toFixed(2),
                        //pv sin igv
                        pvSigv.toFixed(2), 
                        //ext sin igv
                        pvExtSigv.toFixed(2),
                        //boton eliminar 
                        rowData[17] 
                    ])
                .draw();
            }
            else
            {
                var pvSigv = precio + util;
                var pvExtSigv = pvSigv * cantidad;
                
                rowEditar
                .data( 
                    [
                        //i
                        rowData[0], 
                        //idProd
                        rowData[1],
                        //igv
                        rowData[2],
                        //cantidad
                        cantidad, 
                        //precio
                        precio, 
                        //margen
                        margen, 
                        //nombre
                        rowData[6], 
                        //cantidad input
                        `<input value="${cantidad}" class="inputTablaCantidad" type="number">`, 
                        //unidad
                        rowData[8], 
                        //precio input
                        rowData[9], 
                        //ext
                        ext.toFixed(2), 
                        //margen input
                        rowData[11], 
                        //util
                        util.toFixed(2),
                        //pv sin igv
                        pvSigv.toFixed(2), 
                        //ext sin igv
                        pvExtSigv.toFixed(2), 
                        //boton eliminar
                        rowData[15]  
                    ])
                .draw();
            }
            
        } );




        //---- Cambio por precio ----
        $('#tabla'+categoriaId+' tbody').on( 'change', 'input.inputTablaPrecio', function () 
        {
            var inputPrecio = $(this);
            var tablaId  = inputPrecio.parents('table').attr("id");
            var table = $('#'+tablaId).DataTable();
            rowEditar = table.row( inputPrecio.parents('tr') );
            rowData = rowEditar.data();
            
            cantidad = parseFloat(rowData[3]);
            precio = parseFloat(inputPrecio[0].value);
            margen = parseFloat(rowData[5]);
            ext = (cantidad*precio);
            util = precio*margen/100;

            if(rowData[2]=="1" || rowData[2]==1)
            {
                var pvCigv = util+ precio;
                var pvExtCigv = pvCigv * cantidad;
                var pvSigv = pvCigv/valorIGV;
                var pvExtSigv = pvSigv * cantidad;

                rowEditar
                .data( 
                    [
                        //i
                        rowData[0], 
                        //idProd
                        rowData[1],
                        //igv
                        rowData[2],
                        //cantidad
                        cantidad, 
                        //precio
                        precio, 
                        //margen
                        margen, 
                        //nombre
                        rowData[6], 
                        //cantidad input
                        rowData[7], 
                        //unidad
                        rowData[8], 
                        //precio input
                        `<input value="${precio}" class="inputTablaPrecio" type="number">`, 
                        //ext
                        ext.toFixed(2), 
                        //margen input
                        rowData[11], 
                        //util
                        util.toFixed(2),
                        //pv con igv
                        pvCigv.toFixed(2),
                        //ext con igv
                        pvExtCigv.toFixed(2),
                        //pv sin igv
                        pvSigv.toFixed(2), 
                        //ext sin igv
                        pvExtSigv.toFixed(2),
                        //boton eliminar 
                        rowData[17] 
                    ])
                .draw();
            }
            else
            {
                var pvSigv = precio + util;
                var pvExtSigv = pvSigv * cantidad;
                
                rowEditar
                .data( 
                    [
                        //i
                        rowData[0], 
                        //idProd
                        rowData[1],
                        //igv
                        rowData[2],
                        //cantidad
                        cantidad, 
                        //precio
                        precio, 
                        //margen
                        margen, 
                        //nombre
                        rowData[6], 
                        //cantidad input
                        rowData[7], 
                        //unidad
                        rowData[8], 
                        //precio input
                        `<input value="${precio}" class="inputTablaPrecio" type="number">`, 
                        //ext
                        ext.toFixed(2), 
                        //margen input
                        rowData[11], 
                        //util
                        util.toFixed(2),
                        //pv sin igv
                        pvSigv.toFixed(2), 
                        //ext sin igv
                        pvExtSigv.toFixed(2), 
                        //boton eliminar
                        rowData[15]  
                    ])
                .draw();
            }
            
        } );




        //---- Cambio por margen ----
        $('#tabla'+categoriaId+' tbody').on( 'change', 'input.inputTablaMargen', function () 
        {
            var inputMargen = $(this);
            var tablaId  = inputMargen.parents('table').attr("id");
            var table = $('#'+tablaId).DataTable();
            rowEditar = table.row( inputMargen.parents('tr') );
            rowData = rowEditar.data();
            
            cantidad = parseFloat(rowData[3]);
            precio = parseFloat(rowData[4]);
            margen = parseFloat(inputMargen[0].value);
            ext = (cantidad*precio);
            util = precio*margen/100;

            if(rowData[2]=="1" || rowData[2]==1)
            {
                var pvCigv = util+ precio;
                var pvExtCigv = pvCigv * cantidad;
                var pvSigv = pvCigv/valorIGV;
                var pvExtSigv = pvSigv * cantidad;

                rowEditar
                .data( 
                    [
                        //i
                        rowData[0], 
                        //idProd
                        rowData[1],
                        //igv
                        rowData[2],
                        //cantidad
                        cantidad, 
                        //precio
                        precio, 
                        //margen
                        margen, 
                        //nombre
                        rowData[6], 
                        //cantidad input
                        rowData[7], 
                        //unidad
                        rowData[8], 
                        //precio input
                        rowData[9], 
                        //ext
                        ext.toFixed(2), 
                        //margen input
                        `<input value="${margen}" class="inputTablaMargen" type="number">`, 
                        //util
                        util.toFixed(2),
                        //pv con igv
                        pvCigv.toFixed(2),
                        //ext con igv
                        pvExtCigv.toFixed(2),
                        //pv sin igv
                        pvSigv.toFixed(2), 
                        //ext sin igv
                        pvExtSigv.toFixed(2),
                        //boton eliminar 
                        rowData[17] 
                    ])
                .draw();
            }
            else
            {
                var pvSigv = precio + util;
                var pvExtSigv = pvSigv * cantidad;
                
                rowEditar
                .data( 
                    [
                        //i
                        rowData[0], 
                        //idProd
                        rowData[1],
                        //igv
                        rowData[2],
                        //cantidad
                        cantidad, 
                        //precio
                        precio, 
                        //margen
                        margen, 
                        //nombre
                        rowData[6], 
                        //cantidad input
                        rowData[7], 
                        //unidad
                        rowData[8], 
                        //precio input
                        rowData[9], 
                        //ext
                        ext.toFixed(2), 
                        //margen input
                        `<input value="${margen}" class="inputTablaMargen" type="number">`, 
                        //util
                        util.toFixed(2),
                        //pv sin igv
                        pvSigv.toFixed(2), 
                        //ext sin igv
                        pvExtSigv.toFixed(2), 
                        //boton eliminar
                        rowData[15]  
                    ])
                .draw();
            }
            
        } );

    }
    
    
});


var rowEliminar = "";
function seleccionarRowEliminar(categoriaId)
{
    var table = $('#tabla'+categoriaId).DataTable();
    $('#tabla'+categoriaId+' tbody').on( 'click', 'button.btnDelete', function () 
    {
        rowEliminar = table.row( $(this).parents('tr') );
    } );
}
function eliminarProducto()
{
    rowEliminar.remove().draw();    
}


var datosFacturaActualizarBD = [];
var montoFactura = 0;
function vistaPreviaFactura()
{
    datosFacturaActualizarBD = [];

    var nomFactura = document.getElementById("nomFactura").value;
    if(nomFactura==null || nomFactura=="")
    {
        document.getElementById("nomFactura").style.border = "1px solid red";
        toastr.error('Ingrese un nombre para la factura.')
        return;
    }

    document.getElementById("tablaExportar").innerHTML = "";
    $('#modalVistaPreviaFactura').modal('show');

    var datosTablas = [];
    var txtTabla = `<tr>
                    <th></th>
                    <th>Requerimientos ${nomFactura}</th>
                    <th></th>
                    <th></th> <th></th> <th></th> <th></th> <th></th>
                    <th></th> <th></th> <th></th> <th></th> <th></th>
                    </tr>`;

    var sumaExt = 0;
    var sumaPVTotal = 0
    var sumaSigvTotal = 0
    
    for (let i = 0; i < categorias.length; i++) 
    {
        var categoriaId = categorias[i].id;
        var table = $('#tabla'+categoriaId).DataTable();
        
        var tam = table.rows().data().toArray().length;
        var dataTabla = table.rows().data().toArray();

        if(tam>0)
        {
            datosTablas.push(dataTabla);
            

            var igv = categorias[i].igv;
            
            txtTabla += `<tr><th></th><th></th>
                        <th></th> <th></th> <th></th> <th></th> <th></th>
                        <th></th> <th></th> <th></th> <th></th> <th></th>
                        </tr>`;

            txtTabla += `<tr><th></th>
                        <th>${categorias[i].nombre.toUpperCase()}</th>
                        <th></th> <th></th> <th></th> <th></th> <th></th>
                        <th></th> <th></th> <th></th> <th></th> <th></th>
                        </tr>`;
            
            
            txtTabla += `<tr>`;
            txtTabla += `<th>ITEM</th>`;
            txtTabla += `<th>DESCRIPCIÓN</th>`;
            txtTabla += `<th></th></td>`;
            txtTabla += `<th>UNIDAD MEDIDA</th>`;
            txtTabla += `<th>PRECIO COMPRA</th>`;
            txtTabla += `<th>EXT</th>`;
            txtTabla += `<th>MARGEN</th>`;
            txtTabla += `<th>UTIL</th>`;
            
            if(igv=="1" || igv ==1)
            {
                txtTabla += `<th>P V C/ IGV</th>`;
                txtTabla += `<th>P V EXT C/ IGV</th>`;
                txtTabla += `<th>P V S/ IGV</th>`;
                txtTabla += `<th>P V EXT S/ IGV</th>`;
            }
            else
            {
                txtTabla += `<th>P V S/ IGV</th>`;
                txtTabla += `<th>P V EXT S/ IGV</th>`;
                txtTabla += `<th></th> <th></th>`;
            }
            txtTabla += `</tr>`;

            for (let j = 0; j < tam; j++) 
            {
                var fila = dataTabla[j];
                var pos = fila[0];
                var idPro = fila[1];
                var descripcion = fila[6];
                var unidad = fila[8];
                var cantidad = parseFloat(fila[3]);
                var precio = parseFloat(fila[4]);
                var margen = parseFloat(fila[5]);
                var ext = (cantidad*precio);
                var util = precio*margen/100;

                datosFacturaActualizarBD.push({"productos_id":idPro, "cantidad":cantidad, "precio":precio, "margen":margen});

                sumaExt += ext

                txtTabla += `<tr>`;
                txtTabla += `<td class="bg-danger">${j+1}</td>`;
                txtTabla += `<td>${descripcion}</td>`;
                txtTabla += `<td bgcolor="#ccff66">${cantidad}</td>`;
                txtTabla += `<td>${unidad}</td>`;
                txtTabla += `<td>${precio}</td>`;
                txtTabla += `<td>${ext.toFixed(2)}</td>`;
                txtTabla += `<td>${margen}%</td>`;
                txtTabla += `<td>S/.${util.toFixed(2)}</td>`;
                
                if(igv=="1" || igv ==1)
                {
                    var pvCigv = util+ precio;
                    var pvExtCigv = pvCigv * cantidad;
                    var pvSigv = pvCigv/valorIGV;
                    var pvExtSigv = pvSigv * cantidad;

                    sumaPVTotal += pvExtCigv;
                    sumaSigvTotal += pvExtSigv;

                    txtTabla += `<td bgcolor="#ffff00">S/.${pvCigv.toFixed(2)}</td>`;
                    txtTabla += `<td>S/.${pvExtCigv.toFixed(2)}</td>`;
                    txtTabla += `<td bgcolor="#99ffcc">S/.${pvSigv.toFixed(2)}</td>`;
                    txtTabla += `<td>S/.${pvExtSigv.toFixed(2)}</td>`;
                }
                else
                {
                    var pvSigv = precio + util;
                    var pvExtSigv = pvSigv * cantidad;

                    sumaPVTotal += pvExtSigv;

                    txtTabla += `<td bgcolor="#99ffcc">S/.${pvSigv.toFixed(2)}</td>`;
                    txtTabla += `<td>S/.${pvExtSigv.toFixed(2)}</td>`;
                    txtTabla += `<td></td> <td></td>`;
                }
                
                txtTabla += `</tr>`;
            }
        }
    }
    
    montoFactura = sumaPVTotal;
    var soloIGV = valorIGV*100 - 100;

    txtTabla += `<tr>`;
    txtTabla += `<td colspan="12"></td>`;
    txtTabla += `</tr>`;

    txtTabla += `<tr>`;
    txtTabla += `<td colspan="11"></td>`;
    txtTabla += `<td>${soloIGV.toFixed(0)}%</td>`;
    txtTabla += `</tr>`;

    txtTabla += `<tr>`;
    txtTabla += `<td colspan="5"></td>`;
    txtTabla += `<td>S/.${sumaExt.toFixed(2)}</td>`;
    txtTabla += `<td colspan="3"></td>`;
    txtTabla += `<td>S/.${sumaPVTotal.toFixed(2)}</td>`;
    txtTabla += `<td></td>`;
    txtTabla += `<td>S/.${sumaSigvTotal.toFixed(2)}</td>`;
    txtTabla += `</tr>`;
    

    txtTabla += `<tr>`;
    txtTabla += `<td colspan="11"></td>`;
    txtTabla += `<td>S/.${(sumaSigvTotal*soloIGV/100).toFixed(2)}</td>`;
    txtTabla += `</tr>`;

    txtTabla += `<tr>`;
    txtTabla += `<td colspan="7"></td>`;
    txtTabla += `<td>MARGEN</td>`;
    txtTabla += `<td></td>`;
    txtTabla += `<td>S/.${(sumaPVTotal-sumaExt).toFixed(2)}</td>`;
    txtTabla += `<td></td>`;
    txtTabla += `<td>S/.${((sumaSigvTotal*soloIGV/100)+sumaSigvTotal).toFixed(2)}</td>`;
    txtTabla += `</tr>`;

    
    document.getElementById("tablaExportar").innerHTML = txtTabla;  
    
    activarExportExcel();
}

function activarExportExcel()
{
    TableExport(document.getElementById("tablaExportar"), {
        headers: true,                      // (Boolean), display table headers (th or td elements) in the <thead>, (default: true)
        footers: true,                      // (Boolean), display table footers (th or td elements) in the <tfoot>, (default: false)
        formats: ["xlsx"],                  // (String[]), filetype(s) for the export, (default: ['xlsx', 'csv', 'txt'])
        filename: "document",               // (id, String), filename for the downloaded file, (default: 'id')
        bootstrap: false,                   // (Boolean), style buttons using bootstrap, (default: true)
        exportButtons: true,                // (Boolean), automatically generate the built-in export buttons for each of the specified formats (default: true)
        position: "bottom",                 // (top, bottom), position of the caption element relative to table, (default: 'bottom')
        ignoreRows: null,                   // (Number, Number[]), row indices to exclude from the exported file(s) (default: null)
        ignoreCols: null,                   // (Number, Number[]), column indices to exclude from the exported file(s) (default: null)
        trimWhitespace: false,              // (Boolean), remove all leading/trailing newlines, spaces, and tabs from cell text in the exported file(s) (default: false)
        RTL: false,                         // (Boolean), set direction of the worksheet to right-to-left (default: false)
        sheetname: "hoja",                   // (id, String), sheet name for the exported spreadsheet, (default: 'id')
        
            
    });
}

function exportar_excel_y_guardar2() 
{
    var nomFactura = document.getElementById("nomFactura").value;
    var table = document.getElementById("tablaExportar");
    var html = table.outerHTML;
    var url = 'data:application/vnd.ms-excel,' + escape(html); // Set your html table into url 
    

    var link = document.createElement("a");
    link.download = `Requerimientos ${nomFactura}.xls`;
    link.href = url;
    link.click();    

}


function exportar_excel_y_guardar(estado) 
{
    var nomFactura = document.getElementById("nomFactura").value;
    if(estado)
    {
        var myTable = $("#tablaExportar").tableExport();
        var exportData = myTable.getExportData()['tablaExportar']['xlsx'];
        myTable.export2file(exportData.data, exportData.mimeType, nomFactura, exportData.fileExtension);
    }
    
    
    guardarFacturaBD(datosFacturaActualizarBD, nomFactura, montoFactura, estado)
}


function guardarFacturaBD(datosFacturaActualizarBD, nomFactura, montoFactura, estado)
{
    datosFacturaActualizarBD = JSON.stringify(datosFacturaActualizarBD);
    
    $.ajax(
    {
        async: true,
        crossDomain: true,

        type:'put',
        url: urlBase+"/api/facturas/crear",
        data: {
            'nombre': nomFactura,
            'monto': montoFactura,
            'estado': estado,
            'productos': datosFacturaActualizarBD,
            'token': token
        },
        success:function(data)
        {
            $('#modalVistaPreviaFactura').modal('hide');
            
            if(data!=null)
            {
                for (let i = 0; i < categorias.length; i++) 
                {
                    var categoriaId = categorias[i].id;
                    var table = $('#tabla'+categoriaId).DataTable();
                    table.clear().draw();
                }
                document.getElementById("nomFactura").value = "";
                document.getElementById("selectProductos").value = 0;
               
                toastr.success('Factua creada exitosamente!')
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


function exportar_excel_y_editar(estado) 
{
    var nomFactura = document.getElementById("nomFactura").value;
    if(estado)
    {
        var myTable = $("#tablaExportar").tableExport();
        var exportData = myTable.getExportData()['tablaExportar']['xlsx'];
        myTable.export2file(exportData.data, exportData.mimeType, nomFactura, exportData.fileExtension);
    }
    
    editarFacturaBD(datosFacturaActualizarBD, nomFactura, montoFactura, estado)
}


function editarFacturaBD(datosFacturaActualizarBD, nomFactura, montoFactura, estado)
{
    datosFacturaActualizarBD = JSON.stringify(datosFacturaActualizarBD);

    
    $.ajax(
    {
        async: true,
        crossDomain: true,

        type:'put',
        url: urlBase+"/api/facturas/editar",
        data: {
            'id' : facturaId,
            'nombre': nomFactura,
            'monto': montoFactura,
            'estado': estado,
            'productos': datosFacturaActualizarBD,
            'token': token
        },
        success:function(data)
        {
            $('#modalVistaPreviaFactura').modal('hide');
            if(data!=null)
            {
                for (let i = 0; i < categorias.length; i++) 
                {
                    var categoriaId = categorias[i].id;
                    var table = $('#tabla'+categoriaId).DataTable();
                    table.clear().draw();
                }
                document.getElementById("nomFactura").value = "";
                document.getElementById("selectProductos").value = 0;
               
                toastr.success('Factua finalizada exitosamente! Espere')

                setTimeout(function(){ window.location.replace(urlBase+"/factura");; }, 2000);
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