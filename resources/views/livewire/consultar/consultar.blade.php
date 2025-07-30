<div>
    <style>
        .direct-chat-messages {
            height: 300px;
            overflow-y: auto;
        }

        .direct-chat-msg {
            margin-bottom: 10px;
        }

        .direct-chat-msg .direct-chat-text {
            margin: 5px 0;
            padding: 10px;
            background-color: #d2d6de;
            border-radius: 5px;
        }

        .direct-chat-msg.right .direct-chat-text {
            background-color: #3b8dbd;
            color: #ffffff;
        }

        .direct-chat-infos {
            margin-bottom: 5px;
        }

        .direct-chat-name {
            font-weight: bold;
        }
    </style>
    <div class=" m-auto col-lg-4" style="margin-left: -8px">
        <input wire:model.live="search" class="form-control"
            placeholder="Escribe aquí el consucutivo del reporte a consultar">
    </div>
    @if ($reporte->count())
        <div class="card-body">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th style="text-align: center">Fecha</th>
                        <th style="text-align: center">Reportado por</th>
                        <th style="text-align: center">Cargo de quien reporta</th>
                        <th style="text-align: center">Area del reporte</th>
                        <th style="text-align: center">Zona de la novedad</th>
                        {{-- <th style="text-align: center">impacto</th> --}}
                        <th style="text-align: center">Prioridad</th>
                        <th style="text-align: center">Estado</th>
                        <th style="text-align: center">Consecutivo</th>
                        <th style="text-align: center">Acción </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($reporte as $item)
                        <tr>
                            <td class="text-center">{{ date_format($item->created_at, 'd-m-Y') }}</td>
                            <td class="text-center">{{ $item->ReportadoPor }}</td>
                            <td class="text-center">{{ $item->cargo->cargo }}</td>
                            <td class="text-center">{{ $item->area }}</td>
                            <td class="text-center">{{ $item->zona }}</td>
                            {{-- <td class="text-center">{{ $item->impacto->impacto }}</td> --}}
                            <td class="text-center">
                                <?php
                                if ($item->prioridad == 'ALTA') {
                                    echo '<span >ALTA</span>';
                                } elseif ($item->prioridad == 'MEDIA') {
                                    echo '<span>MEDIA</span>';
                                } else {
                                    echo '<span>BAJA</span>';
                                }
                                ?>
                            </td>
                            <td class="text-center">
                                <?php
                                if ($item->estado == 1) {
                                    echo '<span class="badge badge-info">PENDIENTE</span>';
                                } elseif ($item->estado == 2) {
                                    echo '<span class="badge badge-warning">EN PROCESO</span>';
                                } elseif ($item->estado == 3) {
                                    echo '<span class="badge badge-success">FINALIZADO</span>';
                                } elseif ($item->estado == 4) {
                                    echo '<span class="badge badge-danger">RECHAZADO</span>';
                                } elseif ($item->estado == 5) {
                                    echo '<span class="badge badge-dark">POR ACEPTACION</span>';
                                }elseif ($item->estado == 6) {
                                    echo '<span class="badge badge-dark">SEGUIMIENTO</span>';
                                } else {
                                    echo '<span class="badge badge-primary">RE-ABIERTO</span>';
                                }
                                ?>
                            </td>
                            <td class="text-center">{{ $item->consecutivo }}</td>
                            <td class="text-center">
                                <a href="#" class="btn btn-xs btn-default text-primary mx-1 shadow"
                                    wire:click="selecItem({{ $item->id }},'ver')" data-toggle="modal"
                                    data-target="#verReportes"><i class="far fa-eye"></i></a>
                                @if ($item->estado == 5 || $item->estado == 6)
                                    <a href="#" class="btn btn-xs btn-default text-danger mx-1 shadow"
                                        wire:click="selecItem({{ $item->id }},'rechazo')" data-toggle="modal"
                                        data-target="#rechazarConsulta"><i class="fas fa-times-circle"></i></a>
                                    <a href="#" class="btn btn-xs btn-default text-success mx-1 shadow"
                                        wire:click="aceptar({{ $item->id }})"><i
                                            class="fas fa-check-square"></i></a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <div class="row">
                    <div wire:loading wire:target="aceptar" class="alert alert-secondary alert-dismissible fade show"
                        role="alert">
                        <strong>Procesando...</strong>
                    </div>
                </div>
            </table>
        </div>
    @else
        <div class="card-footer">
            <h3>No existen datos para mostrar</h3>
        </div>
    @endif


</div>
