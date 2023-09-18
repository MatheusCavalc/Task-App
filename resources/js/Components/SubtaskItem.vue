<script setup>
import { ref } from 'vue';

const props = defineProps(['index', 'name', 'status'])

const statusClasses = {
    'Aguardando': 'p-3 border border-red-400 rounded-lg mb-1',
    'Em execucao': 'p-3 border border-yellow-400 rounded-lg mb-1',
    'Concluida': 'p-3 border border-red-400 rounded-lg mb-1',
};

const classes = ref(statusClasses[props.status] || '');
</script>

<template>
    <div :class="classes">
        {{ index + 1 }} -> {{ name }}
    </div>
</template>
