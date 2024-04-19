<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAlumnoRequest;
use App\Http\Requests\UpdateAlumnoRequest;
use App\Models\Alumno;

class AlumnoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $alumnos = Alumno::all();
        return view("alumnos.alumno",["alumnos"=>$alumnos]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view("alumnos.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAlumnoRequest $request)
    {
        //
        $datos = $request->input();
        $alumno = new Alumno ($datos);
        info("Alumno: ".$alumno);
        $alumno->save();
//        return redirect(route("alumnos.index"));
        $alumnos = Alumno::all();
        return view("alumnos.alumno",["alumnos"=>$alumnos]);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        //
        $alumno= Alumno::find($id);
        return view ("alumnos.edit", ['alumno'=>$alumno]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Alumno $alumno)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAlumnoRequest $request, int $id)
    {
        $alumno = Alumno::find($id);
        $alumno->update($request->input());
        $alumnos = Alumno::all();
        return view("alumnos.alumno",["alumnos"=>$alumnos]);
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $alumno = Alumno::find($id);
        $alumno->delete();
        $alumnos = Alumno::all();
        return view("alumnos.alumno",["alumnos"=>$alumnos]);
        //
    }
}
