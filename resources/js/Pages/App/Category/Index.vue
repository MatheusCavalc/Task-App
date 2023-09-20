<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps(['categories'])
</script>

<template>
    <AppLayout>
        <div class="">
            <div class="">
                <div class="">

                    <div>
                        <p class="text-3xl">
                            My Categories
                        </p>
                    </div>

                    <Link :href="route('categories.create')"
                        class="mt-2 flex gap-2 cursor-pointer p-3 border border-gray-200 max-w-sm rounded">
                    <p>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-5 h-5 mt-0.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                    </p>
                    <p class="text-md">Create New Category</p>
                    </Link>

                    <div v-for="category in categories" :key="category.id"
                        class="mt-2 flex gap-2 cursor-pointer p-3 border-b border-gray-200 max-w-sm rounded justify-between">
                        <Link :href="route('task.details.category', category.id)">
                        <p>{{ category.name }}</p>
                        </Link>

                        <Link :href="route('categories.edit', category.id)">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />

                        </svg>
                        </Link>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
