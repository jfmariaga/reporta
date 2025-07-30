<div>
    <table class="table table-striped table-hover table-bordered dataex-html5-export">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Correo</th>
                <th>Rol</th>
                <th colspan="2">Acción</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($usuarios as $usuario)
                <tr>
                    <td>{{ $usuario->name }}</td>
                    <td>{{ $usuario->email }}</td>
                    <td>{{ $usuario->roles[0]->name }}</td>
                    <td class="text-center">
                        <a href="#" class="btn btn-sm btn-warning" wire:click="selecItem({{ $usuario->id }},'update')"
                            data-toggle="modal" data-target="#editUsuario"><i class="far fa-edit"></i></a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    @push('modals')
        @include('modal.nuevo-usuario')
        @include('modal.editar-usuario')
    @endpush
</div>

