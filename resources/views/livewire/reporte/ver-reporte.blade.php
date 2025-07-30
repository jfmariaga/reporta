<div>
    <style>
        #comentarioModal {
            z-index: 1051;
            /* Slightly higher z-index to be on top of the first modal */
        }

        .timeline-horizontal {
            display: flex;
            overflow-x: auto;
            padding: 20px;
            white-space: nowrap;
        }

        .timeline-item {
            display: inline-block;
            background: #f4f4f4;
            border-radius: 10px;
            margin: 5px 20px;
            padding: 10px 20px;
            box-shadow: 0 3px 6px rgba(0, 0, 0, 0.1);
            position: relative;
        }

        .timeline-icon {
            width: 30px;
            height: 30px;
            background-color: #777;
            border-radius: 50%;
            position: absolute;
            left: -15px;
            /* Adjust this value if needed */
            top: 10px;
        }

        .timeline-content {
            padding-left: 40px;
            /* Adjust based on the size of the timeline-icon */
        }

        .timeline-content h2 {
            font-size: 16px;
            font-weight: bold;
            color: #555;
        }

        .timeline-content p {
            font-size: 14px;
            color: #666;
        }
    </style>
    @if ($modelId)
        <div class="modal-header">
            <h5 class="modal-title">Gestionar Reporte con consecutivo <b>{{ $consecutivo }}</b></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            @if ($estado == 7)
                <div class="card">
                    <div class="row">
                        <div class="form-group floating-label-form-group col-lg-12 col-6">
                            <label class="float-left"><b>Comentario de no aceptación</b></label>
                            <textarea class="form-control" name="respuesta" wire:model.defer="comentario" id="" cols="40"
                                rows="4" disabled></textarea>
                        </div>
                    </div>
                </div>
            @endif
            @if ($estado == 1 || $estado == 2 || $estado == 7)
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <h5 class="text-muted font-weight-bold pt-4 px-3 border-bottom-0 my-3">Seguimiento</h5>
                        </div>
                        <div class="row">
                            @if (auth()->user())
                                <div class="col-sm-4 col-md-4 col-lg-4">
                                    <li class="list-group-item">
                                        Gestionar
                                        <div class="float-right">
                                            <label class="switch">
                                                <input type="checkbox" wire:model.live="check">
                                                <span class="slider round"></span>
                                            </label>
                                        </div>
                                    </li>
                                </div>
                            @endif
                            <div class="col-sm-4 col-md-4 col-lg-4">
                                <a href="#" wire:click="pasarId({{ $modelId }})" class="btn btn-lg btn-dark"
                                    data-toggle="modal" data-target="#comentarioModal">Comentarios</a>
                                <a href="#" class="btn btn-lg btn-dark" data-toggle="modal"
                                    data-target="#timeLineModal">TimeLine</a>
                                <div class="modal fade" id="timeLineModal" tabindex="-1" role="dialog"
                                    aria-labelledby="comentarioModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg" role="document">
                                        <div class="modal-content">
                                            <div class="modal-body">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <h5 class="text-muted font-weight-bold">Historial del Reporte
                                                        </h5>
                                                        <div class="timeline">
                                                            @foreach ($historial as $evento)
                                                                <div class="timeline-item">
                                                                    <div class="timeline-icon">
                                                                        <!-- Icono o indicador por año/evento, puede ser un círculo o cualquier forma definida en CSS -->
                                                                    </div>
                                                                    <div
                                                                        class="timeline-content {{ $loop->iteration % 2 == 0 ? 'right' : '' }}">
                                                                        <h2>{{ $evento->fecha }}</h2>
                                                                        <!-- Fecha del evento -->
                                                                        <p>{{ $evento->descripcion }}</p>
                                                                        <!-- Descripción del evento -->
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <br>
                        <div class="row {{ $class }}">
                            <fieldset class="form-group floating-label-form-group col-lg-6 col-6">
                                <label for=""><b>Selecciona la fecha limite de seguimiento</b></label>
                                <input type="date" class="form-control  @error('seguimiento') border_error @enderror"
                                    wire:model.defer="seguimiento">
                                @error('seguimiento')
                                    <span class="input_error error text-danger">{{ $message }}</span>
                                @enderror
                            </fieldset>
                            <fieldset class="form-group floating-label-form-group col-lg-6 col-6">
                                <label for=""><b>Asignar una orden de trabajo a este reporte</b></label>
                                <input type="text" oninput="this.value = this.value.replace(/[^a-zA-Z]/,' ')"
                                    onkeyup="javascript:this.value=this.value.toUpperCase();"
                                    class="form-control  @error('nombre') border_error @enderror"
                                    placeholder="# de orden" wire:model.defer="orden">
                                @error('orden')
                                    <span class="input_error error">{{ $message }}</span>
                                @enderror
                            </fieldset>
                            <div class="col-md-6 mb-3">
                                <label class="float-left"><b>Agrega un registro fotografico </b></label>
                                <br>
                                <x-adminlte-input-file id="{{ $identificar }}" wire:model.defer="img2" name="ifPholder"
                                    igroup-size="sm" placeholder="Seleccionar un archivo...">
                                    <x-slot name="prependSlot">
                                        <div class="input-group-text bg-lightblue">
                                            <i class="fas fa-upload"></i>
                                        </div>
                                    </x-slot>
                                </x-adminlte-input-file>
                                <div class="row">
                                    <div class="col-sm-8 col-md-8 col-lg-8">
                                        @if ($img3)
                                            <br>
                                            <img src="{{ Storage::url($img3) }}" alt=""
                                                style="width: 50%; height: auto;">
                                            <br>
                                            <a target="_blank" href="{{ Storage::url($img3) }}">Ampliar imagen</a>
                                        @endif
                                        @if ($img2)
                                            <br>
                                            <img src="{{ $img2->temporaryUrl() }}" alt=""
                                                style="width: 50%; height: auto;">
                                        @endif
                                    </div>
                                </div>
                                @error('img2')
                                    <span class="c_error2 error text-danger">{{ $message }}</span>
                                @enderror
                                <div class="row">
                                    <div wire:loading wire:target="img2"
                                        class="alert alert-secondary alert-dismissible fade show" role="alert">
                                        <strong>Cargando imagen</strong> Por favor espere mientras se termina de cargar
                                        la
                                        imagen
                                    </div>
                                </div>
                            </div>
                            <div class="form-group floating-label-form-group col-lg-6 col-6">
                                <label class="float-left"><b>Respuesta</b></label>
                                <textarea class="form-control" name="respuesta" wire:model.defer="respuesta" id="" cols="40"
                                    rows="4"></textarea>
                                @error('respuesta')
                                    <span class="c_error2 error text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="row">
                                <div wire:loading wire:target="update"
                                    class="alert alert-secondary alert-dismissible fade show" role="alert">
                                    <strong>Procesando...</strong>
                                </div>
                            </div>
                            <div class="row">
                                <div wire:loading wire:target="cerrar"
                                    class="alert alert-secondary alert-dismissible fade show" role="alert">
                                    <strong>Procesando...</strong>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="modal-footer text-center">
                                    @if (auth()->user() && auth()->user()->hasRole('JefeArea'))
                                        @if ($estado == 1)
                                            <input type="submit" class="btn btn-outline-info btn-md"
                                                wire:click="update()" value="Aceptar reporte">
                                        @else
                                            <input type="submit" class="btn btn-outline-info btn-md"
                                                wire:click="update()" value="Guardar">
                                            <input type="reset" class="btn btn-outline-secondary btn-md"
                                                wire:click="cerrar()" value="Enviar para seguimiento">
                                        @endif
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            @if ($estado == 3 || $estado == 4 || $estado == 6)
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <h5 class="text-muted font-weight-bold border-bottom-0 ">Gestion del
                                Reporte</h5>
                        </div>
                        <div class="col-sm-4 col-md-4 col-lg-4">
                            <a href="#" wire:click="pasarId({{ $modelId }})" class="btn btn-lg btn-dark"
                                data-toggle="modal" data-target="#comentarioModal">Comentarios</a>
                            <a href="#" class="btn btn-lg btn-dark" data-toggle="modal"
                                data-target="#timeLineModal">TimeLine</a>
                            <div class="modal fade" id="timeLineModal" tabindex="-1" role="dialog"
                                aria-labelledby="comentarioModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg" role="document">
                                    <div class="modal-content">
                                        <div class="modal-body">
                                            <div class="card">
                                                <div class="card-body">
                                                    <h5 class="text-muted font-weight-bold">Historial del Reporte</h5>
                                                    <div class="timeline-horizontal">
                                                        @foreach ($historial as $evento)
                                                            <div class="timeline-item">
                                                                <div class="timeline-icon"></div>
                                                                <div class="timeline-content">
                                                                    <h2>{{ $evento->created_at->format('Y-m-d') }}</h2>
                                                                    <p>{{ $evento->detalle }}</p>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row font-weight-bold pt-4 px-3 border-bottom-0 my-3">
                            <fieldset class="form-group floating-label-form-group col-lg-6 col-6">
                                <label for=""><b>Fecha limite para aceptación</b></label>
                                <input type="date" disabled
                                    class="form-control  @error('seguimiento') border_error @enderror"
                                    wire:model.defer="seguimiento">
                                @error('seguimiento')
                                    <span class="input_error error text-danger">{{ $message }}</span>
                                @enderror
                            </fieldset>
                            <fieldset class="form-group floating-label-form-group col-lg-6 col-6">
                                <label for=""><b>Orden de trabajo</b></label>
                                <input type="text" oninput="this.value = this.value.replace(/[^a-zA-Z]/,' ')"
                                    onkeyup="javascript:this.value=this.value.toUpperCase();"
                                    class="form-control  @error('nombre') border_error @enderror"
                                    placeholder="# de orden" wire:model.defer="orden" disabled>
                                @error('orden')
                                    <span class="input_error error">{{ $message }}</span>
                                @enderror
                            </fieldset>
                            <div class="form-group floating-label-form-group col-lg-6 col-6">
                                <label class="float-left"><b>Respuesta</b></label>
                                <textarea disabled class="form-control" name="respuesta" wire:model.defer="respuesta" id="" cols="40"
                                    rows="4"></textarea>
                                @error('respuesta')
                                    <span class="c_error2 error text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="float-left"><b>Evidencia </b></label>
                                <br>
                                <div class="row">
                                    <div class="col-sm-6 col-md-6 col-lg-6">
                                        @if ($img3)
                                            <br>
                                            <img src="{{ Storage::url($img3) }}" alt=""
                                                style="width: 50%; height: auto;">
                                            <br>
                                            <a target="_blank" href="{{ Storage::url($img3) }}">Ampliar imagen</a>
                                            <hr>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <h5 class="text-muted font-weight-bold pt-4 px-3 border-bottom-0 my-3">Reporte Inicial</h5>
                    </div>
                    <div class="row">
                        <fieldset class="form-group floating-label-form-group col-lg-6 col-12">
                            <label for=""><b>Nombre de quien reporta</b></label>
                            <input type="text" oninput="this.value = this.value.replace(/[^a-zA-Z]/,' ')"
                                onkeyup="javascript:this.value=this.value.toUpperCase();"
                                class="form-control  @error('nombre') border_error @enderror" placeholder="Nombre"
                                wire:model.defer="nombre" disabled>
                        </fieldset>
                        <br>
                        <div class="form-group floating-label-form-group col-lg-6 col-12">
                            <label class="float-left"><b>Area del reporte</b></label>
                            <select wire:model.defer="area" class="form-control"
                                @if ($estado != 1) disabled @endif>
                                <option value="" selected>Seleccionar...</option>
                                @foreach ($areasUnicas as $item)
                                    <option value="{{ $item->area }}"> {{ $item->area }} </option>
                                @endforeach
                            </select>
                        </div>
                        <br>
                        <fieldset class="form-group floating-label-form-group col-lg-6 col-12">
                            <label for=""><b>Zona de la novedad</b></label>
                            <input type="text" class="form-control  @error('zona') border_error @enderror"
                                placeholder="Zona" wire:model.defer="zona" disabled>
                        </fieldset>
                        <br>
                        <div class="form-group floating-label-form-group col-lg-6 col-12">
                            <label class="float-left"><b>Cargo de quien reporta</b></label>
                            <select wire:model.defer="cargo" class="form-control" disabled>
                                <option value="" selected>Seleccionar...</option>
                                @foreach ($cargos as $item)
                                    <option value="{{ $item->id }}"> {{ $item->cargo }} </option>
                                @endforeach
                            </select>
                        </div>
                        <br>
                        <div class="form-group floating-label-form-group col-lg-6 col-12">
                            <label class="float-left"><b>Sistemas de gestion que impacta el reporte</b></label>
                            <select wire:model.defer="impacto" class="form-control" multiple
                                @if ($estado != 1) disabled @endif>
                                @foreach ($impactos as $item)
                                    <option value="{{ $item->id }}"
                                        {{ in_array($item->id, $impacto ?? []) ? 'selected' : '' }}>
                                        {{ $item->impacto }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <br>
                        <div class="form-group floating-label-form-group col-lg-6 col-12">
                            <label class="float-left"><b>Prioridad al reporte</b></label>
                            <select wire:model.defer="prioridad" class="form-control" disabled>
                                <option value="" selected>Seleccionar...</option>
                                <option value="ALTA">ALTA</option>
                                <option value="MEDIA">MEDIA</option>
                                <option value="BAJA">BAJA</option>
                            </select>
                        </div>
                        <br>
                        @if (!is_null($orden))
                            <fieldset class="form-group floating-label-form-group col-lg-12 col-12">
                                <label for=""><b>Orden de trabajo (solo si la conoces)</b></label>
                                <input type="text" oninput="this.value = this.value.replace(/[^a-zA-Z]/,' ')"
                                    onkeyup="javascript:this.value=this.value.toUpperCase();"
                                    class="form-control  @error('nombre') border_error @enderror"
                                    placeholder="# de orden" wire:model.defer="orden" disabled>
                            </fieldset>
                        @endif
                        <br>
                        <div class="form-group floating-label-form-group col-lg-6 col-6">
                            <label class="float-left"><b>Descripción del reporte. Que(Hallazgo), Como(Estado),
                                    Donde(Ubicación)</b></label>
                            <textarea class="form-control" name="descripcion" wire:model.defer="descripcion" id="" cols="30"
                                rows="5" disabled></textarea>
                        </div>
                        <br>
                        @if ($estado == 4)
                            <div class="form-group floating-label-form-group col-lg-6 col-6">
                                <label class="float-left"><b>Motivo del rechazo</b></label>
                                <textarea class="form-control mt-4" name="respuesta" wire:model.defer="respuesta" id="" cols="40"
                                    rows="6" disabled></textarea>
                            </div>
                        @endif
                        <br>
                        <div class="col-md-6">
                            <label class="float-left"><b>Evidencia</b></label>
                            <br>
                            <div class="row">
                                <div class="col-sm-8 col-md-8 col-lg-8">
                                    @if ($img)
                                        <br>
                                        <img src="{{ Storage::url($img) }}" alt=""
                                            style="width: 50%; height: auto;">
                                        <br>
                                        <a target="_blank" href="{{ Storage::url($img) }}">Ampliar imagen</a>
                                        <hr>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    @if ($estado == 1 && auth()->user() && auth()->user()->hasRole('JefeArea'))
                        <div class="modal-footer text-center">
                            <input type="button" class="btn btn-outline-warning btn-md"
                                wire:click="recategorizarReporte()" value="Recategorizar reporte">
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @else
        <div class="spinner-border text-primary" role="status">
            <span class=" text-center"></span>
        </div>
    @endif
</div>
