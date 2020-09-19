<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Situacion;

class SituacionController extends Controller
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
        $situaciones = Situacion::orderBy('id', 'desc')->paginate(2);
       }else{
        $situaciones = Situacion::where($criterio,'like', '%'. $buscar . '%')->orderBy('id', 'desc')->paginate(2);
       }
        

        return [
            'pagination' => [
                'total'         => $situaciones->total(),
                'current_page'  => $situaciones->currentPage(),
                'per_page'      => $situaciones->perPage(),
                'last_page'     => $situaciones->lastPage(),
                'from'          => $situaciones->firstItem(),
                'to'            => $situaciones->lastItem(),
            ],
            'situaciones'       => $situaciones
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
      //  if(!$request->ajax()) return redirect('/');
        $situacion = new Situacion();
        $situacion->situacion = $request->situacion;        
        $situacion->save();
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
        $situacion = Situacion::findOrFail($request->id);
        $situacion->situacion = $request->situacion;       
        $situacion->save();
    }
}
