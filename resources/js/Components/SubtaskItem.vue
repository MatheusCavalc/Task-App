<script setup>
import { router } from '@inertiajs/vue3';
import axios from 'axios';
import { reactive } from 'vue';
import { ref } from 'vue';

const props = defineProps(['index', 'item', 'status', 'array'])

const emit = defineEmits(['editSubtask', 'deleteSubtask']);

const statusClasses = {
    'Waiting': 'p-3 border border-red-400 rounded-lg mb-1 flex justify-between',
    'In Progress': 'p-3 border border-yellow-400 rounded-lg mb-1 flex justify-between',
    'Finished': 'p-3 border border-blue-400 rounded-lg mb-1 flex justify-between',
};

const classes = ref(statusClasses[props.status] || '');

const edit = ref(false)

const form = reactive({
    name: props.item.name,
    task_id: props.item.task_id,
    status: props.item.status,
})

function submit() {
    axios.put(`/subtasks/${props.item.id}`, form, { preserveScroll: true })

    const subtask = {
        index: props.index,
        name: form.name,
        array: props.array
    }

    emit('editSubtask', subtask);

    edit.value = false
}

function deleteTask() {
    router.delete(route('subtasks.destroy', props.item.id), { preserveScroll: true })

    const subtask = {
        index: props.index,
        array: props.array
    }

    emit('deleteSubtask', subtask);
    edit.value = false
}
</script>

<template>
    <div :class="classes" v-if="!edit" @dblclick="edit = true">
        <p>
            {{ item.name }}
        </p>

        <button @click="edit = true">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                class="w-4 h-4">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125" />
            </svg>
        </button>
    </div>

    <div v-if="edit" class="">
        <form @submit.prevent="submit">
            <div class="mb-1 flex">
                <input type="text" id="name" placeholder="New Subtask" v-model="form.name" required
                    class="bg-gray-50 border border-gray-400 text-gray-900 rounded-l-lg border-r-0 w-full p-3">
                <span @click="edit = false"
                    class="cursor-pointer inline-flex items-center px-3 text-gray-900 bg-gray-50 border border-l-0 border-gray-400 rounded-r-0 dark:bg-gray-600 dark:text-gray-400 dark:border-gray-600">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-4 h-4 mt-0.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </span>
                <span @click="deleteTask"
                    class="cursor-pointer inline-flex items-center px-3 text-gray-900 bg-gray-50 border border-l-0 border-gray-400 rounded-r-lg dark:bg-gray-600 dark:text-gray-400 dark:border-gray-600">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                    </svg>
                </span>
            </div>
        </form>
    </div>
</template>
