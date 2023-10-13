<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Cursos;
use App\Models\Estudiantes;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
       /* \App\Models\Cursos::factory(6)->create();
        \App\Models\Estudiantes::factory(25)->create();*/

        //Se crean 15 estudiantes
        Estudiantes::factory()->times(15)->create();
        //Se crean 8 cursos
        Cursos::factory()->times(8)->create()->each(function($curso){
            $curso->estudiante()->sync(
                //Cada curso es tomado por 3 estudiantes
                Estudiantes::all()->random(3)
            );
        });



    }
}
