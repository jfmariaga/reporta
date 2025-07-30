@extends('layouts.app')
@section('title', 'Login')
@section('content')
    <div class="container-fluid">
        <div class="card">
            @livewire('consultar.consultar')
        </div>
    </div>
@endsection
@section('css')
@endsection

@push('modals')
    @include('modal.verReportes')
    @include('modal.rechazarConsulta')
    @include('modal.comentario')
@endpush

@section('js')

@endsection
