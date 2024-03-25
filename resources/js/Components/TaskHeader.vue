<script setup>
import DetailsMenuDropdown from '@/Components/DetailsMenuDropdown.vue'
import moment from 'moment';

const props = defineProps(['task', 'task_admins'])
</script>

<template>
    <div class="p-4 mt-2 lg:p-0">
        <div class="flex justify-between lg:space-y-2">
            <p class="text-xl lg:text-3xl">
                {{ task.name }}
            </p>

            <div>
                <DetailsMenuDropdown :task="props.task" :task_admins="task_admins" />
            </div>
        </div>

        <hr class="my-3">

        <div class="flex gap-1 mt-2 text-lg">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="w-5 h-5 mt-1">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M9.568 3H5.25A2.25 2.25 0 003 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 005.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 009.568 3z" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6z" />
            </svg>
            <p>
                {{ task.category.name }}
            </p>
        </div>
        <div class="flex gap-1 mt-2 text-lg">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="w-5 h-5 mt-1">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
            </svg>
            <p>
                {{ moment(task.created_at).utc().format('DD MMM') }}
            </p>
        </div>

    </div>
</template>
