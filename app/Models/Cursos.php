<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cursos extends Model
{
    use HasFactory;
    protected $fillable = ['nombre','horario','fecha_inicio','fecha_fin'];

    public function estudiante(){
        return $this->belongsToMany(Estudiantes::class, 'curso_estudiante');
    }
}
