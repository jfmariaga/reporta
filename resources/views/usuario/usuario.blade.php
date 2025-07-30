@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Usuarios</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-lg-12 ">
                    <div class="float-right">
                        <a href="#" class="btn btn-sm btn-outline-success" data-toggle="modal" data-target="#nuevoUsuario">Nuevo Usuario</a>
                    </div>
                </div>
                <br>
                <br>
                <div class="col-lg-12">
                    @livewire('usuario.usuario')
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    @livewireStyles

@stop

@stack('modals')
@section('js')
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @livewireScripts
    <script>
        Livewire.on('usuario_ok', i => {
            try {
                $('#nuevoUsuario').modal('hide');

                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'Nuevo usuario',
                    showConfirmButton: false,
                    timer: 1500
                })
            } catch (error) {
                console.log('Error alert', error);
            }
        })
    </script>
    <script>
        livewire.on('contraseña', i => {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'las contraseñas no coinciden',
            });
        })
    </script>
    <script>
        Livewire.on('editar', i => {
            try {
                $('#editUsuario').modal('hide');

                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'Usuario editado',
                    showConfirmButton: false,
                    timer: 1500
                })
            } catch (error) {
                console.log('Error alert', error);
            }
        })
    </script>
@endsection
