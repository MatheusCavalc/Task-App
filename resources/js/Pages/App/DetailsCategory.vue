<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link, Head } from '@inertiajs/vue3';

const props = defineProps(['tasks']);

</script>

<template>
    <Head :title="`${tasks[0].category.name} Tasks`" />

    <AppLayout>
        <section class="p-4">
            <div>
                <p class="text-3xl">
                    {{ tasks[0].category.name }} Tasks
                </p>
            </div>

            <div class="mt-3">
                <div v-for="task in tasks" :key="task.id" class="mb-3">
                    <div
                        class="relative block max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
                        <Link :href="route('task.details', task.id)" class="">
                        <div class="relative">
                            <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">{{ task.name }}
                            </h5>
                            <p class="font-normal text-gray-700 dark:text-gray-400 my-2">{{ task.description }}</p>
                        </div>

                        <div class="flex gap-4 mt-2">
                            <p>{{ task.category_id }}</p><!-- task.created_at -->
                            <p class="text-gray-500">|</p>
                            <p><span class="px-3 bg-gray-200 rounded">{{ (task.subtasks).length }}</span> Subtasks</p>
                            <p class="text-gray-500">|</p>
                            <p>{{ task.category.name }}</p>
                        </div>
                        </Link>

                    </div>
                </div>
            </div>
        </section>
    </AppLayout>
</template>
