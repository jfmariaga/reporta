<div>
    <div class="modal-header">
        <h5 class="modal-title">Editar Usuario</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" wire:click="resetear()">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        @if ($modelId)
            <div class="row">
                <fieldset class="form-group floating-label-form-group col-lg-6 col-12">
                    <label for="">Nombre</label>
                    <input type="text" class="form-control  @error('nombre') border_error @enderror" placeholder="Nombre"
                        wire:model="name">
                    @error('name') <span class="input_error error text-danger">{{ $message }}</span> @enderror
                </fieldset>
                <br>
                <fieldset class="form-group floating-label-form-group col-lg-6 col-12">
                    <label>Rol</label>
                    <select wire:model.defer="role_id" @error('rol_id') border_error @enderror class="form-control">
                        <option selected>Seleccionar...</option>
                        @foreach ($roles as $item)
                            <option value="{{ $item->id }}"> {{ $item->name }} </option>
                        @endforeach
                    </select>
                    @error('rol_id') <span class="input_error error text-danger">{{ $message }}</span> @enderror
                </fieldset>
                <br>
                <fieldset class="form-group floating-label-form-group col-lg-6 col-12">
                    <label for="">Correo</label>
                    <input type="email" class="form-control @error('email') border_error @enderror" placeholder="Correo"
                        wire:model="email">
                    @error('email') <span class="input_error error text-danger">{{ $message }}</span> @enderror
                </fieldset>
                <br>
            </div>
        @else
            <div class="spinner-border text-primary" role="status">
                <span class=" text-center">Cargando...</span>
            </div>
        @endif
    </div>
    <div class="modal-footer">
        <input type="submit" class="btn btn-outline-primary btn-sm" wire:click="update()" value="Guardar">
        <input type="reset" class="btn btn-outline-danger btn-sm" data-dismiss="modal" wire:click="resetear()"
        value="Cancelar">
    </div>
</div>

