<script setup>
import DangerButton from '@/Components/DangerButton.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import WarningButton from '@/Components/WarningButton.vue';
import SelectInput from '@/Components/SelectInput.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import Modal from '@/Components/Modal.vue';
import { Head, useForm} from '@inertiajs/vue3';
import { nextTick , ref } from 'vue';
import Swal from 'sweetalert2';
import vueTailwindPaginationUmd from '@ocrv/vue-tailwind-pagination';
import checkbox from '@/Components/Checkbox.vue';

const nameInput = ref(null);
const modal = ref(false);
const title = ref('');
const operation = ref(1);
const id = ref('');
const checkedNames = ref([]);

const props = defineProps({
    estudiantes: {type:Object},
    cursos: {type:Object},
    cursos_sele: {type:Object}
});



const form = useForm({
    nombre: '',
    apellido: '',
    edad: '',
    correo: '',
    checkedNames: [],
});

const formPage = useForm({});

const onPageClick=(event)=>{
    formPage.get(route('estudiantes.index',{page:event}));
};

const openModal=async (op,nombre,apellido,edad,correo,curso_id,estudiante_id)=>{
    modal.value=true;
    nextTick(() => nameInput.value.focus());
    operation.value = op;
    id.value = estudiante_id;
    if(op==1){
        title.value='Crear Estudiante';
        form.checkedNames=checkedNames;
    }else{
        title.value='Editar Estudiante';
        form.nombre=nombre;
        form.apellido=apellido;
        form.edad=edad;
        form.correo=correo;
        form.checkedNames=checkedNames;

        let setteo=[];
        for(let curs in props.cursos_sele){
            if(props.cursos_sele[curs].estudiantes_id==estudiante_id){
                setteo.push(props.cursos_sele[curs].cursos_id);
            }
        }
        checkedNames.value=setteo;
        

    }
};

const closeModal=()=>{
    modal.value=false;
    form.reset();
};

const save=()=>{
    if(operation.value==1){

        form.post(route('estudiantes.store'),{
            onSuccess: ()=>{ok('Estudiante creado')},
        });

    }else{
        form.put(route('estudiantes.update',id.value),{
            onSuccess: ()=>{ok('Estudiante actualizado')},
        });
    }
};

const ok=(msj)=>{
    form.reset();
    if(operation.value!=1){closeModal();}
    Swal.fire({title:msj, icon:'success'});
};

const EliminarEstudiantes = (id,name) =>{
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
            form.delete(route('estudiantes.destroy',id),{
                onSuccess: ()=>{ok('Estudiante eliminado')},
            });
        }
    });
}
</script>

<template>
    <Head title="Estudiantes" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Estudiantes</h2>
        </template>

        <div class="py-12">
            <div class="bg-white grid v-screen place-items-center">
                <div class="mt-3 mb-3 flex">
                <PrimaryButton @click="$event=>openModal(1)">
                    <i class="fa-solid fa-plus-circle"></i> Crear
                </PrimaryButton>
                </div>
            </div>
            <div class="bg-white grid v-screen place-items-center">
                <table class="table-auto border border-gray-400">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="px-4 py-4">#</th>
                            <th class="px-4 py-4">Nombre</th>
                            <th class="px-4 py-4">Apellido</th>
                            <th class="px-4 py-4">Edad</th>
                            <th class="px-4 py-4">Correo</th>
                            <th class="px-4 py-4">Cursos asociados</th>
                            <th class="px-4 py-4"></th>
                            <th class="px-4 py-4"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="est, i in estudiantes.data" :key="est?.id">
                            <td class="border border-gray-400 px-4 py-4">{{ i+1 }}</td>
                            <td class="border border-gray-400 px-4 py-4">{{ est.nombre }}</td>
                            <td class="border border-gray-400 px-4 py-4">{{ est.apellido }}</td>
                            <td class="border border-gray-400 px-4 py-4">{{ est.edad }}</td>
                            <td class="border border-gray-400 px-4 py-4">{{ est.correo }}</td>
                            <td class="border border-gray-400 px-4 py-4">{{ est.count }}</td>
                            <td class="border border-gray-400 px-4 py-4">
                                <WarningButton @click="$event=>openModal(2,est.nombre,est.apellido,est.edad,est.correo,est.curso_id,est.id)">
                                    <i class="fa-solid fa-edit"></i>
                                </WarningButton>
                            </td>
                            <td class="border border-gray-400 px-4 py-4">
                                <DangerButton @click="$event => EliminarEstudiantes(est.id,est.nombre)">
                                    <i class="fa-solid fa-trash"></i>
                                </DangerButton>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="bg-white grid v-screen place-items-center">
                <vueTailwindPaginationUmd
                   :current="estudiantes.currentPage" :total="estudiantes.total"
                   :per-page="estudiantes.perPage"
                   @page-changed="$event=>onPageClick($event)"
                ></vueTailwindPaginationUmd>
            </div>
        </div>
        <modal :show="modal" @close="closeModal">
            <h2 class="p-3 text-lg font.medium text-hray-900">{{ title }}</h2>
            <div class="p-3">
                <InputLabel for="nombre" value="Nombre"></InputLabel>
                <TextInput id="nombre" v-model="form.nombre" ref="nameInput" type="text" class="mt-1 block w-3/4"></TextInput>
                <InputError :message="form.errors.nombre" class="mt-2"></InputError>
            </div>
            <div class="p-3">
                <InputLabel for="apellido" value="Apellido"></InputLabel>
                <TextInput id="apellido" v-model="form.apellido" type="text" class="mt-1 block w-3/4"></TextInput>
                <InputError :message="form.errors.apellido" class="mt-2"></InputError>
            </div>
            <div class="p-3">
                <InputLabel for="edad" value="Edad"></InputLabel>
                <TextInput id="edad" v-model="form.edad" type="text" class="mt-1 block w-3/4"></TextInput>
                <InputError :message="form.errors.edad" class="mt-2"></InputError>
            </div>
            <div class="p-3">
                <InputLabel for="correo" value="Correo"></InputLabel>
                <TextInput id="correo" v-model="form.correo" type="text" class="mt-1 block w-3/4"></TextInput>
                <InputError :message="form.errors.correo" class="mt-2"></InputError>
            </div>
            <div class="p-3">
                <h2><b>Asignar curso</b></h2>
                <table class="table-auto border border-gray-400">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="px-4 py-4">#</th>
                            <th class="px-4 py-4">Nombre</th>
                            <th class="px-4 py-4"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="cur, i in cursos" :key="cur?.id">
                            <td class="border border-gray-400 px-4 py-4">{{ i+1 }}</td>
                            <td class="border border-gray-400 px-4 py-4">{{ cur.nombre }}</td>
                            <td class="border border-gray-400 px-4 py-4">
                                <input type="checkbox" id=""  :value="cur.id" v-model="checkedNames">
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="p-3 mt-6">
                <PrimaryButton :disabled="form.processing" @click="save">
                    <i class="fa-solid fa-save"></i> Guardar
                </PrimaryButton>
                <SecondaryButton :disabled="form.processing" class="ml-3" @click="closeModal">
                    Cancelar
                </SecondaryButton>
            </div>
        </modal>
    </AuthenticatedLayout>
</template>
