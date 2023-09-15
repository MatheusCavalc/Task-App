<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps(['task']);

console.log(props.task)
</script>

<template>
    <AppLayout>
        <div>
            <p class="text-3xl">
                {{ task.name }}
            </p>
        </div>

        <div class="mt-20 grid grid-cols-3">

            <div>
                <div class="flex justify-center">
                    <p>Aguardando</p>
                </div>
                <div v-for="subtasks in task.subtasks">
                    <div v-if="subtasks.status === 'Aguardando'">
                        {{ subtasks.name }}
                    </div>
                </div>
            </div>

            <div>
                <div class="flex justify-center">
                    <p>Em execucao</p>
                </div>
                <div v-for="subtasks in task.subtasks">
                    <div v-if="subtasks.status === 'Em execucao'">
                        {{ subtasks.name }}
                    </div>
                </div>
            </div>

            <div>
                <div class="flex justify-center">
                    <p>Concluida</p>
                </div>
                <div v-for="subtasks in task.subtasks">
                    <div v-if="subtasks.status === 'Concluida'">
                        {{ subtasks.name }}
                    </div>
                </div>
            </div>

        </div>

    </AppLayout>
</template>
