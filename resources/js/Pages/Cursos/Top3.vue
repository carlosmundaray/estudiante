<script setup>
import DangerButton from '@/Components/DangerButton.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import Swal from 'sweetalert2';
const props = defineProps({
    cursos: {type:Object}
});
const form = useForm({
    id: ''
});

const deleteCursos = (id,name) =>{
    const alert = Swal.mixin({
        buttonsStyling: true
    });
    alert.fire({
        title:'Esta seguro de Eliminar ('+name+') ?',
        icon:'question',
        showCancelButton:true,
        confirmButtonText:'<i class="fa-solid fa-check"></i> Confirmar',
        cancelButtonText:'<i class="fa-solid fa-ban"></i> Cancelar',
    }).then((result)=>{
        if(result.isConfirmed){
            form.delete(route('cursos.destroy',id));
        }
    });
}
</script>

<template>
    <Head title="Top3" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Top3</h2>
        </template>

        <div class="py-12">
            <div class="bg-white grid v-screen place-items-center">
                <table class="table-auto border border-gray-400">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="px-4 py-4">#</th>
                            <th class="px-4 py-4">Nombre</th>
                            <th class="px-4 py-4">Horario</th>
                            <th class="px-4 py-4">Fecha Inicio</th>
                            <th class="px-4 py-4">Fecha Fin</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="cur, i in cursos" :key="cur.id">
                            <td class="border border-gray-400 px-4 py-4">{{ i+1 }}</td>
                            <td class="border border-gray-400 px-4 py-4">{{ cur.nombre }}</td>
                            <td class="border border-gray-400 px-4 py-4">{{ cur.horario }}</td>
                            <td class="border border-gray-400 px-4 py-4">{{ cur.fecha_inicio }}</td>
                            <td class="border border-gray-400 px-4 py-4">{{ cur.fecha_fin }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
