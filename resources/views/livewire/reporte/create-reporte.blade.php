<div>
    <style>
        .form-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .card-body {
            padding: 20px;
        }

        .modal-footer {
            display: flex;
            justify-content: space-between;
        }

        .input_error {
            font-size: 0.9em;
            color: #dc3545;
        }
    </style>
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="form-group col-lg-3 col-12">
                        <label><b>Número de cédula</b></label>
                        <input autocomplete="none" type="number" wire:model.live="search" class="form-control"
                            placeholder="Escribe aquí su cédula">
                        @error('search')
                            <span class="input_error">{{ $message }}</span>
                        @enderror
                    </div>
                    @if (count($empleado) > 0)
                        @foreach ($empleado as $item)
                            <div class="form-group col-lg-3 col-12">
                                <label><b>Nombre de quien reporta</b></label>
                                <input type="text" wire:model.live="nombre"
                                    class="form-control @error('nombre') is-invalid @enderror"
                                    placeholder="{{ $item->nombre }}" disabled />
                                @error('nombre')
                                    <span class="input_error">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group col-lg-3 col-12">
                                <label><b>A donde quieres que te notifiquemos</b></label>
                                <select wire:model.live="reporEmail" class="form-control" disabled>
                                    <option value="{{ $item->email }}"> {{ $item->email }} </option>
                                </select>
                                @error('reporEmail')
                                    <span class="input_error">{{ $message }}</span>
                                @enderror
                            </div>
                        @endforeach
                    @else
                        <div class="form-group col-lg-3 col-12">
                            <label><b>Nombre de quien reporta</b></label>
                            <input type="text" wire:model="nombre"
                                class="form-control @error('nombre') is-invalid @enderror" placeholder="Nombre">
                            @error('nombre')
                                <span class="input_error">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group col-lg-3 col-12">
                            <label><b>A donde quieres que te notifiquemos</b></label>
                            <select wire:model.live="reporEmail" class="form-control">
                                <option value="" selected>Seleccionar...</option>
                                <option value="supervisor.almacen@panalsas.com">Wilber Ochoa</option>
                                <option value="supervisor.ambiental@panalsas.com">Robinson Cardona Castrillon</option>
                                <option value="supervisor2.produccion@panalsas.com">Carlos Echeverri</option>
                                <option value="supervisor3.produccion@panalsas.com">Edgar Santiago Lopez Carmona</option>
                                <option value="supervisor4.produccion@panalsas.com">Jesus Ernesto Hoyos</option>
                                <option value="supervisor5.produccion@panalsas.com">Juan Esteban Alzate</option>
                                <option value="supervisor6.produccion@panalsas.com">Carlos Andres Ocampo</option>
                                <option value="supervisor7.produccion@panalsas.com">Jhony Cuervo</option>
                                <option value="supervisor8.produccion@panalsas.com">Alejandro Perez Muñoz</option>
                                <option value="nelson.cardona@levapan.com">Nelson Cardona</option>
                                <option value="diego.duque@levapan.com">Diego Duque</option>
                                <option value="luis.mazo@levapan.com">Luis Carlos Mazo</option>
                            </select>
                            @error('reporEmail')
                                <span class="input_error">{{ $message }}</span>
                            @enderror
                        </div>
                    @endif
                    <div class="form-group col-lg-3 col-12">
                        <label><b>Área a la que perteneces</b></label>
                        <select wire:model.live="panal" class="form-control">
                            <option value="" selected>Seleccionar...</option>
                            @foreach ($panals as $item)
                                <option value="{{ $item->area }}"> {{ $item->area }} </option>
                            @endforeach
                        </select>
                        @error('area')
                            <span class="input_error">{{ $message }}</span>
                        @enderror
                    </div>
                    @if ($cargos)
                        <div class="form-group col-lg-6 col-12">
                            <label><b>Cargo</b></label>
                            <select wire:model.defer="cargo" class="form-control">
                                <option value="" selected>Seleccionar...</option>
                                @foreach ($cargos as $item)
                                    <option value="{{ $item->id }}"> {{ $item->cargo }} </option>
                                @endforeach
                            </select>
                            @error('cargo')
                                <span class="input_error">{{ $message }}</span>
                            @enderror
                        </div>
                    @endif
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
                    @if ($zonas)
                        <div class="form-group col-lg-6 col-12">
                            <label><b>Zona especifica de la novedad</b></label>
                            <select wire:model.defer="zona" class="form-control">
                                <option value="" selected>Seleccionar...</option>
                                @foreach ($zonas as $item)
                                    <option value="{{ $item->localicacion }}"> {{ $item->localicacion }} </option>
                                @endforeach
                            </select>
                            @error('zona')
                                <span class="input_error">{{ $message }}</span>
                            @enderror
                        </div>
                    @endif
                    <div class="form-group col-lg-6 col-12">
                        <label><b>Selecciona uno o varios sistemas de gestión de impacto</b></label>
                        <select wire:model.defer="impacto" class="form-control" multiple>
                            <option value="" selected>Seleccionar...</option>
                            @foreach ($impactos as $item)
                                <option value="{{ $item->id }}"> {{ $item->impacto }} </option>
                            @endforeach
                        </select>
                        @error('impacto')
                            <span class="input_error">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group col-lg-6 col-12">
                        <label><b>Descripción del reporte</b></label>
                        <textarea class="form-control" name="descripcion" wire:model="descripcion" cols="30" rows="5"
                            placeholder="Que(Hallazgo), Como(Estado), Donde(Ubicación), Propuesta de mejora"></textarea>
                        @error('descripcion')
                            <span class="input_error">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group col-lg-6 col-12">
                        <label><b>Orden de trabajo (solo si la conoces)</b></label>
                        <input type="text" class="form-control @error('nombre') is-invalid @enderror"
                            placeholder="# de orden" wire:model="orden">
                        @error('orden')
                            <span class="input_error">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group col-lg-6 col-12">
                        <label><b>Asigna una prioridad al reporte</b></label>
                        <select wire:model.defer="prioridad" class="form-control">
                            <option value="" selected>Seleccionar...</option>
                            <option value="ALTA">ALTA</option>
                            <option value="MEDIA">MEDIA</option>
                            <option value="BAJA">BAJA</option>
                        </select>
                        @error('prioridad')
                            <span class="input_error">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group col-md-6 col-lg-6 col-12">
                        <label><b>Agrega un registro fotográfico</b></label>
                        {{-- <input type="file" id="{{ $identificar }}" wire:model="img"> --}}
                        <x-adminlte-input-file id="{{ $identificar }}" wire:model="img" name="ifPholder"
                            igroup-size="sm" placeholder="Seleccionar un archivo...">
                            <x-slot name="prependSlot">
                                <div class="input-group-text bg-lightblue">
                                    <i class="fas fa-upload"></i>
                                </div>
                            </x-slot>
                        </x-adminlte-input-file>
                        <div class="row mt-3">
                            <div class="col-12">
                                @if ($img)
                                    <img src="{{ $img->temporaryUrl() }}" alt="" class="img-fluid">
                                @endif
                            </div>
                        </div>
                        @error('img')
                            <span class="input_error">{{ $message }}</span>
                        @enderror
                        <div class="row mt-2">
                            <div wire:loading wire:target="img" class="alert alert-secondary col-12">
                                <strong>Cargando imagen</strong> Por favor espere mientras se termina de cargar la
                                imagen.
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-3">
                    <div wire:loading wire:target="guardar" class="alert alert-secondary col-12">
                        <strong>Procesando tu reporte</strong> Por favor espere mientras se termina de procesar el
                        reporte.
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="reset" class="btn btn-outline-secondary btn-sm"
                    wire:click="resetear()">Cancelar</button>
                <button type="submit" class="btn btn-outline-info btn-sm" wire:click="guardar()"
                    wire:loading.attr="disabled" wire:target="img">Guardar</button>
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</div>
