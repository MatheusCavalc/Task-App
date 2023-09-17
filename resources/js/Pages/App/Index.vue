<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps(['user']);
</script>

<template>
    <AppLayout>
        <div>
            <p class="text-3xl">
                My Tasks
            </p>
        </div>

        <div class="mt-10">

            <div v-for="task in user.tasks">
                <Link :href="route('task.details', task.id)"
                    class="block max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
                <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">{{ task.name }}</h5>
                <p class="font-normal text-gray-700 dark:text-gray-400">{{ task.description }}</p>
                </Link>
            </div>

        </div>

    </AppLayout>
</template>
