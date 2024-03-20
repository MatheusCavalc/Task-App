<script setup>
const props = defineProps(['message'])
</script>

<template>
    <div
        class="flex items-center w-full max-w-xs p-4 space-x-3 bg-white divide-x divide-black rounded-lg shadow-xl space-x">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
            class="w-6 h-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
        </svg>
        <div class="pl-4 text-sm font-bold">
            <p>{{ message }}</p>
        </div>
    </div>
</template>
