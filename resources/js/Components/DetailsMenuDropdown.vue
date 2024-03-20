<script setup>
import ToastMessage from '@/Components/ToastMessage.vue'
import AdminList from '@/Components/AdminList.vue';
import CloseIcon from '@/Components/Icons/CloseIcon.vue';
import MenuIcon from '@/Components/Icons/MenuIcon.vue';
import axios from 'axios';
import { ref } from 'vue';

const props = defineProps(['task', 'task_admins'])

const open = ref(false)
const adminModal = ref(false)
const adminListModal = ref(false)
const toast = ref(false)

const email = ref('')
const message = ref('')

const submit = () => {
    axios.post('/task/new-admin', {
        email: email.value,
        task: props.task.id
    }).then(response => {
        email.value = ''
        adminModal.value = false
        open.value = false
        message.value = response.data.message
        openToast()
    });
}

const openToast = () => {
    toast.value = true
    setTimeout(() => toast.value = false, 2500)
}
</script>

<template>
    <div class="relative">
        <!-- Icon -->
        <button type="button" @click="open = !open" id="user-menu-button" aria-expanded="false"
            data-dropdown-toggle="user-dropdown" data-dropdown-placement="bottom">
            <MenuIcon />
        </button>

        <Transition>
            <!-- Dropdown menu -->
            <div v-show="open"
                class="z-40 absolute top-10 lg:top-9 right-1 text-base list-none bg-white divide-y divide-gray-100 rounded-lg shadow dark:bg-gray-700 dark:divide-gray-600"
                id="user-dropdown">
                <div class="px-4 py-3">
                    <span class="block text-sm text-gray-900">Oi</span>
                    <span class="block text-sm  text-gray-500 truncate">Oi</span>
                </div>
                <ul class="py-2 w-36" aria-labelledby="user-menu-button">
                    <li v-if="$page.props.auth.user.id == task.user_id">
                        <button @click="adminModal = true"
                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 w-full text-left">
                            Add Admin
                        </button>
                    </li>
                    <li class="lg:hidden">
                        <button class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 w-full text-left">
                            Chat
                        </button>
                    </li>
                    <li>
                        <button class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 w-full text-left">
                            Changes Register
                        </button>
                    </li>
                    <li>
                        <button @click="adminListModal = true"
                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 w-full text-left">
                            Admin List
                        </button>
                    </li>
                </ul>
            </div>
        </Transition>
    </div>

    <Transition>
        <!-- Modal to new admin -->
        <div class="fixed inset-0 z-50 flex items-center justify-center overflow-x-hidden overflow-y-auto"
            v-show="adminModal">
            <div class="relative w-4/5 lg:mx-auto lg:w-2/5">
                <div class="w-full pt-8 pb-6 bg-white rounded-md lg:pr-2 lg:pl-3">
                    <div class="flex justify-end">
                        <button class="mr-5 lg:mr-5" @click="adminModal = false">
                            <CloseIcon />
                        </button>
                    </div>

                    <div class="mx-4 mt-3 lg:mx-10">
                        <div class="text-center">
                            <p class="text-lg lg:text-xl">Add Admin</p>
                        </div>

                        <div class="mt-5">
                            <label for="email" value="Email" class="block mb-2 text-sm font-medium text-gray-900" />
                            <input id="email" type="text"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                v-model="email" required />
                        </div>
                    </div>

                    <div class="flex flex-row-reverse mt-10 mr-5">
                        <button type="submit" @click="submit"
                            class="py-2 ml-5 text-base tracking-tighter text-white bg-black rounded-full px-7">
                            Add
                        </button>
                        <button @click="adminModal = false"
                            class="py-2 text-base tracking-tighter bg-white border border-black rounded-full px-7">
                            Close
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </Transition>
    <div v-show="adminModal" class="fixed inset-0 z-40 bg-black opacity-75"></div>

    <Transition>
        <!-- Modal all admin -->
        <div class="fixed inset-0 z-50 flex items-center justify-center overflow-x-hidden overflow-y-auto"
            v-show="adminListModal">
            <div class="relative w-4/5 lg:mx-auto lg:w-3/5">
                <div class="w-full pt-8 pb-6 bg-white rounded-md lg:pr-2 lg:pl-3">
                    <div class="flex justify-end">
                        <button class="mr-5 lg:mr-5" @click="adminListModal = false">
                            <CloseIcon />
                        </button>
                    </div>

                    <AdminList :task="task" :task_admins="task_admins" />

                    <div class="flex flex-row-reverse mt-10 mr-5">
                        <button type="submit" @click="submit"
                            class="py-2 ml-5 text-base tracking-tighter text-white bg-black rounded-full px-7">
                            Add
                        </button>
                        <button @click="adminListModal = false"
                            class="py-2 text-base tracking-tighter bg-white border border-black rounded-full px-7">
                            Close
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </Transition>
    <div v-show="adminListModal" class="fixed inset-0 z-40 bg-black opacity-75"></div>

    <Transition>
        <!-- Toast success -->
        <div v-show="toast" class="fixed bottom-4 right-4 z-50">
            <ToastMessage :message="message" />
        </div>
    </Transition>
</template>
