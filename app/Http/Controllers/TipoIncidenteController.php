<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\TipoIncidente;

class TipoIncidenteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $buscar = $request->buscar;
        $criterio = $request->criterio;
        if($buscar==''){
         $incidentes = TipoIncidente::orderBy('id', 'desc')->paginate(2);
        }else{
         $incidentes = TipoIncidente::where($criterio,'like', '%'. $buscar . '%')->orderBy('id', 'desc')->paginate(2);
        }
         
 
         return [
             'pagination' => [
                 'total' => $incidentes->total(),
                 'current_page' => $incidentes->currentPage(),
                 'per_page' => $incidentes->perPage(),
                 'last_page' => $incidentes->lastPage(),
                 'from' => $incidentes->firstItem(),
                 'to' => $incidentes->lastItem(),
             ],
             'incidentes' => $incidentes
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
        $incidente = new TipoIncidente();
        $incidente->tipo_incidente = $request->tipo_incidente;
        $incidente->save();
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
        $incidente =  TipoIncidente::findOrFail($request->id);
        $incidente->tipo_incidente = $request->tipo_incidente;
        
        $incidente->save();
    }

    
}
