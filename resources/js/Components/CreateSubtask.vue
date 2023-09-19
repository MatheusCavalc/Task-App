<script setup>
import { router } from '@inertiajs/vue3';
import axios from 'axios';
import { reactive } from 'vue';
import { ref } from 'vue';

const props = defineProps(['status', 'task_id'])

const emit = defineEmits(['updateColumn']);

const create = ref(false)

const form = reactive({
    //user_id: on controller,
    name: null,
    task_id: props.task_id,
    status: props.status,
})

function submit() {
    if (form.status === null) {
        form.status = props.status;
        form.task_id = props.task_id
    }

    axios.post('/subtasks', form).then((response) => {
        emit('updateColumn', response.data);
    })

    form.name = null
    form.task_id = null
    form.status = null

    create.value = false
}
</script>

<template>
    <div v-show="!create" @click="create = true"
        class="p-3 rounded-lg mb-1 flex gap-2 text-gray-400 cursor-pointer">
        <p>
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                class="w-5 h-5 mt-0.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
            </svg>
        </p>
        <p class="">Add Subtask</p>
    </div>

    <div v-show="create">
        <form @submit.prevent="submit">
            <div class="mb-1 flex">
                <input type="text" id="name" v-model="form.name" placeholder="New Subtask"
                    class="bg-gray-50 border border-gray-400 text-gray-900 rounded-l-lg border-r-0 w-full p-3">
                <span @click="create = false"
                    class="cursor-pointer inline-flex items-center px-3 text-gray-900 bg-gray-50 border border-l-0 border-gray-400 rounded-r-lg dark:bg-gray-600 dark:text-gray-400 dark:border-gray-600">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-6 h-6 mt-0.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </span>
            </div>
        </form>
    </div>
</template>
