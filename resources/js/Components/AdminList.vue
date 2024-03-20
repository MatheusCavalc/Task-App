<script setup>
const props = defineProps(['task', 'task_admins'])
</script>

<template>
    <div class="mx-4 mt-3 lg:mx-10">

        <div class="w-full">
            <div class="inline-flex items-center text-xl font-semibold text-gray-900 dark:text-white">
                Admin
            </div>

            <div class="">
                <p class="text-lg font-medium text-gray-900 truncate dark:text-white">
                    {{ task.user.name }}
                </p>
                <p class="text-base text-gray-500 truncate dark:text-gray-400">
                    {{ task.user.email }}
                </p>
            </div>
        </div>

        <ul class="w-full divide-y divide-gray-200 dark:divide-gray-700">
            <li v-for="editor in task_admins" :key="editor.id" class="py-3 sm:py-4">
                <div class="flex items-center space-x-4 rtl:space-x-reverse">
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-900 truncate dark:text-white">
                            {{ editor.user.name }}
                        </p>
                        <p class="text-sm text-gray-500 truncate dark:text-gray-400">
                            {{ editor.user.email }}
                        </p>
                    </div>
                    <div class="inline-flex items-center text-base font-semibold text-gray-900 dark:text-white">
                        Editor
                    </div>
                </div>
            </li>
        </ul>
    </div>
</template>
