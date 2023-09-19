<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import TaskHeader from '@/Components/TaskHeader.vue';
import CreateSubtask from '@/Components/CreateSubtask.vue';
import SubtaskItem from '@/Components/SubtaskItem.vue';
import { Container, Draggable } from "vue3-smooth-dnd";
import { router } from '@inertiajs/vue3'
import { onMounted, ref } from 'vue';

const props = defineProps(['task', 'created_on']);

const draggingCard = ref({
    lane: "",
    index: -1,
    cardData: {}
});

const waitingArray = ref([]);
const inProgressArray = ref([]);
const finishedArray = ref([]);

const loadColumns = (array) => {
    array.forEach(objeto => {
        switch (objeto.status) {
            case 'Waiting':
                waitingArray.value.push(objeto);
                break;
            case 'In Progress':
                inProgressArray.value.push(objeto);
                break;
            case 'Finished':
                finishedArray.value.push(objeto);
                break;
            default:
                break;
        }
    });
}

const cards = ref({
    waitingArray: waitingArray.value,
    inProgressArray: inProgressArray.value,
    finishedArray: finishedArray.value,
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
        case 'Waiting':
            waitingArray.value.push(data);
            break;
        case 'In Progress':
            inProgressArray.value.push(data);
            break;
        case 'Finished':
            finishedArray.value.push(data);
            break;
        default:
            // Lida com qualquer outro status, se necessário
            break;
    }
}

const editSubtask = (data) => {
    if (data.array == 'waitingArray') {
        waitingArray.value[data.index].name = data.name
    } else if (data.array == 'inProgressArray') {
        inProgressArray.value[data.index].name = data.name
    } else {
        finishedArray.value[data.index].name = data.name
    }
}

const removeSubtask = (data) => {
    if (data.array == 'waitingArray') {
        waitingArray.value.splice(data.index, 1)
    } else if (data.array == 'inProgressArray') {
        inProgressArray.value.splice(data.index, 1)
    } else {
        finishedArray.value.splice(data.index, 1)
    }
}

loadColumns(props.task.subtasks)
</script>

<template>
    <AppLayout>
        <TaskHeader :task="task" :created="created_on"/>

        <div class="mt-10 grid grid-cols-3 gap-2 items-start">
            <div class="border p-3 rounded-lg border-red-400">
                <div class="flex justify-start mb-2">
                    <p class="font bold text-lg">Waiting</p>
                </div>

                <Container group-name="subtasks" @drag-start="handleDragStart('waitingArray', $event)"
                    @drop="handleDrop('waitingArray', $event)" :get-child-payload="getChildPayload"
                    :drop-placeholder="{ className: 'placeholder' }">
                    <Draggable v-for="(item, i) in waitingArray" :key="item.id">
                        <SubtaskItem :index="i" :item="item" status="Waiting" array="waitingArray"
                            @edit-subtask="editSubtask" @delete-subtask="removeSubtask" />
                    </Draggable>
                </Container>

                <CreateSubtask status="Waiting" :task_id="task.id" @update-column="loadData" />
            </div>

            <div class="border p-3 rounded-lg border-yellow-400">
                <div class="flex justify-start mb-2">
                    <p class="font bold text-lg">In Progress</p>
                </div>

                <Container group-name="subtasks" @drag-start="handleDragStart('inProgressArray', $event)"
                    @drop="handleDrop('inProgressArray', $event)" :get-child-payload="getChildPayload"
                    :drop-placeholder="{ className: 'placeholder' }">
                    <Draggable v-for="(item, i) in inProgressArray" :key="item.id">
                        <SubtaskItem :index="i" :item="item" status="In Progress" array="inProgressArray"
                            @edit-subtask="editSubtask" @delete-subtask="removeSubtask" />
                    </Draggable>
                </Container>

                <CreateSubtask status="In Progress" :task_id="task.id" @update-column="loadData" />
            </div>

            <div class="border p-3 rounded-lg border-blue-400">
                <div class="flex justify-start mb-2">
                    <p class="font bold text-lg">Finished</p>
                </div>

                <Container group-name="subtasks" @drag-start="handleDragStart('finishedArray', $event)"
                    @drop="handleDrop('finishedArray', $event)" :get-child-payload="getChildPayload"
                    :drop-placeholder="{ className: 'placeholder' }">
                    <Draggable v-for="(item, i) in finishedArray" :key="item.id">
                        <SubtaskItem :index="i" :item="item" status="Finished" array="finishedArray"
                            @edit-subtask="editSubtask" @delete-subtask="removeSubtask" />
                    </Draggable>
                </Container>

                <CreateSubtask status="Finished" :task_id="task.id" @update-column="loadData" />
            </div>
        </div>

    </AppLayout>
</template>

<style>
.placeholder {
    background: rgba(33, 33, 33, 0.08);
    border-radius: 0.4rem;
    transform: scaleY(0.85);
    transform-origin: 0% 0%;
}
</style>
