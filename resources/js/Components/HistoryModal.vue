<script setup>
const props = defineProps(['history'])

</script>

<template>
    <div class="mb-5">
        <p class="inline-flex items-center text-xl font-semibold text-gray-900 dark:text-white">Changes History</p>
    </div>

    <div class="pr-5">
        <div class="hidden w-full py-2 border-b lg:flex lg:justify-between">
            <div class="my-auto text-lg font-semibold lg:w-2/5">Subtask</div>
            <div class="my-auto text-lg font-semibold lg:w-1/5">User</div>
            <div class="text-lg font-semibold text-center lg:w-2/5">Details</div>
        </div>
    </div>

    <div class="pr-5 overflow-y-auto h-96 lg:h-80">
        <div v-for="subtask in history['subtasks_history']" :key="subtask.id"
            class="items-center w-full py-2 border-b lg:flex lg:justify-between">
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
                    <p class="text-sm text-center text-gray-500 truncate dark:text-gray-400">{{ subtask.created_at }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</template>
