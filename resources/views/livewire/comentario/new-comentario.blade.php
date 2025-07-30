<div>
    <div class="card direct-chat direct-chat-primary">
        <div class="card-header">
            <h3 class="card-title">Chat de Comentarios</h3>
        </div>
        <div class="card-body">
            <div class="direct-chat-messages">
                @if ($comentarios != null)
                    @foreach ($comentarios as $item)
                        @if ($item->user_id)
                            <div class="direct-chat-msg right">
                                <div class="direct-chat-infos clearfix">
                                    <span
                                        class="direct-chat-name float-right">{{ $item->user->name ?? 'Anónimo' }}</span>
                                    <span
                                        class="direct-chat-timestamp float-left">{{ $item->created_at->format('d M Y h:i a') }}</span>
                                </div>
                                <div class="direct-chat-text">
                                    {{ $item->comentario }}
                                </div>
                            </div>
                        @else
                            <div class="direct-chat-msg">
                                <div class="direct-chat-infos clearfix">
                                    <span
                                        class="direct-chat-name float-left">{{ $item->reporte->ReportadoPor ?? 'Anónimo' }}</span>
                                    <span
                                        class="direct-chat-timestamp float-right">{{ $item->created_at->format('d M Y h:i a') }}</span>
                                </div>
                                <div class="direct-chat-text">
                                    {{ $item->comentario }}
                                </div>
                            </div>
                        @endif
                    @endforeach
                @else
                    <div class="card-body">
                        <strong>No existen comentarios para este reporte</strong>
                    </div>
                @endif
            </div>
        </div>
        <div class="card-footer">
            @if ($estado == 3 || $estado == 4 || $estado == 5)
                <form wire:submit.prevent="submit">
                    <div class="input-group">
                        <input disabled type="text" placeholder="Escribe un comentario ..." class="form-control"
                            wire:model="mensaje">
                        <span class="input-group-append">
                            <button disabled type="submit" class="btn btn-primary">Enviar</button>
                        </span>
                    </div>
                </form>
            @else
                <form wire:submit.prevent="submit">
                    <div class="input-group">
                        <input type="text" placeholder="Escribe un comentario ..." class="form-control"
                            wire:model="mensaje">
                        <span class="input-group-append">
                            <button type="submit" class="btn btn-primary">Enviar</button>
                        </span>
                    </div>
                </form>
            @endif
        </div>
    </div>
</div>
