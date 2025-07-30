<div>
    @if ($modelId)
        <div class="form-group col-lg-6 col-12">
            <label><b>Área del reporte</b></label>
            <select wire:model.live="area" class="form-control">
                <option value="" selected>Seleccionar...</option>
                @foreach ($areasUnicas as $item)
                    <option value="{{ $item->area }}"> {{ $item->area }} </option>
                @endforeach
            </select>
            @error('area')
                <span class="input_error">{{ $message }}</span>
            @enderror
        </div>
        <br>
        <br>
        <div class="form-group floating-label-form-group col-lg-12 col-12">
            <label class="float-left"><b>Cargo</b></label>
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
            <button class="btn btn-sm btn-outline-primary" wire:click="update()">Guadar</button>
            <button class="btn btn-sm btn-outline-danger" wire:click="resetear()" class="close" data-dismiss="modal"
                aria-label="Close">Cancelar</button>
        </div>
    @else
        <div class="spinner-border text-primary" role="status">
            <span class=" text-center"></span>
        </div>
    @endif

</div>
