
<h1>{{ $mode }} empleados</h1>

@if(count($errors)>0)
    <div class="alert alert-danger" role="alert">
        <ul>
            @foreach($errors->all() as $error)
                <li>
                    {{$error}}
                </li>
            @endforeach
        </ul>
    </div>
@endif
<div class="form-group mb-3">
    <label for="name">Nombre</label>
    <input type="text" name="name" id="name"' value="{{isset($empleado->name) ? $empleado->name : old('name')}}" class="form-control">
</div>

<div class="form-group mb-3">
    <label for="lastName">Apellido</label>
    <input type="text" name="lastName" id="lastName" value="{{isset($empleado->lastName) ? $empleado->lastName : old('lastName')}}" class="form-control">
</div>

<div class="form-group mb-3">
    <label for="email">Correo</label>
    <input type="text" name="email" id="email" value="{{isset($empleado->email) ? $empleado->email : old('email')}}" class="form-control">
</div>

<div class="form-group mb-3">
    <label for="photo">Foto de perfil</label>
    @if(isset($empleado->photo))
    <img src="{{ asset('storage').'/'.$empleado->photo }}" width="100" alt="Foto perfil" class="img-thumbnail img-fluid mb-3">
    @endif
    <input type="file" name="photo" id="photo" class="form-control">
</div>

@if($mode === "Crear")
<input type="submit" value="{{ $modeButton }} datos" class="btn btn-success ml-3">
@else
<input type="submit" value="{{ $mode }} datos" class="btn btn-success  mr-10">
@endif

<a href="{{ url('empleado') }}" class="btn btn-primary">Regresar</a>