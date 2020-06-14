@extends('plantilla')

@section('includeHead')
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/datatables-bs4/css/dataTables.bootstrap4.css')}}">
    
    <link rel="stylesheet" href="{{ asset('css/factura.css')}}">


@endsection

@section('tituloPestania', $title )
@section('tituloSeccion', $title )




@section('content')

<h3 class="pt-2">Nombre de factura</h3>
<!-- Nombre Factura -->
<div class="card">
    <div class="card-body">
        <input id="nomFactura" value="{{ $facturaNombre }}" type="text" class="form-control" placeholder="Ingrese nombre de la Factura">
    </div>
</div>

<h3 class="pt-2">Productos</h3>
<!-- Seleccione producto -->
<div class="card">
    <div class="card-body">
        <div class="form-group">
            <label>Seleccione producto</label>
            <div class="row">
                <div class="col-12 col-sm-6">
                    <select id="selectProductos" class="form-control" style="width: 100%;">
                        <option value="0">SELECCIONE</option>
                        @foreach ($productos as $producto)
                            <option title="{{ $producto->categorias_id }}" value="{{ $producto->id }}">{{ "{$producto->nombre} ({$producto->unidad})({$producto->categorias_id})" }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12 col-sm-6">
                    <button class="btn btn-success pt-2" onclick="vistaPreviaFactura()">Vista previa</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Tablas -->
<?php
    $i=0; 
    $numDetaFact = count($facturaDetalles);
?>
@foreach ($categorias as $categoria)
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">{{ $categoria['nombre'] }}</h3>
        </div>
        <div class="card-body">
            <table id="{{ 'tabla'.$categoria['id']  }}" class="tablaDinamico table table-bordered table-striped table-sm">
                <thead>
                    <tr>
                        @if ($categoria['igv'])
                            <th>pos</th>
                            <th>idPro</th>
                            <th>igv</th>
                            <th>Cantidad</th>
                            <th>Precio</th>
                            <th>Margen</th>
                            <th>Descripción</th>
                            <th>Cantidad</th>
                            <th>Unidad Medida</th>
                            <th>Precio Compra</th>
                            <th>Ext</th>
                            <th>Margen</th>
                            <th>Util</th>
                            <th>PV C/ IGV</th>
                            <th>PV Ext C/ IGV</th>
                            <th>PV S/ IGV</th>
                            <th>PV Ext S/ IGV</th>
                            <th>Eliminar</th> 
                        @else
                            <th>pos</th>
                            <th>idPro</th>
                            <th>igv</th>
                            <th>Cantidad</th>
                            <th>Precio</th>
                            <th>Margen</th>
                            <th>Descripción</th>
                            <th>Cantidad</th>
                            <th>Unidad Medida</th>
                            <th>Precio Compra</th>
                            <th>Ext</th>
                            <th>Margen</th>
                            <th>Util</th>
                            <th>PV S/ IGV</th>
                            <th>PV Ext S/ IGV</th>
                            <th>Eliminar</th> 
                        @endif
                        
                    </tr>
                </thead>
                <tbody>
                    {{-- 
                    <tr>
                        @if ($categoria['igv'])
                            <td>{{ $categoria['id'] }}</td>
                            <td>2</td>
                            <td>1</td>
                            <td>4</td>
                            <td>5</td>
                            <td>22</td>
                            <td>Descripción</td>
                            <td>3</td>
                            <td>Unidad Medida</td>
                            <td>4</td>
                            <td>Ext</td>
                            <td>5</td>
                            <td>Util</td>
                            <td>PV C/ IGV</td>
                            <td>PV Ext C/ IGV</td>
                            <td>PV S/ IGV</td>
                            <td>PV Ext S/ IGV</td>
                            <td><button class="btn btn-danger btnDelete" data-toggle="modal" data-target="#modalEliminarProducto" 
                                onclick="seleccionarRowEliminar({{ $categoria['id'] }})">Eliminar</button></td> 
                        @else
                            <td>{{ $categoria['id'] }}</td>
                            <td>2</td>
                            <td>0</td>
                            <td>4</td>
                            <td>5</td>
                            <td>22</td>
                            <td>Descripción</td>
                            <td>3</td>
                            <td>Unidad Medida</td>
                            <td>4</td>
                            <td>Ext</td>
                            <td>5</td>
                            <td>Util</td>
                            <td>PV S/ IGV</td>
                            <td>PV Ext S/ IGV</td>
                            <td><button class="btn btn-danger btnDelete" data-toggle="modal" data-target="#modalEliminarProducto" 
                                onclick="seleccionarRowEliminar({{ $categoria['id'] }})">Eliminar</button></td> 
                        @endif
                    </tr>
                     --}}

                    
                <?php
                    while ($i< $numDetaFact ) 
                    {
                        $productoDetalle = $facturaDetalles[$i];
                        
                        if($categoria['id'] == $productoDetalle['categorias_id'])
                        {
                            $cantidad = $productoDetalle['cantidad'];
                            $precio = $productoDetalle['precio'];
                            $margen = $productoDetalle['margen'];
                            $ext = $cantidad*$precio;
                            $util = $precio*$margen/100;
                ?>
                    
                            <tr>
                                @if ($categoria['igv'])
                                <?php
                                    $pvCigv = $util + $precio;
                                    $pvExtCigv = $pvCigv * $cantidad;
                                    $pvSigv = $pvCigv/$valorIGV;
                                    $pvExtSigv = $pvSigv * $cantidad;
                                ?>
                                    <td>{{ $i }}</td>
                                    <td>{{ $productoDetalle['id'] }}</td>
                                    <td>{{ $productoDetalle['igv'] }}</td>
                                    <td>{{ $cantidad }}</td>
                                    <td>{{ $precio }}</td>
                                    <td>{{ $margen }}</td>
                                    <td>{{ $productoDetalle['nombre'] }}</td>
                                    <td><input value="{{ $cantidad }}" class="inputTablaCantidad" type="number"></td>
                                    <td>{{ $productoDetalle['unidad'] }}</td>
                                    <td><input class="inputTablaPrecio" type="number" value="{{ $precio }}"></td>
                                    <td>{{ round($ext, 2) }}</td>
                                    <td><input class="inputTablaMargen" type="number" value="{{ $margen }}"></td>
                                    <td>{{ round($util, 2) }}</td>
                                    <td>{{ round($pvCigv, 2) }}</td>
                                    <td>{{ round($pvExtCigv, 2) }}</td>
                                    <td>{{ round($pvSigv, 2) }}</td>
                                    <td>{{ round($pvExtSigv, 2) }}</td>
                                    <td><button class="btn btn-danger btnDelete" data-toggle="modal" data-target="#modalEliminarProducto" 
                                        onclick="seleccionarRowEliminar({{ $categoria['id'] }})">Eliminar</button></td> 
                                @else
                                <?php
                                    $pvSigv = $precio + $util;
                                    $pvExtSigv = $pvSigv * $cantidad;
                                ?>
                                    <td>{{ $i }}</td>
                                    <td>{{ $productoDetalle['id'] }}</td>
                                    <td>{{ $productoDetalle['igv'] }}</td>
                                    <td>{{ $cantidad }}</td>
                                    <td>{{ $precio }}</td>
                                    <td>{{ $margen }}</td>
                                    <td>{{ $productoDetalle['nombre'] }}</td>
                                    <td><input value="{{ $cantidad }}" class="inputTablaCantidad" type="number"></td>
                                    <td>{{ $productoDetalle['unidad'] }}</td>
                                    <td><input class="inputTablaPrecio" type="number" value="{{ $precio }}"></td>
                                    <td>{{ round($ext, 2) }}</td>
                                    <td><input class="inputTablaMargen" type="number" value="{{ $margen }}"></td>
                                    <td>{{ round($util, 2) }}</td>
                                    <td>{{ round($pvSigv, 2) }}</td>
                                    <td>{{ round($pvExtSigv, 2) }}</td>
                                    <td><button class="btn btn-danger btnDelete" data-toggle="modal" data-target="#modalEliminarProducto" 
                                        onclick="seleccionarRowEliminar({{ $categoria['id'] }}, {{ $productoDetalle['id'] }})">Eliminar</button></td> 
                                @endif
                            </tr>
                    
                <?php 
                        }
                        else
                        {
                            break;
                        }
                        $i++;
                    }
                ?>
                    
                </tfoot>
            </table>
        </div>
    </div>
@endforeach
    


<!-- Modal Vista previa-->
<div class="modal fade" id="modalVistaPreviaFactura">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Vista previa de factura</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            
            <!-- Modal body -->
            <div class="modal-body">
                <table border='1px' id="tablaExportar" class="table table-bordered table-sm">
                </table>
            </div>
            
            <!-- Modal footer -->
            <div class="modal-footer">
                
                @if ($facturaId>0)
                    <button type="button" id="exporBtn" class="btn btn-info" onclick="exportar_excel_y_editar(0)">Guardar avance</button>
                    <button type="button" id="exporBtn" class="btn btn-success" onclick="exportar_excel_y_editar(1)">Finalizar edición y exportar</button>
                @else
                    <button type="button" id="exporBtn" class="btn btn-info" onclick="exportar_excel_y_guardar(0)">Guardar avance</button>
                    <button type="button" id="exporBtn" class="btn btn-success" onclick="exportar_excel_y_guardar(1)">Finalizar y exportar</button>
                    
                @endif
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>



<!-- Modal Formulario de eliminar-->
<div class="modal fade" id="modalEliminarProducto">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Confirmar</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                
                <!-- Modal body -->
                <div class="modal-body">
                    ¿Desea elimnar el producto?
                </div>
                
                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button onclick="eliminarProducto()" type="button" class="btn btn-danger" data-dismiss="modal">Eliminar</button>
                </div>
        </div>
    </div>
</div>

@endsection





@section('includeFooter')
    <!-- Export Excel 
    <script src="{{ asset('js/excel/jquery-1.12.4.min.js')}}"></script>
    -->
    <script src="{{ asset('js/excel/xls.core.min.js')}}"></script>
    <script src="{{ asset('js/excel/Blob.js')}}"></script>
    <script src="{{ asset('js/excel/FileSaver.js')}}"></script>
    <script src="{{ asset('js/excel/tableexport.js')}}"></script>

    <!-- Select2 -->
    <script src="{{ asset('assets/plugins/select2/js/select2.full.min.js')}}"></script>
    <script src="{{ asset('js/facturas/crearFactura.js')}}"></script>
    <!-- DataTables -->
    <script src="{{ asset('assets/plugins/datatables/jquery.dataTables.js')}}"></script>
    <script src="{{ asset('assets/plugins/datatables-bs4/js/dataTables.bootstrap4.js')}}"></script>
    
    
    




    <script>
        var productos = {!! json_encode($productos->toArray()) !!};
        var categorias = {!! json_encode($categorias->toArray()) !!};
        var valorIGV = {!! $valorIGV !!};
        var facturaId = {!! $facturaId !!};
    </script>
    
@endsection