@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Gestion Reportes</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-lg-12">
                    @livewire('reporte.index')

                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    {{-- @livewireStyles --}}
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.5.2/css/buttons.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="/assets/toastr/toastr.css?v={{ env('VERSION_STYLE') }}">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script type="text/javascript" src="/assets/jquery.min.js?v={{ env('VERSION_STYLE') }}"></script>
    <script type="text/javascript" src="/assets/toastr/toastr.js?v={{ env('VERSION_STYLE') }}"></script>
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">

    <style type="text/css">
        {{-- You can add AdminLTE customizations here --}}
        /*
                                                            .card-header {
                                                                border-bottom: none;
                                                            }
                                                            .card-title {
                                                                font-weight: 600;
                                                            }
                                                            */
    </style>
    <style>
        .select2-container {
            width: 100% !important
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 2.5em;
            /* Ajusta esto según la altura del select */
            text-align: center;
        }

        .select2-container--default .select2-selection--single {
            height: calc(2.5em + 2px);
            /* Ajusta esto según la altura del select */
            display: flex;
            align-items: center;
        }

        table td {
            vertical-align: middle !important;
        }

        .dataTables_length select {
            height: 30px !important;
        }

        .dataTables_length label {
            margin-top: 1rem !important;
        }

        .table {
            border-collapse: collapse !important;
        }

        .c_red {
            color: rgb(250, 74, 74) !important;
        }

        .select2-container--default .select2-selection--multiple .select2-selection__choice {
            color: black !important;
            /* Cambiar el color del texto a negro */
        }
    </style>
@stop

{{-- @stack('modals') --}}
@section('modals')
    @include('modal.verReportes')
    @include('modal.rechazarReporte')
    @include('modal.comentario')
@endsection
@section('js')
    {{-- @livewireScripts --}}
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="//cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="//cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
    <script src="/js/show_alerts.js" type="text/javascript"></script>
    <script src="/js/jsuites.js" type="text/javascript"></script>
    <script src="/js/sweetalert2.min.js" type="text/javascript"></script>
    {{-- <script src="/js/fancybox4.js" type="text/javascript"></script> --}}
    <script src="/js/basic.js" type="text/javascript"></script>

    <!-- CDN Alpine.js -->
    {{-- <script src="/js/alpine.min.js" defer></script> --}}

    <script type="text/javascript" language="javascript"
        src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" language="javascript"
        src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.flash.min.js"></script>
    <script type="text/javascript" language="javascript"
        src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script type="text/javascript" language="javascript"
        src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script type="text/javascript" language="javascript"
        src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script type="text/javascript" language="javascript"
        src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
    {{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        Livewire.on('reporteCerrado', i => {
            try {
                $('#verReportes').modal('hide');
                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'Reporte enviado para aceptación!',
                    showConfirmButton: false,
                    timer: 1500
                })
            } catch (error) {
                console.log('Error alert', error);
            }
        })
    </script>

    <script>
        Livewire.on('rechazoReporte', i => {
            try {
                $('#rechazarReportes').modal('hide');
                Swal.fire({
                    position: 'top-end',
                    icon: 'warning',
                    title: 'Reporte rechazado!',
                    showConfirmButton: false,
                    timer: 1500
                })

            } catch (error) {
                console.log('Error alert', error);
            }
        })
    </script>
    <script>
        Livewire.on('updateReporte', i => {
            try {
                $('#verReportes').modal('hide');
                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'Reporte guardado con exito!',
                    showConfirmButton: false,
                    timer: 1500
                })
            } catch (error) {
                console.log('Error alert', error);
            }
        })
    </script>
    <script>
        Livewire.on('reporteFinalizado', i => {
            try {
                $('#verReportes').modal('hide');
                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'Reporte finalizado!',
                    showConfirmButton: false,
                    timer: 1500
                })
            } catch (error) {
                console.log('Error alert', error);
            }
        })
    </script>

@stop
