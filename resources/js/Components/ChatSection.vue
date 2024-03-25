<script setup>
import { router, usePage } from '@inertiajs/vue3';
import { onMounted, ref } from 'vue';
import moment from 'moment';

const props = defineProps(['task'])

const page = usePage()

const message = ref('')
const messages = ref(props.task['messages'])
const messageContainer = ref(null);

const submit = () => {
    router.put(route('message'), {
        task_id: props.task.id,
        message: message.value,
    }, { preserveScroll: true });

    message.value = ''
}

const scrollToBottom = () => {
    if (messageContainer.value) {
        messageContainer.value.scrollTop = messageContainer.value.scrollHeight;
    }
}

onMounted(() => {
    scrollToBottom();

    window.Echo.channel('message')
        .listen('MessageCreate', async (e) => {
            if (e.message.task_id == props.task.id) { // && page.props.auth_id != e.message.user_id
                await messages.value.push(e.message);
                scrollToBottom();
            }
        });
}
);
</script>

<template>
    <div class="h-full">
        <!--Messages-->
        <div class="flex flex-col gap-3 overflow-y-auto h-[88%] lg:h-[86%]" ref="messageContainer">

            <div v-for="message in messages" :key="message.id">
                <!-- My Messages -->
                <div v-if="message.user_id == $page.props.auth.user.id" class="flex items-start gap-2.5">
                    <div class="flex flex-col w-full gap-1 ml-4 mr-2">
                        <div class="flex flex-col leading-1.5 p-4 border-gray-200 bg-black rounded-l-xl rounded-br-xl">
                            <p class="text-sm font-normal text-white">
                                {{ message.content }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Other Messages -->
                <div v-else class="flex items-start gap-2.5">
                    <div class="flex flex-col w-full gap-1 ml-2 mr-4">
                        <div class="flex items-center space-x-2 rtl:space-x-reverse">
                            <span class="text-sm font-semibold text-gray-900">{{ message.user.name }}</span>
                            <span class="text-sm font-normal text-gray-500">
                                {{ moment(message.created_at).utc().format('HH:mm') }}
                            </span>
                        </div>
                        <div
                            class="flex flex-col leading-1.5 p-4 border-gray-200 bg-gray-100 rounded-e-xl rounded-es-xl">
                            <p class="text-sm font-normal text-gray-900">
                                {{ message.content }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!--Input-->
        <div class="h-1/6 lg:h-16">
            <form @submit.prevent="submit" class="">
                <div class="flex items-center px-1 py-2 bg-gray-50 dark:bg-gray-700">
                    <textarea id="chat" rows="1" v-model="message"
                        class="block w-full mx-1 text-sm text-gray-900 bg-white border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 "
                        placeholder="Your message..."></textarea>
                    <button type="submit"
                        class="inline-flex justify-center p-2 text-black rounded-full cursor-pointer hover:bg-blue-100">
                        <svg class="w-5 h-5 rotate-90 rtl:-rotate-90" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 18 20">
                            <path
                                d="m17.914 18.594-8-18a1 1 0 0 0-1.828 0l-8 18a1 1 0 0 0 1.157 1.376L8 18.281V9a1 1 0 0 1 2 0v9.281l6.758 1.689a1 1 0 0 0 1.156-1.376Z" />
                        </svg>
                        <span class="sr-only">Send message</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>
