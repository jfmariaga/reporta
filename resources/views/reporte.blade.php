@extends('layouts.app')
@section('title', 'Login')
@section('content')
    @livewire('reporte.create-reporte')
@endsection
@section('css')
@endsection
@section('js')
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        Livewire.on('ok_reporte', i => {
            try {
                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'Reporte generado con exito!',
                    showConfirmButton: false,
                    timer: 1500
                })
            } catch (error) {
                console.log('Error alert', error);
            }
        })
    </script>
@endsection
