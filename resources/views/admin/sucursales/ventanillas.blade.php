@extends('layouts.estilo')

@section('content')
    <div class="container mt-4">
        <h4>Ventanillas de la Sucursal: {{ $sucursal->nombre }}</h4>
        <form method="POST" action="{{ route('admin.sucursales.ventanillas.store', $sucursal) }}">
            @csrf

            <div id="ventanillas-container">
                @foreach ($ventanillas as $i => $vent)
                    <div class="card p-3 mb-3 ventanilla-item" data-index="{{ $i }}">
                        <input type="hidden" name="ventanillas[{{ $i }}][id]" value="{{ $vent->id }}">
                        <input type="hidden" name="ventanillas[{{ $i }}][_delete]" value="false"
                            class="delete-flag">

                        <div class="row">
                            <div class="form-group col-md-6 col-12">
                                <label>Nombre</label>
                                <input name="ventanillas[{{ $i }}][nombre]" value="{{ $vent->nombre }}"
                                    class="form-control" required>
                            </div>
                            <div class="form-group col-md-6 col-12">
                                <label>Estado</label>
                                <select name="ventanillas[{{ $i }}][estado]" class="form-control">
                                    <option value="disponible" {{ $vent->estado == 'disponible' ? 'selected' : '' }}>
                                        Disponible</option>
                                    <option value="fuera de servicio"
                                        {{ $vent->estado == 'fuera de servicio' ? 'selected' : '' }}>Fuera de servicio
                                    </option>
                                </select>
                            </div>
                            <div class="form-group col-md-6 col-12">
                                <label>Funcionario Asignado</label>
                                <select name="ventanillas[{{ $i }}][user_id]" class="form-control">
                                    <option value="">-- Ninguno --</option>
                                    @foreach ($funcionarios as $user)
                                        <option value="{{ $user->id }}"
                                            {{ $vent->user_id == $user->id ? 'selected' : '' }}>{{ $user->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-6 col-12 d-flex align-items-end">
                                <div>
                                    <button type="button" class="btn btn-sm btn-danger me-2"
                                        onclick="removeVentanilla(this)">Eliminar</button>
                                    <button type="button" class="btn btn-sm btn-secondary d-none restore-btn"
                                        onclick="restoreVentanilla(this)">Restaurar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <button type="button" class="btn btn-sm btn-outline-primary mb-3" onclick="addVentanilla()">+ Añadir
                Ventanilla</button>
            <br>
            <button type="submit" class="btn btn-success">Guardar Cambios</button>
            <a href="{{ route('admin.sucursales.index') }}" class="btn btn-secondary">Volver</a>
        </form>
    </div>

    <script>
        let index = {{ count($ventanillas) }};

        function addVentanilla() {
            const container = document.getElementById('ventanillas-container');
            const html = `
<div class="card p-3 mb-3 ventanilla-item" data-index="${index}">
    <input type="hidden" name="ventanillas[${index}][id]" value="">
    <input type="hidden" name="ventanillas[${index}][_delete]" value="false" class="delete-flag">

    <div class="row">
        <div class="form-group col-md-6 col-12">
            <label>Nombre</label>
            <input name="ventanillas[${index}][nombre]" class="form-control" required>
        </div>
        <div class="form-group col-md-6 col-12">
            <label>Estado</label>
            <select name="ventanillas[${index}][estado]" class="form-control">
                <option value="disponible">Disponible</option>
                <option value="fuera de servicio">Fuera de servicio</option>
            </select>
        </div>
        <div class="form-group col-md-6 col-12">
            <label>Funcionario Asignado</label>
            <select name="ventanillas[${index}][user_id]" class="form-control">
                <option value="">-- Ninguno --</option>
                @foreach ($funcionarios as $user)
                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group col-md-6 col-12 d-flex align-items-end">
            <div>
                <button type="button" class="btn btn-sm btn-danger me-2" onclick="removeVentanilla(this)">Eliminar</button>
                <button type="button" class="btn btn-sm btn-secondary d-none restore-btn" onclick="restoreVentanilla(this)">Restaurar</button>
            </div>
        </div>
    </div>
</div>`;
            container.insertAdjacentHTML('beforeend', html);
            index++;
        }

        function removeVentanilla(button) {
            const item = button.closest('.ventanilla-item');
            const deleteInput = item.querySelector('.delete-flag');
            const restoreBtn = item.querySelector('.restore-btn');

            if (deleteInput) deleteInput.value = 'true';
            item.classList.add('bg-light', 'border', 'border-danger', 'text-muted');
            Array.from(item.querySelectorAll('input, select')).forEach(el => {
                if (el.type !== 'hidden') {
                    el.disabled = true;
                }
            });

            restoreBtn.classList.remove('d-none');
            button.classList.add('d-none');
        }

        function restoreVentanilla(button) {
            const item = button.closest('.ventanilla-item');
            const deleteInput = item.querySelector('.delete-flag');
            const removeBtn = item.querySelector('button.btn-danger');

            if (deleteInput) deleteInput.value = 'false';
            item.classList.remove('bg-light', 'border', 'border-danger', 'text-muted');
            Array.from(item.querySelectorAll('input, select')).forEach(el => {
                if (el.type !== 'hidden') {
                    el.disabled = false;
                }
            });

            button.classList.add('d-none');
            removeBtn.classList.remove('d-none');
        }
    </script>
@endsection
