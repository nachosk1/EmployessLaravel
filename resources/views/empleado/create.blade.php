@extends('layouts.app')

@section('content')
<div class="container">
    <!-- con el ectype permite enviar una imagen -->
    <form action="{{ url('/empleado') }}" method="post" enctype="multipart/form-data">
        @csrf <!-- permite identificar la llave de seguridad, permitiendo responder enviandole la informacion  al metodo store -->
        @include("empleado.form", ["mode" => "Crear", "modeButton" => "Guardar"])
    </form>
</div>
@endsection

