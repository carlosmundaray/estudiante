<?php

namespace App\Http\Controllers;

use App\Models\Estudiantes;
use App\Models\Cursos;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Carbon\Carbon;
use DB;

class CursosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cursos = Cursos::select(DB::raw('count(estudiantes.id) as count'),'cursos.id','curso_estudiante.cursos_id', 'cursos.nombre', 'cursos.horario', 'cursos.fecha_inicio', 'cursos.fecha_fin')
        ->leftjoin('curso_estudiante', 'curso_estudiante.cursos_id','=','cursos.id')
        ->leftjoin('estudiantes', 'curso_estudiante.estudiantes_id','=','estudiantes.id')
        ->groupBy('cursos.id','curso_estudiante.cursos_id')
        ->get();
        return Inertia::render('Cursos/Index', ['cursos'=>$cursos]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Cursos/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate(['nombre'=>'required']);
        $cursos = new Cursos($request->input());
        $cursos->save();
        return redirect('cursos');
    }

    /**
     * Display the specified resource.
     */
    public function show(Cursos $curso)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cursos $curso)
    {
        return Inertia::render('Cursos/Edit', ['curso'=>$curso]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Cursos $curso)
    {
        $request->validate(['nombre'=>'required']);
        $curso->update($request->all());
        return redirect('cursos');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cursos $curso)
    {
        $curso->delete();
        return redirect('cursos');
    }

    /**
     * Display a listing of the resource.
     */
    public function top3()
    {

        // get the current time
        $current = Carbon::now();
        $y = $current->subMonths(6)->format('Y');
        $m=6;

        $cursos = Cursos::select(DB::raw('count(estudiantes.id) as count'),'cursos.id','curso_estudiante.cursos_id', 'cursos.nombre', 'cursos.horario', 'cursos.fecha_inicio', 'cursos.fecha_fin')
        ->leftjoin('curso_estudiante', 'curso_estudiante.cursos_id','=','cursos.id')
        ->leftjoin('estudiantes', 'curso_estudiante.estudiantes_id','=','estudiantes.id')
        ->whereMonth('cursos.fecha_inicio', '<=', $m)
        ->whereYear('cursos.fecha_inicio', '=', $y)
        ->groupBy('cursos.id','curso_estudiante.cursos_id')
        ->orderBy('cursos.fecha_inicio', 'asc')
        ->get();
        return Inertia::render('Cursos/Top3', ['cursos'=>$cursos]);
    }


}
