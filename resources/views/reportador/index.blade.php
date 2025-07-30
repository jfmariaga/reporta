@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Gestiona a tus reportadores</h1>
@stop

@section('content')
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-lg-12 ">
                <div class="float-right">
                    <a href="#" class="btn btn-sm btn-outline-success" data-toggle="modal"
                        data-target="#newReportador"><i class="fa fa-plus"></i></a>
                </div>
            </div>
            <br>
            <br>
            <div class="col-lg-12">
                @livewire('reportador.index')
            </div>
        </div>
    </div>
</div>
@stop

@section('css')
    @livewireStyles
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop
@stack('modals')

@section('js')
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@livewireScripts

<script>
    Livewire.on('ok_reportador', i => {
        try {
            $('#newReportador').modal('hide');
            Swal.fire({
                position: 'top-end',
                icon: 'success',
                title: 'Nueva registro!',
                showConfirmButton: false,
                timer: 1500
            })
        } catch (error) {
            console.log('Error alert', error);
        }
    })
</script>
<script>
    Livewire.on('edit_reportador', i => {
        try {
            $('#editReportador').modal('hide');
            Swal.fire({
                position: 'top-end',
                icon: 'success',
                title: 'Reportador modificado con exito!',
                showConfirmButton: false,
                timer: 1500
            })
        } catch (error) {
            console.log('Error alert', error);
        }
    })
</script>
@stop
