<?php

Route::get('/', function () {
    return view('contenido/contenido');
});

Route::get('/persona', 'PersonaController@index');
Route::post('/persona/registrar', 'PersonaController@store');
Route::put('/persona/actualizar', 'PersonaController@update');

Route::get('/comandoremoto', 'ComandoRemotoController@index');
Route::post('/comandoremoto/registrar', 'ComandoRemotoController@store');
Route::put('/comandoremoto/actualizar', 'ComandoRemotoController@update');

Route::get('/situacion', 'SituacionController@index');
Route::post('/situacion/registrar', 'SituacionController@store');
Route::put('/situacion/actualizar', 'SituacionController@update');

Route::get('/incidente', 'TipoIncidenteController@index');
Route::post('/incidente/registrar', 'TipoIncidenteController@store');
Route::put('/incidente/actualizar', 'TipoIncidenteController@update');