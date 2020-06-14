@extends('plantilla')

@section('includeHead')
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/datatables-bs4/css/dataTables.bootstrap4.css')}}">
    <link rel="stylesheet" href="{{ asset('css/factura.css')}}">
@endsection

@section('tituloPestania', $title )
@section('tituloSeccion', $title )




@section('content')
<h3 class="pt-2">{{ $title }}</h3>



<div class="card">
    <div class="card-body">
        <table id="example1" class="table table-bordered table-striped">
            <thead>
                <tr>
                <th>Factura</th>
                <th>Fecha</th>
                <th>Monto</th>
                <th>Editar</th>
                <th>Ver</th>
                </tr>
            </thead>
            <tbody>
                    
                @foreach ($facturas as $factura)
                <tr>
                    <td><span hidden>{{ $factura->id }}</span>{{ $factura->nombre }}</td>
                    <td>{{ explode(" ", $factura->updated_at)[0] }}</td>
                    <td>S/.{{ $factura->monto }}</td>
                    <td><button class="btn btn-warning" onclick="editarFactura({{ $factura->id }})" data-toggle="modal" data-target="#modalConfirmarEditar">Editar</button></td>
                    <td><button class="btn btn-info" onclick="verFactura({{ $factura->id }})" data-toggle="modal" data-target="#modalVistaFactura">Ver</button></td>
                </tr>
                @endforeach
                    
            </tbody>
        </table>
    </div>
    <!-- /.card-body -->
</div>
<!-- /.card -->
    


 <!-- Modal Editar-->
<div class="modal fade" id="modalConfirmarEditar">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form action="{{ $urlBase }}/factura" method="post">
                @csrf
                <input type="hidden" name="idFactura" id="inputIdFactura">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Confirmar</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                
                <!-- Modal body -->
                <div class="modal-body">
                    ¿Desea editar esta factura?
                </div>
                
                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-warning">Editar</button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- Modal Vista previa-->
<div class="modal fade" id="modalVistaFactura">
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
                    <button type="button" id="exporBtn" class="btn btn-success" onclick="exportar_excel()">Guardar y exportar</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>


@endsection





@section('includeFooter')
    <!-- Export Excel -->
    <script src="{{ asset('js/excel/xls.core.min.js')}}"></script>
    <script src="{{ asset('js/excel/Blob.js')}}"></script>
    <script src="{{ asset('js/excel/FileSaver.js')}}"></script>
    <script src="{{ asset('js/excel/tableexport.js')}}"></script>

    <!-- DataTables -->
    <script src="{{ asset('assets/plugins/datatables/jquery.dataTables.js')}}"></script>
    <script src="{{ asset('assets/plugins/datatables-bs4/js/dataTables.bootstrap4.js')}}"></script>
    <script src="{{ asset('js/facturas/listaFactura.js')}}"></script>

     <script>
        var valorIGV = {!! $valorIGV !!};
    </script>
@endsection