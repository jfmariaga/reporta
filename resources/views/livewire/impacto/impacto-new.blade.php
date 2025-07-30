<div>
    <div>
        <label>Nombre</label>
        <input wire:model="impacto" onkeyup="javascript:this.value=this.value.toUpperCase();" type="text"
            class="form-control" placeholder="Nombre del area" @error('impacto') border_error @enderror>
        @error('impacto')
            <span class="input_error error text-danger">{{ $message }}</span>
        @enderror
    </div>
    <br>
    <br>
    <div class="form-group floating-label-form-group col-lg-12 col-12">
        <label class="float-left"><b>Responsable</b></label>
        <select wire:model.defer="responsable" class="form-control">
            <option value="" selected>Seleccionar...</option>
            @foreach ($usuarios as $item)
                <option value="{{ $item->id }}"> {{ $item->name }} </option>
            @endforeach
        </select>
        @error('responsable')
            <span class="c_error2 error text-danger">{{ $message }}</span>
        @enderror
    </div>
    <br>
    <div class="float-right">
        <button class="btn btn-sm btn-outline-primary" wire:click="guardar()">Guadar</button>
        <button class="btn btn-sm btn-outline-danger" wire:click="resetear()" class="close" data-dismiss="modal"
            aria-label="Close">Cancelar</button>
    </div>
</div>
