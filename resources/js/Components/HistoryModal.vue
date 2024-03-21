<script setup>
const props = defineProps(['history'])

</script>

<template>
    <div class="mb-5">
        <p class="inline-flex items-center text-xl font-semibold text-gray-900 dark:text-white">Changes History</p>
    </div>

    <div class="pr-5">
        <div class="lg:flex lg:justify-between py-2 border-b w-full hidden">
            <div class="my-auto lg:w-2/5 font-semibold text-lg">Subtask</div>
            <div class="my-auto lg:w-1/5 font-semibold text-lg">User</div>
            <div class="lg:w-2/5 text-center font-semibold text-lg">Details</div>
        </div>
    </div>

    <div class="overflow-y-auto h-96 lg:h-80 pr-5">
        <div v-for="subtask in history['subtasks_history']" :key="subtask.id"
            class="lg:flex lg:justify-between py-2 border-b w-full">
            <div class="my-auto lg:w-2/5">
                <p>{{ subtask.name }}</p>
            </div>

            <div class="my-auto lg:w-1/5">
                <p>{{ subtask.user.name }}</p>
            </div>

            <div class="lg:w-2/5">
                <div class="text-center">
                    <p>{{ subtask.previous_status }} to {{ subtask.current_status }}</p>
                </div>

                <div>
                    <p class="text-sm text-gray-500 truncate dark:text-gray-400 text-center">{{ subtask.created_at }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</template>
