<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Persona;

class PersonaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
     //  if(!$request->ajax()) return redirect('/');
       $buscar = $request->buscar;
       $criterio = $request->criterio;
       if($buscar==''){
        $personas = Persona::orderBy('id', 'desc')->paginate(2);
       }else{
        $personas = Persona::where($criterio,'like', '%'. $buscar . '%')->orderBy('id', 'desc')->paginate(2);
       }
        

        return [
            'pagination' => [
                'total' => $personas->total(),
                'current_page' => $personas->currentPage(),
                'per_page' => $personas->perPage(),
                'last_page' => $personas->lastPage(),
                'from' => $personas->firstItem(),
                'to' => $personas->lastItem(),
            ],
            'personas' => $personas
        ];
    }

    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $persona = new Persona();
        $persona->nombre = $request->nombre;
        $persona->apellido = $request->apellido;
        $persona->rut = $request->rut;
        $persona->cargo = $request->cargo;
        $persona->direccion = $request->direccion;
        $persona->email = $request->email;
        $persona->fono = $request->fono;
        $persona->save();

    }

    

    

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $persona = Persona::findOrFail($request->id);
        $persona->nombre = $request->nombre;
        $persona->apellido = $request->apellido;
        $persona->rut = $request->rut;
        $persona->cargo = $request->cargo;
        $persona->direccion = $request->direccion;
        $persona->email = $request->email;
        $persona->fono = $request->fono;
        $persona->save();

    }
   

   
}
