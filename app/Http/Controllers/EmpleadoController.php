<?php

namespace App\Http\Controllers;

use App\Models\Empleado;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Storage;

class EmpleadoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $datos["empleados"] = Empleado::paginate(3);
        return view("empleado.index", $datos);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("empleado.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //$datosEmpleados = request()->all();     // va a tener toda la informacion que le enviaron
        $campos = [
            "name" => "required | string | max:100",
            "lastName" => "required | string | max:100",
            "email" => "required | email",
            "photo" => "required | max:10000 | mimes:jpeg,png,jpg"
        ];

        $field = "campo";
        $required = "es requerido";


        $mensaje = [
            //"required" => "el :attribute es requerido",     para utilizar todos los atributos se puede ocupar :attribute
            "name.required" => "El ".$field ." nombre ". $required,
            "lastName.required" => "El " .$field." apellido " .$required,
            "email.required" => "El ".$field ." correo ". $required,
            "photo.required" => "La foto es requerida",
            "email.email" => "El formato del correo es invalido"
        ];

        $this->validate($request, $campos, $mensaje);

        $datosEmpleado = request()->except("_token");      //va a contener toda la informacion excepto el token

        //request es la consulta
        if($request->hasFile("photo")){
            $datosEmpleado["photo"] = $request->file("photo")->store("uploads", "public");      //lo almacena en la carpeta ubicada en la storage/app/public/uploads dejandolo como archivo imagen
        }

        Empleado::insert($datosEmpleado);
        //return response()->json($datosEmpleado);       //lo va a transformar en un formato json 
        return redirect("empleado")->with("mensaje", "Empleado agregado con exito");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Empleado  $empleado
     * @return \Illuminate\Http\Response
     */
    public function show(Empleado $empleado)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Empleado  $empleado
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $empleado = Empleado::findOrFail($id);
        return view("empleado.edit", compact("empleado"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Empleado  $empleado
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $campos = [
            "name" => "required | string | max:100",
            "lastName" => "required | string | max:100",
            "email" => "required | email",
        ];

        $field = "campo";
        $required = "es requerido";


        $mensaje = [
            //"required" => "el :attribute es requerido",     para utilizar todos los atributos se puede ocupar :attribute
            "name.required" => "El ".$field ." nombre ". $required,
            "lastName.required" => "El " .$field." apellido " .$required,
            "email.required" => "El ".$field ." correo ". $required,
            "email.email" => "El formato del correo es invalido"
        ];

        if($request->hasFile("photo")){
            $campos = ["photo" => "required | max:10000 | mimes:jpeg,png,jpg"];
            $mensaje = ["photo" => "required | max:10000 | mimes:jpeg,png,jpg"];
        }

        $this->validate($request, $campos, $mensaje);

        $datosEmpleado = request()->except(["_token", "_method"]); 
        
        if($request->hasFile("photo")){
            $empleado = Empleado::findOrFail($id);
            Storage::delete("public/".$empleado->photo);
            $datosEmpleado["photo"] = $request->file("photo")->store("uploads", "public");      //lo almacena en la carpeta ubicada en la storage/app/public/uploads dejandolo como archivo imagen
        }

        Empleado::where("id", "=", $id)->update($datosEmpleado);        //pregunta si coincide con la id, si lo encuentra le va hacer update 
        $empleado = Empleado::findOrFail($id);
        //return view("empleado.edit", compact("empleado"));      //finalmente lo vuelve a buscar, y retorna los datos en el formulario 
        return redirect("empleado")->with("mensaje", "Empleado Editado");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Empleado  $empleado
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $empleado = Empleado::findOrFail($id);
        if(Storage::delete("public/".$empleado->photo)){      //pregunta si ya se borro la imagen podra eliminar los datos del usuario
            Empleado::destroy($id);
        }
        return redirect("empleado")->with("mensaje", "Empleado borrado");
    }
}
