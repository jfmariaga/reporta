<div>
    <div class="mb-2 col-lg-4" style="margin-left: -8px">
        <input wire:model.live="search" class="form-control" placeholder="Buscar...">
    </div>

    @if ($areas->count())
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Responsable</th>
                    <th colspan="2">Accion</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($areas as $item)
                    <tr>
                        <td>{{ $item->area }}</td>
                        @if ($item->user_id)
                            <td>{{ $item->user->name }}</td>
                        @else
                            <td>vacio</td>
                        @endif
                        <td class="text-center">

                            <!-- Botón editar gestión -->
                            <a href="#" class="btn btn-sm btn-secondary"
                                wire:click="selecItem({{ $item->id }},'editar')" data-toggle="modal"
                                data-target="#editGestion">
                                <i class="far fa-edit"></i>
                            </a>

                            <!-- Botón grupo de apoyo -->
                            <a href="#" class="btn btn-sm btn-info"
                                wire:click="selecItem({{ $item->id }},'equipo')" data-toggle="modal"
                                data-target="#modalEquipo">
                                <i class="fas fa-users"></i>
                            </a>

                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="card-footer">
            {{ $areas->links() }}
        </div>
    @else
        <div class="card-body">
            <strong>No existen datos para mostrar</strong>
        </div>
    @endif

    @push('modals')
        @include('modal.newGestion')
        @include('modal.editGestion')
        @include('modal.grupoApoyo')
    @endpush
</div>
