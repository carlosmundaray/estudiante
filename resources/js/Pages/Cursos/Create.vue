<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, useForm } from '@inertiajs/vue3';
const form = useForm({
    nombre:'',
    horario:'',
    fecha_inicio:{type:Date},
    fecha_fin:{type:Date},
});
</script>

<template>
    <Head title="Crear Cursos" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Crear Cursos</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="p-4 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <form @submit.prevent="$event=>form.post(route('cursos.store'))" class="mt-6 space-y-6 max-w-xl">
                        <InputLabel for="nombre" value="Nombre"></InputLabel>
                        <TextInput id="nombre" v-model="form.nombre" type="text" autofocus required class="mt-1 block w-full"></TextInput>
                        <InputError :message="form.errors.nombre" class="mt-2"></InputError>

                        <InputLabel for="horario" value="Horario"></InputLabel>
                        <TextInput id="horario" v-model="form.horario" type="text" autofocus required class="mt-1 block w-full"></TextInput>
                        <InputError :message="form.errors.horario" class="mt-2"></InputError>

                        <InputLabel for="fecha_inicio" value="Fecha inicio"></InputLabel>
                        <TextInput id="fecha_inicio" v-model="form.fecha_inicio" type="datetime-local" autofocus required class="mt-1 block w-full"></TextInput>
                        <InputError :message="form.errors.fecha_inicio" class="mt-2"></InputError>

                        <InputLabel for="fecha_fin" value="Fecha fin"></InputLabel>
                        <TextInput id="fecha_fin" v-model="form.fecha_fin" type="datetime-local" autofocus required class="mt-1 block w-full"></TextInput>
                        <InputError :message="form.errors.fecha_fin" class="mt-2"></InputError>

                        <PrimaryButton :disabled="form.processing">
                            <i class="fa-solid fa-save"></i> Guardar
                        </PrimaryButton>
                    </form>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
