$(function () 
{
    $('#example1').DataTable( 
    {
        scrollY:        '70vh',
        scrollCollapse: true,
        "lengthMenu": [[9, 25, 50, -1], [9, 25, 50, "Todo"]],
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

});

function editarFactura(idF)
{
    document.getElementById('inputIdFactura').value = idF;
}


var nombreFactura = "";
function verFactura(idF)
{
    
    
    
    $.ajax(
    {
        async: true,
        crossDomain: true,

        type:'post',
        url: urlBase+"/api/facturas/detalles",
        data: {
            'id': idF,
            'token': token
        },
        success:function(data)
        {
            if(data)
            {
                var facturaCabecera = data.facturaCabecera;
                var productos = data.productos;
                

                document.getElementById("tablaExportar").innerHTML = "";
                nombreFactura = facturaCabecera.nombre;

                var txtTabla = `<tr>
                                <th></th>
                                <th>Requerimientos ${nombreFactura}</th>
                                <th></th>
                                <th></th> <th></th> <th></th> <th></th> <th></th>
                                <th></th> <th></th> <th></th> <th></th> <th></th>
                                </tr>`;

                var sumaExt = 0;
                var sumaPVTotal = 0
                var sumaSigvTotal = 0
                var nomCategoria = "";
                var posItem = 0;
                
                for (let i = 0; i < productos.length; i++) 
                {
                    posItem++;
                    var producto = productos[i];
                    var igv = producto.igv;
                    
                    
                    if(nomCategoria != producto.nombreCategoria)
                    {
                        posItem = 0;
                        nomCategoria = producto.nombreCategoria;

                        txtTabla += `<tr><th></th><th></th>
                                    <th></th> <th></th> <th></th> <th></th> <th></th>
                                    <th></th> <th></th> <th></th> <th></th> <th></th>
                                    </tr>`;

                        txtTabla += `<tr><th></th>
                                    <th>${nomCategoria.toUpperCase()}</th>
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
                    }
                    
                    
                    var descripcion = producto.nombre;
                    var unidad = producto.unidad;
                    var cantidad = parseFloat(producto.cantidad);
                    var precio = parseFloat(producto.precio);
                    var margen = parseFloat(producto.margen);
                    var ext = (cantidad*precio);
                    var util = precio*margen/100;
                    
                    sumaExt += ext
                    
                    txtTabla += `<tr>`;
                    txtTabla += `<td>${posItem}</td>`;
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
            else
            {
                toastr.error('Error al cargar factura!')
            }
        },
        error: function(data)
        {
            console.log(data);
            alert("error");
        }
    });
    
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

function exportar_excel() 
{
    var myTable = $("#tablaExportar").tableExport();
    var exportData = myTable.getExportData()['tablaExportar']['xlsx'];
    myTable.export2file(exportData.data, exportData.mimeType, nombreFactura, exportData.fileExtension);    
}