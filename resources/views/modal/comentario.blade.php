<div class="modal fade" id="comentarioModal" tabindex="-1" role="dialog" aria-labelledby="comentarioModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="comentarioModalLabel">Comentarios</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @livewire('comentario.new-comentario')
            </div>
        </div>
    </div>
</div>
