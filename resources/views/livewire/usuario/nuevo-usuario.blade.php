<div>
    <div class="modal-body">
        <div class="row">
            <fieldset class="form-group floating-label-form-group col-lg-6 col-12">
                <label for="">Nombre</label>
                <input type="text" class="form-control  @error('nombre') border_error @enderror" placeholder="Nombre"
                    wire:model="name">
                @error('name') <span class="input_error error text-danger">{{ $message }}</span> @enderror
            </fieldset>
            <br>
            <fieldset class="form-group floating-label-form-group col-lg-6 col-12">
                <label>Rol</label>
                <select wire:model.defer="role_id" @error('rol_id') border_error @enderror class="form-control">
                    <option selected>Seleccionar...</option>
                    @foreach ($roles as $item)
                        <option value="{{ $item->name }}"> {{ $item->name }} </option>
                    @endforeach
                </select>
                @error('rol_id') <span class="input_error error text-danger">{{ $message }}</span> @enderror
            </fieldset>
            <br>
            <fieldset class="form-group floating-label-form-group col-lg-6 col-12">
                <label for="">Correo</label>
                <input type="email" class="form-control @error('email') border_error @enderror" placeholder="Correo"
                    wire:model="email">
                @error('email') <span class="input_error error text-danger">{{ $message }}</span> @enderror
            </fieldset>
            <br>
            <fieldset class="form-group floating-label-form-group col-lg-6 col-12">
                <label>Contraseña</label>
                <input type="{{ $type }}" class="form-control @error('password') border_error @enderror"
                    placeholder="Contraseña" wire:model="password">
                @error('password') <span class="input_error error text-danger">{{ $message }}</span> @enderror
            </fieldset>
            <br>
            <fieldset class="form-group floating-label-form-group col-lg-6 col-12">
                <label>Confirmar contraseña</label>
                <input type="{{ $type }}" class="form-control @error('confiPassword') border_error @enderror"
                    placeholder="Contraseña" wire:model="confiPassword">
                @error('confiPassword') <span class="input_error error text-danger">{{ $message }}</span> @enderror
            </fieldset>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <fieldset class="form-group floating-label-form-group col-lg-6 col-12">
                    <span style="float: inline-star;">
                        <label for="ver_contrasena" style="font-weight:normal !important;">
                            <input type="checkbox" name="ver_contrasena" id="ver_contrasena" wire:click="verContrasena()"
                                wire:model="ver_contrasena">
                            Ver contraseña
                        </label>
                    </span>
                </fieldset>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <input type="submit" class="btn btn-outline-primary btn-sm" wire:click="guardar()" value="Guardar">
        <input type="reset" class="btn btn-outline-danger btn-sm" data-dismiss="modal" wire:click="resetear()"
        value="Cancelar">
    </div>
</div>

