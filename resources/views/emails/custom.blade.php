@extends('emails.layouts.base')

@section('icon', '✉️')
@section('title', 'Mensaje Personalizado')

@section('content')
    <div class="greeting">
        ¡Hola!
    </div>

    <div class="content-text">
        {!! nl2br(e($content)) !!}
    </div>

    @if($actionUrl && $actionText)
        <div class="button-container">
            <a href="{{ $actionUrl }}" class="button">
                {{ $actionText }}
            </a>
        </div>
    @endif

    <div class="content-text">
        Gracias por usar nuestro Sistema de Inventario.
    </div>
@endsection
