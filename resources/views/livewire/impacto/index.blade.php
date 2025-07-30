<div>
    <div class="mb-2 col-lg-4" style="margin-left: -8px">
        <input wire:model.live="search" class="form-control" placeholder="Buscar...">
    </div>

    @if ($impactos->count())
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Responsable</th>
                    <th colspan="2">Accion</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($impactos as $item)
                    <tr>
                        <td>{{ $item->impacto }}</td>
                        <td>{{ $item->user->name}}</td>
                        <td class="text-center">
                            <a href="#" class="btn btn-sm btn-secondary"
                                wire:click="selecItem({{ $item->id }},'editar')" data-toggle="modal"
                                data-target="#editImpacto"><i class="far fa-edit"></i></a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="card-footer">
            {{ $impactos->links() }}
        </div>
    @else
        <div class="card-body">
            <strong>No existen datos para mostrar</strong>
        </div>
    @endif

    @push('modals')
        @include('modal.newImpacto')
        @include('modal.editImpacto')
    @endpush
</div>
