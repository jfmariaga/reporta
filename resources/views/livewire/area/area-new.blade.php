<div>
    <div class="card">
        <div class="card-body">
            <div class="row">
                <fieldset class="form-group floating-label-form-group col-lg-6 col-12">
                    <label for=""><b>Selecciona el Area</b></label>
                    <select wire:model.live="area" class="form-control">
                        <option value="" selected>Seleccionar...</option>
                        @foreach ($areasUnicas as $item)
                            <option value="{{ $item->area }}">{{ $item->area }}</option>
                        @endforeach
                    </select>
                    @error('area')
                        <span class="input_error error">{{ $message }}</span>
                    @enderror
                </fieldset>
                <br>
                <fieldset class="form-group floating-label-form-group col-lg-6 col-12">
                    <label for=""><b>Localización</b></label>
                    <input type="text" oninput="this.value = this.value.replace(/[^a-zA-Z]/,' ')"
                        onkeyup="javascript:this.value=this.value.toUpperCase();"
                        class="form-control  @error('localicacion') border_error @enderror" placeholder="localicacion"
                        wire:model="localicacion">
                    @error('localicacion')
                        <span class="input_error error">{{ $message }}</span>
                    @enderror
                </fieldset>

                <div class="modal-footer">
                    <input type="reset" class="btn btn-outline-secondary btn-sm" wire:click="resetear()"
                        value="Cancelar">
                    <input type="submit" class="btn btn-outline-info btn-sm" wire:click="guardar()" value="Guardar">
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="mb-2 col-lg-4 " style="margin-left: 13px">
                <input wire:model.live="search" class="form-control" placeholder="Buscar...">
            </div>
            @if ($areas->count())
                <div class="card-body">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th style="text-align: center">Area</th>
                                <th style="text-align: center">Localización</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($areas as $item)
                                <tr>
                                    <td class="text-center">{{ $item->area }}</td>
                                    <td class="text-center">{{ $item->localicacion }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="card-footer">
                    {{ $areas->links() }}
                </div>
            @else
                <div class="card-footer">
                    <h3>No existen datos para mostrar</h3>
                </div>
            @endif
        </div>
    </div>

</div>
