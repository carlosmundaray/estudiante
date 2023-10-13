<?php

namespace App\Http\Controllers;

use App\Models\Estudiantes;
use App\Models\Cursos;
use Illuminate\Http\Request;
use Inertia\Inertia;
use DB;

class EstudiantesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $estudiante = Estudiantes::select(DB::raw('count(cursos.id) as count, estudiantes.*'))
                    ->leftjoin('curso_estudiante','estudiantes.id','=','curso_estudiante.estudiantes_id')
                    ->leftjoin('cursos','cursos.id','=','curso_estudiante.cursos_id')
                    ->groupBy('estudiantes.id')->paginate(10);

        $curso = Cursos::all();

        $cursos_sele = Cursos::select('curso_estudiante.cursos_id','curso_estudiante.estudiantes_id')
        ->join('curso_estudiante','cursos.id','=','curso_estudiante.cursos_id')
        ->join('estudiantes','estudiantes.id','=','curso_estudiante.estudiantes_id')
        ->get();
        
        return Inertia::render('Estudiantes/Index', ['cursos'=>$curso,'estudiantes'=>$estudiante, 'cursos_sele'=>$cursos_sele,]);   
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
      //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate(['nombre'=>'required']);
        $checkedNames = $request->input('checkedNames');
        $estudiante = new Estudiantes($request->input());
        $estudiante->save();
        $estudiante->curso()->sync($checkedNames, ['estudiantes_id'=>$estudiante->id]);
        return redirect('estudiantes');
    }

    /**
     * Display the specified resource.
     */
    public function show(Estudiantes $estudiantes)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Estudiantes $estudiantes)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Estudiantes $estudiante)
    {
        $request->validate(['nombre'=>'required']);
        $checkedNames = $request->input('checkedNames');
        $estudiante->update($request->all());
        $estudiante->curso()->sync($checkedNames);
        return redirect('estudiantes');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Estudiantes $estudiante)
    {
        $estudiante->delete();
        return redirect('estudiantes');
    }
}
