<div>
    <div class="mb-2 col-lg-4" style="margin-left: -8px">
        <input wire:model.live="search" class="form-control" placeholder="Buscar...">
    </div>

    @if ($reportadores->count())
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Cedula</th>
                    <th>Email</th>
                    <th colspan="2">Accion</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($reportadores as $item)
                    <tr>
                        <td>{{ $item->nombre }}</td>
                        <td>{{ $item->cc }}</td>
                        <td>{{ $item->email }}</td>

                        <td class="text-center">
                            <a href="#" class="btn btn-sm btn-secondary"
                                wire:click="selecItem({{ $item->id }},'editar')" data-toggle="modal"
                                data-target="#editReportador"><i class="far fa-edit"></i></a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="card-footer">
            {{ $reportadores->links() }}
        </div>
    @else
        <div class="card-body">
            <strong>No existen datos para mostrar</strong>
        </div>
    @endif

    @push('modals')
        @include('modal.newReportador')
        @include('modal.editReportador')
    @endpush
</div>
