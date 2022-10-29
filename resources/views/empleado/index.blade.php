@extends('layouts.app')
@section('content')
<div class="container">
    
        @if(Session::has("mensaje"))
        <div class="alert alert-success alert-dismissible" role="alert">
            {{ Session::get("mensaje") }}
        </div>
        @endif
    

    <a href="{{ url('empleado/create') }}" class="btn btn-success">Registrar nuevo empleado</a>
    <br>
    <br>
    <table class="table table-light">
        <thead class="thead-light">
            <tr>
                <th>#</th>
                <th>Foto</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Correo</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($empleados  as $em)
            <tr>
                <td>{{$em->id}}</td>
                <td>
                    <img src="{{ asset('storage').'/'.$em->photo }}"  width="100" alt="foto perfil" class="img-thumbnail img-fluid">
                </td>
                <td>{{$em->name}}</td>
                <td>{{$em->lastName}}</td>
                <td>{{$em->email}}</td>
                <td>
                    
                <a href="{{ url('/empleado/'.$em->id.'/edit') }}" class="btn btn-warning">
                    Editar
                </a>
                | 
                    <form action="{{ url('/empleado/'.$em->id) }}" method="post" class="d-inline">
                        @csrf
                        {{ method_field('DELETE') }}
                        <input type="submit" onclick="return confirm('¿Quieres borrar?')" value="Borrar" class="btn btn-danger">
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {!!$empleados->links()!!}
</div>
@endsection

