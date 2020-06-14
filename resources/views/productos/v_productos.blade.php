@extends('plantilla')

@section('includeHead')
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/datatables-bs4/css/dataTables.bootstrap4.css')}}">
@endsection

@section('tituloPestania', $title )
@section('tituloSeccion', $title )




@section('content')
<h3 class="pt-2">Productos</h3>
<button type="button" class="btn btn-success" data-toggle="modal" data-target="#modalCrearProducto">Crear producto</button>
<br>
<br>



<!-- Tablas -->
@foreach ($productos as $categoriaProductos)
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">{{ $categoriaProductos['categoria'] }}</h3>
        </div>
        <div class="card-body">
            <table id="{{ 'tabla'.$categoriaProductos['id']  }}" class="tablaDinamico table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Descripción</th>
                        <th>Unidad Medida</th>
                        <th>Categoría</th>
                        <th>IGV</th>
                        <th>Precio</th>
                        <th>Margen</th>
                        <th>Editar</th>
                        <th>Eliminar</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i=1;?>
                    @foreach ($categoriaProductos['productos'] as $producto)
                        <tr>
                            <td>{{ $producto['nombre'] }}</td>
                            <td>{{ $producto['unidad']  }}</td>
                            <td>{{ $categoriaProductos['categoria']  }}</td>
                            <td>
                                @if ($producto['igv']==0)
                                    Sin IGV
                                @else
                                    Con IGV
                                @endif
                            </td>
                            <td>{{ $producto['precio']  }}</td>
                            <td>{{ $producto['margen']  }}</td>
                            <td><button class="btn btn-warning btnEdit" data-toggle="modal" data-target="#modalEditarProducto"
                                onclick="abrirEditarProducto({{ $categoriaProductos['id'] }}, {{ $producto['id'] }})">Editar</button>
                            </td>
                            <td><button class="btn btn-danger btnDelete" data-toggle="modal" data-target="#modalEliminarProducto" 
                                onclick="seleccionarRowEliminar({{ $categoriaProductos['id'] }}, {{ $producto['id'] }})">Eliminar</button>
                            </td>

                            

                            <?php $i++; ?>
                        </tr>
                    @endforeach
                            
                </tfoot>
            </table>
        </div>
    </div>
@endforeach


<!-- Modal Formulario de agregar-->
<div class="modal fade" id="modalCrearProducto">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form role="form" id="formCrearProducto">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Agregar producto</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="inputNombre">Nombre</label>
                                <input type="text" name="nombre" class="form-control" id="inputNombre" placeholder="Nombre del producto">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="selectUnidad">Unidad</label>
                                <select name="unidad" id="selectUnidad" class="form-control select2bs4" style="width: 100%;">
                                    <option></option>
                                    @foreach ($unidades as $unidad)
                                        <option value="{{ $unidad['id'] }}">{{ $unidad['nombre'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
        
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="selectCategoria">Categoría</label>
                                <select name="categoria" id="selectCategoria" class="form-control select2bs4" style="width: 100%;">
                                    <option></option>
                                    @foreach ($categorias as $categoria)
                                        <option value="{{ $categoria['id'] }}" title="{{ $categoria['igv'] }}">{{ $categoria['nombre'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="inputIGV">IGV</label>
                                <input type="text" name="IGV" class="form-control" id="inputIGV" placeholder="" disabled>
                            </div>
                        </div>
                    </div>
        
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="inputPrecio">Precio</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-append">
                                        <span class="input-group-text">S/.</span>
                                    </div>
                                    <input type="number" name="precio" class="form-control" id="inputPrecio" placeholder="Ingrese precio">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="inputMargen">Margen</label>
                                <div class="input-group mb-3">
                                    <input value="22" type="number" name="margen" class="form-control" id="inputMargen" placeholder="Ingrese margen">
                                    <div class="input-group-append">
                                        <span class="input-group-text">%</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-success">Agregar</button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- Modal Formulario de editar-->
<div class="modal fade" id="modalEditarProducto">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form role="form" id="formEditarProducto">
                <input id="inputIdEditar" type="text" hidden>
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Editar producto</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="inputNombreEditar">Nombre</label>
                                <input type="text" name="nombre" class="form-control" id="inputNombreEditar" placeholder="Nombre del producto">
                            </div>
                        </div>
                    </div>
        
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="inputPrecioEditar">Precio</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-append">
                                        <span class="input-group-text">S/.</span>
                                    </div>
                                    <input type="number" name="precio" class="form-control" id="inputPrecioEditar" placeholder="Ingrese precio">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="inputMargenEditar">Margen</label>
                                <div class="input-group mb-3">
                                    <input type="number" name="margen" class="form-control" id="inputMargenEditar" placeholder="Ingrese margen">
                                    <div class="input-group-append">
                                        <span class="input-group-text">%</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-success">Editar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Formulario de eliminar-->
<div class="modal fade" id="modalEliminarProducto">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
                <input id="inputIdEliminar" type="text" hidden>
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
    <!-- jquery-validation -->
    <script src="{{ asset('assets/plugins/jquery-validation/jquery.validate.min.js')}}"></script>
    <script src="{{ asset('assets/plugins/jquery-validation/additional-methods.min.js')}}"></script>
    <!-- Select2 -->
    <script src="{{ asset('assets/plugins/select2/js/select2.full.min.js')}}"></script>
    <script src="{{ asset('js/productos/productos.js')}}"></script>
    <!-- DataTables -->
    <script src="{{ asset('assets/plugins/datatables/jquery.dataTables.js')}}"></script>
    <script src="{{ asset('assets/plugins/datatables-bs4/js/dataTables.bootstrap4.js')}}"></script>
@endsection