@extends('layouts.estilo')

@section('content')
    <div class="container">
        <h2>Usuarios</h2>
        <a href="{{ route('admin.users.create') }}" class="btn btn-primary mb-3">Nuevo Usuario</a>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Estilos de DataTables -->
        <link rel="stylesheet" href="https://cdn.datatables.net/2.0.3/css/dataTables.bootstrap4.min.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/buttons/3.0.2/css/buttons.bootstrap4.min.css">

        <div class="table-responsive">
            <table class="table table-striped" id="usersTable" style="width: 100%;">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Email</th>
                        <th>Rol</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->getRoleNames()->join(', ') }}</td>
                            <td class="text-center">
                                <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-sm btn-warning">Editar</a>
                                <form method="POST" action="{{ route('admin.users.destroy', $user) }}" class="d-inline"
                                    onsubmit="return confirm('¿Estás seguro de que deseas eliminar al usuario {{ $user->name }}?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted">No hay usuarios registrados.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Scripts necesarios para DataTables con botones -->


    <script>
        $(document).ready(function() {
            $('#usersTable').DataTable({
                dom: "<'row'<'col-md-6'B><'col-md-6'f>>" +
                    "<'row'<'col-md-12'tr>>" +
                    "<'row'<'col-md-5'i><'col-md-7'p>>",
                pageLength: 10, // ⬅️ cantidad predeterminada
                lengthMenu: [10, 25, 50, 100], // ⬅️ opciones para elegir
                buttons: [{
                        extend: 'colvis',
                        text: 'Columnas'
                    },
                    {
                        extend: 'excelHtml5',
                        title: 'Usuarios',
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'pdfHtml5',
                        title: 'Usuarios',
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'print',
                        title: 'Usuarios',
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
