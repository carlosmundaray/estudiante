<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estudiantes extends Model
{
    use HasFactory;
    protected $fillable = ['nombre','apellido','edad','correo'];


//Relationships Many to Many
public function curso(){
    return $this->belongsToMany(Cursos::class, 'curso_estudiante');
}


}
