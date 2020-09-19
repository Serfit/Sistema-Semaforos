<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\ComandoRemoto;

class ComandoRemotoController extends Controller
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
         $comandos = ComandoRemoto::orderBy('id', 'desc')->paginate(2);
        }else{
         $comandos = ComandoRemoto::where($criterio,'like', '%'. $buscar . '%')->orderBy('id', 'desc')->paginate(2);
        }
         
         return [
             'pagination' => [
                 'total' => $comandos->total(),
                 'current_page' => $comandos->currentPage(),
                 'per_page' => $comandos->perPage(),
                 'last_page' => $comandos->lastPage(),
                 'from' => $comandos->firstItem(),
                 'to' => $comandos->lastItem(),
             ],
             'comandos' => $comandos
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
        $comando = new ComandoRemoto();
        $comando->comando = $request->comando;        
        $comando->save();
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
        $comando = ComandoRemoto::findOrFail($request->id);
        $comando->comando = $request->comando;        
        $comando->save();
    }

}
