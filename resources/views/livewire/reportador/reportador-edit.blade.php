<div>
    @if ($modelId)
        <div>
            <label>Nombre</label>
            <input wire:model.defer="nombre" onkeyup="javascript:this.value=this.value.toUpperCase();" type="text"
                class="form-control" placeholder="Nombre del reportador" @error('nombre') border_error @enderror>
            @error('nombre')
                <span class="input_error error text-danger">{{ $message }}</span>
            @enderror
        </div>
        <br>
        <div>
            <label>Cedula</label>
            <input wire:model.defer="cc" onkeyup="javascript:this.value=this.value.toUpperCase();" type="number"
                class="form-control" placeholder="Numero de cedula del reportador" @error('cc') border_error @enderror>
            @error('cc')
                <span class="input_error error text-danger">{{ $message }}</span>
            @enderror
        </div>
        <br>
        <div>
            <label>Correo</label>
            <input wire:model.defer="email" type="text" class="form-control" placeholder="Correo del reportador"
                @error('email') border_error @enderror>
            @error('email')
                <span class="input_error error text-danger">{{ $message }}</span>
            @enderror
        </div>
        <br>
        <div class="float-right">
            <button class="btn btn-sm btn-outline-primary" wire:click="update()">Guadar</button>
            <button class="btn btn-sm btn-outline-danger" wire:click="resetear" class="close" data-dismiss="modal"
                aria-label="Close">Cancelar</button>
        </div>
    @else
        <div class="spinner-border text-primary" role="status">
            <span class=" text-center"></span>
        </div>
    @endif
</div>
