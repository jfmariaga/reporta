<div>
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">👥 Gestión de Equipos de Apoyo</h5>
            <button type="button" class="close" data-dismiss="modal" wire:click="limpiar()">&times;</button>
        </div>
        <div class="modal-body">
            @if ($responsable_id)
                <div class="card p-3 mb-4">

                    <div class="row">
                        <div class="col-md-8">
                            <label>Usuario Apoyo</label>
                            <select wire:model="apoyo_id" class="form-control">
                                <option value="">Seleccione</option>
                                @foreach ($usuarios as $u)
                                    <option value="{{ $u->id }}">{{ $u->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4 d-flex align-items-end">
                            <button wire:click="agregar" class="btn btn-primary w-100">
                                Agregar
                            </button>
                        </div>
                    </div>

                </div>

                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Apoyo</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($equipos as $e)
                            <tr>
                                <td>{{ $e->apoyo->name }}</td>
                                <td class="text-center">
                                    <button wire:click="eliminar({{ $e->id }})" class="btn btn-sm btn-danger">
                                         <i class="fas fa-trash-alt"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="spinner-border text-primary" role="status">
                    <span class=" text-center"></span>
                </div>
            @endif

        </div>
    </div>
</div>
