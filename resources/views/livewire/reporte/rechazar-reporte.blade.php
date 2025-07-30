<div>
    <div class="form-group floating-label-form-group col-lg-12 col-12">
        <label class="float-left"><b>Motivo del rechazo</b></label>
        <textarea class="form-control" name="respuesta" wire:model.defer="respuesta" id="" cols="40"
            rows="4"></textarea>
        @error('respuesta')
            <span class="c_error2 error text-danger">{{ $message }}</span>
        @enderror
    </div>
    <div class="row mt-3">
        <div wire:loading wire:target="update" class="alert alert-secondary col-12">
            <strong>Procesando...</strong> Por favor espere mientras se termina de procesar esta solicitud.
        </div>
    </div>
    <br>
    <div class="float-right">
        <button class="btn btn-sm btn-outline-primary" wire:loading.attr="disabled" wire:click="update()">Guadar</button>
        <button class="btn btn-sm btn-outline-danger" wire:loading.attr="disabled"  wire:click="resetear()" class="close" data-dismiss="modal"
            aria-label="Close">Cancelar</button>
    </div>
</div>
