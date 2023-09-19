<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import CreateTaskForm from '@/Components/CreateTaskForm.vue';
import EditTaskForm from '@/Components/EditTaskForm.vue'
import { Link } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps(['tasks', 'categories', 'task_status']);

const showModal = ref(false)
const createTask = ref(false)
const editTask = ref(false)
const taskToEdit = ref([])

const openCreateForm = () => {
    showModal.value = true
    createTask.value = true
    editTask.value = false
}

const openEditForm = (task) => {
    if (editTask.value == true) {
        editTask.value == false

        showModal.value = true
        createTask.value = false
        editTask.value = true
        taskToEdit.value = task
    } else {
        showModal.value = true
        createTask.value = false
        editTask.value = true
        taskToEdit.value = task
    }
}

const closeModal = () => {
    showModal.value = false
    createTask.value = false
    editTask.value = false
    taskToEdit.value = []
}

</script>

<template>
    <AppLayout>
        <div>
            <p class="text-3xl">
                My Tasks
            </p>
        </div>

        <div @click="openCreateForm" class="mt-2 flex group gap-2 cursor-pointer p-3 border border-gray-200 hover:bg-black max-w-md rounded">
            <p>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-5 h-5 mt-0.5 group-hover:stroke-white">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
            </p>
            <p class="text-md group-hover:text-white">Create New Task</p>
        </div>

        <div class="mt-3">
            <div v-for="task in tasks" :key="task.id" class="mb-3">
                <div
                    class="relative group block max-w-md p-4 bg-white border border-gray-200 rounded-lg shadow hover:bg-black hove:text-white">
                    <Link :href="route('task.details', task.id)" class="">
                    <div class="relative">
                        <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 group-hover:text-white">{{ task.name }}
                        </h5>
                        <p class="font-normal text-gray-700 group-hover:text-white my-2">{{ task.description }}</p>
                    </div>

                    <div class="flex gap-4 mt-2">
                        <p class="group-hover:text-white">{{ task.formatted_created_at }}</p><!-- task.created_at -->
                        <p class="text-gray-500 group-hover:text-white">|</p>
                        <p class="group-hover:text-white"><span class="px-3 bg-gray-200 rounded group-hover:bg-white group-hover:text-black">{{ (task.subtasks).length }}</span> Subtasks</p>
                        <p class="text-gray-500 group-hover:text-white">|</p>
                        <p class="group-hover:text-white">{{ task.category.name }}</p>
                        <p class="text-gray-500 group-hover:text-white">|</p>
                        <p class="group-hover:text-white">{{ task.status }}</p>
                    </div>
                    </Link>

                    <div class="absolute top-5 right-4">
                        <button @click="openEditForm(task)">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="w-5 h-5 group-hover:stroke-white">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div :class="createTask ? 'translate-x-0 ease-out' : 'translate-x-full ease-in'"
            class="fixed right-0 top-0 max-w-md w-full h-full px-6 py-4 transition duration-300 transform overflow-y-auto bg-white border-l-2 border-gray-300">
            <div class="flex items-center justify-between">
                <div class="flex items-center justify-start">
                    <h3 class="text-2xl font-medium text-gray-700">Create Task</h3>
                </div>

                <button @click="closeModal" class="text-gray-600 focus:outline-none">
                    <svg class="h-5 w-5" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <hr class="my-3">

            <CreateTaskForm :categories="categories" :status="task_status" @close-form="closeModal" />

        </div>

        <div :class="editTask ? 'translate-x-0 ease-out' : 'translate-x-full ease-in'"
            class="fixed right-0 top-0 max-w-md w-full h-full px-6 py-4 transition duration-300 transform overflow-y-auto bg-white border-l-2 border-gray-300">
            <div class="flex items-center justify-between">
                <div class="flex items-center justify-start">
                    <h3 class="text-2xl font-medium text-gray-700">Edit Task</h3>
                </div>

                <button @click="closeModal" class="text-gray-600 focus:outline-none">
                    <svg class="h-5 w-5" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <hr class="my-3">

            <div v-if="editTask">
                <EditTaskForm :task="taskToEdit" :categories="categories" :status="task_status" @close-form="closeModal" />
            </div>
        </div>

    </AppLayout>
</template>
