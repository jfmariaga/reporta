@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Localizaciones</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-lg-12">
                    @livewire('area.area-new')
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    @livewireStyles
    <link rel="stylesheet" href="/css/admin_custom.css">
    {{-- <link rel="stylesheet" href="{{ asset('mask_jf/datatables/css/jquery.dataTables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('mask_jf/datatables/css/buttons.dataTables.min.css') }}"> --}}
@stop
@stack('modals')

@section('js')
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @livewireScripts
    <script>
        Livewire.on('ok_area', i => {
            try {
                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'Nueva localización',
                    showConfirmButton: false,
                    timer: 1500
                })
            } catch (error) {
                console.log('Error alert', error);
            }
        })
    </script>

@stop
