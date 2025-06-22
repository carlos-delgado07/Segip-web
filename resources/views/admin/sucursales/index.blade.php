@extends('layouts.estilo')

@section('content')
    <div class="container">
        <h2>Sucursales</h2>
        <a href="{{ route('admin.sucursales.create') }}" class="btn btn-primary mb-3">Nueva Sucursal</a>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <!-- Estilos de DataTables -->
        <link rel="stylesheet" href="https://cdn.datatables.net/2.0.3/css/dataTables.bootstrap4.min.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/buttons/3.0.2/css/buttons.bootstrap4.min.css">

        <div class="table-responsive">
            <table class="table table-striped" id="sucursalesTable" style="width: 100%;">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Dirección</th>
                        <th>Teléfono</th>
                        <th>Municipio</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($sucursales as $sucursal)
                        <tr>
                            <td>{{ $sucursal->nombre }}</td>
                            <td style="max-width: 200px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;"
                                title="{{ $sucursal->direccion }}">
                                {{ $sucursal->direccion }}
                            </td>
                            <td>{{ $sucursal->telefono ?? '—' }}</td>
                            <td>{{ $sucursal->municipio->nombre ?? '—' }}</td>
                            <td class="text-center">
                                <a href="{{ route('admin.sucursales.ventanillas', $sucursal->id) }}"
                                    class="btn btn-sm btn-info">Ventanillas</a>
                                <a href="{{ route('admin.sucursales.edit', $sucursal) }}"
                                    class="btn btn-sm btn-warning">Editar</a>
                                <form action="{{ route('admin.sucursales.destroy', $sucursal) }}" method="POST"
                                    class="d-inline" onsubmit="return confirm('¿Estás seguro de eliminar esta sucursal?');">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted">No hay sucursales registradas.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>


    <script>
        $(document).ready(function() {
            $('#sucursalesTable').DataTable({
                dom: "<'row'<'col-md-6'B><'col-md-6'f>>" +
                    "<'row'<'col-md-12'tr>>" +
                    "<'row'<'col-md-5'i><'col-md-7'p>>",
                pageLength: 10,
                lengthMenu: [10, 25, 50, 100],
                buttons: [{
                        extend: 'colvis',
                        text: 'Columnas'
                    },
                    {
                        extend: 'excelHtml5',
                        title: 'Sucursales',
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'pdfHtml5',
                        title: 'Sucursales',
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'print',
                        title: 'Sucursales',
                        exportOptions: {
                            columns: ':visible'
                        }
                    }
                ],
                language: {
                    lengthMenu: "Mostrar _MENU_ registros por página",
                    zeroRecords: "No se encontraron resultados",
                    info: "Mostrando página _PAGE_ de _PAGES_",
                    infoEmpty: "No hay registros disponibles",
                    infoFiltered: "(filtrado de _MAX_ registros totales)",
                    search: "Buscar:",
                    paginate: {
                        next: "Siguiente",
                        previous: "Anterior"
                    },
                    buttons: {
                        colvis: "Columnas",
                        excel: "Exportar Excel",
                        pdf: "Exportar PDF",
                        print: "Imprimir"
                    }
                }
            });
        });
    </script>
@endsection
