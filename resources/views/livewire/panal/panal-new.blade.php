<div>
    <div>
        <label>Nombre</label>
        <input wire:model="area" onkeyup="javascript:this.value=this.value.toUpperCase();" type="text"
            class="form-control" placeholder="Nombre del area" @error('area') border_error @enderror>
        @error('area')
            <span class="input_error error text-danger">{{ $message }}</span>
        @enderror
    </div>
    <br>
    <br>
    <div class="float-right">
        <button class="btn btn-sm btn-outline-primary" wire:click="guardar()">Guadar</button>
        <button class="btn btn-sm btn-outline-danger" wire:click="resetear()" class="close" data-dismiss="modal"
            aria-label="Close">Cancelar</button>
    </div>
</div>
