<script setup>
import { router } from '@inertiajs/vue3';
import { reactive } from 'vue';

const props = defineProps(['task', 'categories'])

const emit = defineEmits(['closeForm']);

const form = reactive({
    name: props.task.name,
    description: props.task.description,
    status: props.task.status,
    category_id: props.task.category_id
})


function submit() {
    router.put(`/tasks/${props.task.id}`, form, { preserveScroll: true })
    emit('closeForm');
}

function deleteTask() {
    router.delete(route('tasks.destroy', props.task.id), { preserveScroll: true })
    emit('closeForm');
}

</script>

<template>
    <div class="flex items-center justify-start">
        <h3 class="text-2xl font-medium text-gray-700">Edit Task</h3>
    </div>
    <hr class="my-3">

    <form @submit.prevent="submit">
        <div class="mb-6">
            <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Task Name</label>
            <input type="text" id="name" v-model="form.name"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
        </div>

        <div class="mb-6">
            <label for="description" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Task
                Description</label>
            <input type="text" id="description" v-model="form.description"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
        </div>

        <div class="mb-6">
            <label for="status" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Task Status</label>
            <select id="status" v-model="form.status"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                <option selected>Choose a status</option>
                <option value="Aguardando">Aguardando</option>
                <option value="Em execucao">Em execucao</option>
                <option value="Concluida">Concluida</option>
            </select>
        </div>

        <div class="mb-6">
            <label for="category_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Task
                Category</label>
            <select id="category_id" v-model="form.category_id"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                <option selected>Choose a Category</option>
                <option v-for="category in categories" :key="category.id" :value="category.id">{{ category.name }}</option>
            </select>
        </div>

        <div class="flex justify-between">
            <button type="submit"
                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Submit</button>

            <button @click="deleteTask"
                class="text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800">Delete</button>
        </div>
    </form>
</template>
