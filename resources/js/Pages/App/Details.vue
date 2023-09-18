<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import CreateSubtask from '@/Components/CreateSubtask.vue';
import SubtaskItem from '@/Components/SubtaskItem.vue';
import { Container, Draggable } from "vue3-smooth-dnd";
import { router } from '@inertiajs/vue3'
import { onMounted, ref } from 'vue';

const props = defineProps(['task']);

const draggingCard = ref({
    lane: "",
    index: -1,
    cardData: {}
});

const aguardandoArray = ref([]);
const emExecucaoArray = ref([]);
const concluidaArray = ref([]);

const loadColumns = (array) => {
    array.forEach(objeto => {
        switch (objeto.status) {
            case 'Aguardando':
                aguardandoArray.value.push(objeto);
                break;
            case 'Em execucao':
                emExecucaoArray.value.push(objeto);
                break;
            case 'Concluida':
                concluidaArray.value.push(objeto);
                break;
            default:
                break;
        }
    });
}

const cards = ref({
    aguardandoArray: aguardandoArray.value,
    emExecucaoArray: emExecucaoArray.value,
    concluidaArray: concluidaArray.value,
});

const handleDragStart = (lane, dragResult) => {
    const { payload, isSource } = dragResult

    if (isSource) {
        draggingCard.value.lane = lane
        draggingCard.value.index = payload.index
        draggingCard.value.cardData = {
            ...cards.value[lane][payload.index]
        }
    }
}

const handleDrop = (lane, dropResult) => {
    const { removedIndex, addedIndex } = dropResult

    if (lane === draggingCard.value.lane && removedIndex === addedIndex) {
        return;
    }

    if (removedIndex !== null) {
        cards.value[lane].splice(removedIndex, 1);
    }

    if (addedIndex !== null) {
        cards.value[lane].splice(addedIndex, 0, draggingCard.value.cardData);

        router.put(route('subtasks.status', { card: draggingCard.value.cardData.id }), {
            status: lane,
            subtaskId: draggingCard.value.cardData.id
        }, { preserveScroll: true });
    }

}

const getChildPayload = (index) => {
    return { index }
}

const loadData = (data) => {
    switch (data.status) {
        case 'Aguardando':
            aguardandoArray.value.push(data);
            break;
        case 'Em execucao':
            emExecucaoArray.value.push(data);
            break;
        case 'Concluida':
            concluidaArray.value.push(data);
            break;
        default:
            // Lida com qualquer outro status, se necessário
            break;
    }
}

loadColumns(props.task.subtasks)
</script>

<template>
    <AppLayout>
        <div>
            <p class="text-3xl">
                {{ task.name }}
            </p>
        </div>

        <div class="mt-20 grid grid-cols-3 gap-2">
            <div>
                <div class="flex justify-center mb-2">
                    <p class="font bold text-xl">Aguardando</p>
                </div>

                <Container group-name="subtasks" @drag-start="handleDragStart('aguardandoArray', $event)"
                    @drop="handleDrop('aguardandoArray', $event)" :get-child-payload="getChildPayload"
                    :drop-placeholder="{ className: 'placeholder' }">
                    <Draggable v-for="(item, i) in aguardandoArray" :key="item.id">
                        <SubtaskItem :index="i" :name="item.name" status="Aguardando" />
                    </Draggable>
                </Container>

                <CreateSubtask status="Aguardando" :task_id="task.id" @update-column="loadData" />
            </div>

            <div>
                <div class="flex justify-center mb-2">
                    <p class="font bold text-xl">Em Execucao</p>
                </div>

                <Container group-name="subtasks" @drag-start="handleDragStart('emExecucaoArray', $event)"
                    @drop="handleDrop('emExecucaoArray', $event)" :get-child-payload="getChildPayload"
                    :drop-placeholder="{ className: 'placeholder' }">
                    <Draggable v-for="(item, i) in emExecucaoArray" :key="item.id">
                        <SubtaskItem :index="i" :name="item.name" status="Em execucao" />
                    </Draggable>
                </Container>

                <CreateSubtask status="Em execucao" :task_id="task.id" @update-column="loadData" />
            </div>

            <div>
                <div class="flex justify-center mb-2">
                    <p class="font bold text-xl">Concluida</p>
                </div>

                <Container group-name="subtasks" @drag-start="handleDragStart('concluidaArray', $event)"
                    @drop="handleDrop('concluidaArray', $event)" :get-child-payload="getChildPayload"
                    :drop-placeholder="{ className: 'placeholder' }">
                    <Draggable v-for="(item, i) in concluidaArray" :key="item.id">
                        <SubtaskItem :index="i" :name="item.name" status="Concluida" />
                    </Draggable>
                </Container>

                <CreateSubtask status="Concluida" :task_id="task.id" @update-column="loadData" />
            </div>
        </div>

    </AppLayout>
</template>

<style scoped>
.placeholder {
    background: rgba(33, 33, 33, 0.08);
    border-radius: 0.4rem;
    transform: scaleY(0.85);
    transform-origin: 0% 0%;
}
</style>
