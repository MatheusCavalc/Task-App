<script setup>
import ToastMessage from '@/Components/ToastMessage.vue'
import HistoryModal from '@/Components/HistoryModal.vue';
import CloseIcon from '@/Components/Icons/CloseIcon.vue';
import ChevronIcon from '@/Components/Icons/ChevronIcon.vue'
import ChatSection from '@/Components/ChatSection.vue';
import ChatIcon from '@/Components/Icons/ChatIcon.vue';
import MenuIcon from '@/Components/Icons/MenuIcon.vue';
import AdminList from '@/Components/AdminList.vue';
import axios from 'axios';
import { ref } from 'vue';

const props = defineProps(['task', 'task_admins'])

const open = ref(false)
const adminModal = ref(false)
const adminListModal = ref(false)
const historyChangesModal = ref(false)
const chat = ref(false)
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

const openAdminModal = () => {
    adminListModal.value = false
    adminModal.value = true
}
</script>

<template>
    <div class="relative">
        <!-- Icon -->
        <div class="flex gap-2">
            <button class="lg:hidden" @click="chat = !chat">
                <ChatIcon />
            </button>

            <button @click="open = !open">
                <MenuIcon />
            </button>
        </div>

        <Transition>
            <!-- Dropdown menu -->
            <div v-show="open"
                class="absolute z-20 text-base list-none bg-white divide-y divide-gray-100 rounded-lg shadow-xl top-10 lg:top-9 right-1">
                <ul class="py-2 w-36" aria-labelledby="user-menu-button">
                    <li v-if="$page.props.auth.user.id == task.user_id">
                        <button @click="adminModal = true"
                            class="block w-full px-4 py-2 text-sm text-left text-gray-700 hover:bg-gray-100">
                            Add Admin
                        </button>
                    </li>
                    <li>
                        <button @click="adminListModal = true"
                            class="block w-full px-4 py-2 text-sm text-left text-gray-700 hover:bg-gray-100">
                            Admin List
                        </button>
                    </li>
                    <li>
                        <button @click="historyChangesModal = true"
                            class="block w-full px-4 py-2 text-sm text-left text-gray-700 hover:bg-gray-100">
                            Changes Register
                        </button>
                    </li>
                </ul>
            </div>
        </Transition>
    </div>

    <!-- Modal to new admin -->
    <Transition>
        <div class="fixed inset-0 z-50 flex items-center justify-center overflow-x-hidden overflow-y-auto"
            v-show="adminModal">
            <div class="relative w-11/12 lg:mx-auto lg:w-2/5">
                <div class="w-full pt-8 pb-6 bg-white rounded-tr-xl rounded-bl-xl lg:pr-5 lg:pl-3">
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
                        <button @click="submit"
                            class="py-2 ml-5 text-base tracking-tighter text-white transition-all delay-100 bg-black border border-black rounded-full hover:bg-white hover:text-black px-7">
                            Add
                        </button>
                        <button @click="adminModal = false"
                            class="py-2 text-base tracking-tighter transition-all delay-100 bg-white border border-black rounded-full hover:bg-black hover:text-white px-7">
                            Close
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </Transition>

    <!-- Modal all admin -->
    <Transition>
        <div class="fixed inset-0 z-50 flex items-center justify-center overflow-x-hidden overflow-y-auto"
            v-show="adminListModal">
            <div class="relative w-11/12 lg:mx-auto lg:w-3/5">
                <div class="w-full pt-8 pb-6 bg-white rounded-tr-xl rounded-bl-xl lg:pr-5 lg:pl-3">
                    <div class="flex justify-end">
                        <button class="mr-5 lg:mr-5" @click="adminListModal = false">
                            <CloseIcon />
                        </button>
                    </div>

                    <AdminList :task="task" :task_admins="task_admins" />

                    <div class="flex flex-row-reverse mt-10 mr-5">
                        <button type="submit" @click="openAdminModal"
                            class="py-2 ml-5 text-base tracking-tighter text-white transition-all delay-100 bg-black border border-black rounded-full hover:bg-white hover:text-black px-7">
                            Add
                        </button>
                        <button @click="adminListModal = false"
                            class="py-2 text-base tracking-tighter transition-all delay-100 bg-white border border-black rounded-full hover:bg-black hover:text-white px-7">
                            Close
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </Transition>

    <!-- Modal Change History -->
    <Transition>
        <div class="fixed inset-0 z-50 flex items-center justify-center overflow-x-hidden overflow-y-auto"
            v-show="historyChangesModal">
            <div class="relative w-11/12 lg:mx-auto lg:w-3/5">
                <div class="w-full pt-8 pb-6 pl-3 bg-white rounded-tr-xl rounded-bl-xl lg:pr-5">
                    <div class="flex justify-end">
                        <button class="mr-5 lg:mr-5" @click="historyChangesModal = false">
                            <CloseIcon />
                        </button>
                    </div>

                    <HistoryModal :history="task" />

                    <div class="flex flex-row-reverse mt-5 mr-5">
                        <button @click="historyChangesModal = false"
                            class="py-2 text-base tracking-tighter transition-all delay-100 bg-white border border-black rounded-full hover:bg-black hover:text-white px-7">
                            Close
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </Transition>

    <div v-show="historyChangesModal || adminListModal || adminModal" class="fixed inset-0 z-40 bg-black opacity-75">
    </div>

    <!-- Toast -->
    <Transition>
        <div v-show="toast" class="fixed z-50 bottom-4 right-4">
            <ToastMessage :message="message" />
        </div>
    </Transition>

    <!-- Chat -->
    <div :class="chat ? 'lg:block' : 'hidden lg:block'"
        class="fixed bottom-0 right-0 z-30 w-full h-full bg-white lg:bottom-0 lg:right-4 lg:w-72 lg:h-fit lg:border-t lg:border-l lg:border-r lg:border-black lg:rounded-t-xl">
        <div class="flex justify-between px-3 py-3 border-b border-black lg:px-2 lg:py-1 lg:border-none">
            <p class="text-xl lg:text-lg">Chat</p>

            <button @click="chat = !chat">
                <p :class="{ '-rotate-180': chat }" class="hidden transition duration-300 transform lg:block">
                    <ChevronIcon />
                </p>

                <p class="lg:hidden">
                    <CloseIcon />
                </p>
            </button>
        </div>

        <div :class="chat ? 'lg:translate-y-0 lg:ease-out h-full lg:h-96' : 'lg:translate-y-full lg:ease-in lg:h-0'"
            class="w-full py-4 transition duration-300 transform bg-white lg:py-0">
            <ChatSection :task="task" />
        </div>
    </div>

</template>
