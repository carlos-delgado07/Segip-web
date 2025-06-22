@extends('layouts.estilo')

@section('content')
    <div class="container">
        <h2>Servicios</h2>
        <a href="{{ route('admin.servicios.create') }}" class="btn btn-primary mb-3">Nuevo Servicio</a>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <!-- Estilos de DataTables -->
        <link rel="stylesheet" href="https://cdn.datatables.net/2.0.3/css/dataTables.bootstrap4.min.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/buttons/3.0.2/css/buttons.bootstrap4.min.css">

        <div class="table-responsive">
            <table class="table table-striped" id="serviciosTable" style="width: 100%;">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Tiempo Estimado (min)</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($servicios as $servicio)
                        <tr>
                            <td>{{ $servicio->nombre }}</td>
                            <td>{{ $servicio->tiempo_estimado }}</td>
                            <td class="text-center">
                                <a href="{{ route('admin.servicios.edit', $servicio) }}"
                                    class="btn btn-warning btn-sm">Editar</a>
                                <form action="{{ route('admin.servicios.destroy', $servicio) }}" method="POST"
                                    style="display:inline;" onsubmit="return confirm('¿Eliminar servicio?');">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-danger btn-sm">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center text-muted">No hay servicios registrados.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>


    <script>
        $(document).ready(function() {
            $('#serviciosTable').DataTable({
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
                        title: 'Servicios',
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'pdfHtml5',
                        title: 'Servicios',
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'print',
                        title: 'Servicios',
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
