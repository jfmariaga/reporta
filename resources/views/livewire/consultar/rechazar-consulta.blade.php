<div>
    <div class="form-group floating-label-form-group col-lg-12 col-12">
        <textarea class="form-control" name="respuesta" wire:model.defer="comentario" id="" cols="40"
            rows="4" placeholder="Si no estas conforme con esta solución por favor escribe aquí el motivo"></textarea>
        @error('comentario')
            <span class="c_error2 error text-danger">{{ $message }}</span>
        @enderror
    </div>
    <div class="row">
        <div wire:loading wire:target="update" class="alert alert-secondary alert-dismissible fade show"
            role="alert">
            <strong>Procesando...</strong>
        </div>
    </div>
    <br>
    <div class="float-right">
        <button class="btn btn-sm btn-outline-primary" wire:loading.attr="disabled" wire:click="update()">Guadar</button>
        <button class="btn btn-sm btn-outline-danger" wire:click="resetear()" class="close" data-dismiss="modal"
            aria-label="Close">Cancelar</button>
    </div>
</div>
