<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { useForm } from '@inertiajs/vue3'

const form = useForm({
    name: ''
})

const submit = () => {
    form.post('/categories');
}
</script>

<template>
    <AppLayout>
        <div class="py-6 px-4">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">

                        <h1 class="text-2xl">Create New Category</h1>

                        <form @submit.prevent="submit">

                            <div class="mb-3">
                                <label for="name" value="Name" class="block mb-2 text-sm font-medium text-gray-900" />
                                <input id="name" type="text"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                    v-model="form.name" required />
                            </div>

                            <button
                                class="text-black bg-blue-500 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center"
                                :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                Submit
                            </button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
