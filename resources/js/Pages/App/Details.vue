<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import TaskHeader from '@/Components/TaskHeader.vue';
import CreateSubtask from '@/Components/CreateSubtask.vue';
import SubtaskItem from '@/Components/SubtaskItem.vue';
import { Container, Draggable } from "vue3-smooth-dnd";
import { router } from '@inertiajs/vue3'
import { Head } from '@inertiajs/vue3';
import { onMounted, ref } from 'vue';

const props = defineProps(['task', 'auth_id', 'task_admins']);

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
        cards.value[lane].splice(removedIndex, 1); //need change code to share task for more users
    }

    if (addedIndex !== null) {
        cards.value[lane].splice(addedIndex, 0, draggingCard.value.cardData); //need change code to share task for more users

        router.put(route('subtasks.status', { card: draggingCard.value.cardData.id }), {
            status: lane,
            subtaskId: draggingCard.value.cardData.id,
            cardData: draggingCard.value.cardData,
            task: props.task.id,
            dropResult: dropResult,

            draggingCard: draggingCard.value
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

onMounted(() => {
    window.Echo.channel('update')
        .listen('TaskUpdate', (e) => {
            if (e.task == props.task.id && props.auth_id != e.auth_id) { //&& props.auth_id != e.auth_id

                if (e.draggingCard.lane == 'waitingArray') {
                    let indexToRemove = waitingArray.value.findIndex(item => item.id === e.draggingCard.cardData.id);
                    waitingArray.value.splice(indexToRemove, 1);
                } else if (e.draggingCard.lane == 'inProgressArray') {
                    let indexToRemove = inProgressArray.value.findIndex(item => item.id === e.draggingCard.cardData.id);
                    inProgressArray.value.splice(indexToRemove, 1);
                } else {
                    let indexToRemove = finishedArray.value.findIndex(item => item.id === e.draggingCard.cardData.id);
                    finishedArray.value.splice(indexToRemove, 1);
                }

                const lane = e.status
                const { removedIndex, addedIndex } = e.dropResult

                if (removedIndex !== null) {
                    cards.value[lane].splice(removedIndex, 1);
                }

                if (addedIndex !== null) {
                    cards.value[lane].splice(addedIndex, 0, e.cardData);
                }
            }
        });


    window.Echo.channel('create')
        .listen('TaskCreate', (e) => {
            if (e.data.task_id == props.task.id && props.auth_id != e.auth_id) {
                loadData(e.data)
            }
        });
}
);
</script>

<template>
    <Head :title="task.name" />

    <AppLayout>
        <section class="lg:p-4">
            <TaskHeader :task="task" :task_admins="task_admins" />

            <div
                class="flex items-start gap-3 px-3 pb-20 mt-10 overflow-x-auto lg:grid lg:grid-cols-3 lg:gap-2 hide-scrollbar lg:pb-5 lg:px-0">
                <div class="flex-shrink-0 w-64 p-3 border border-red-400 rounded-lg lg:w-full">
                    <div class="flex justify-start mb-2">
                        <p class="text-lg font bold">Waiting</p>
                    </div>

                    <Container group-name="subtasks" @drag-start="handleDragStart('waitingArray', $event)"
                        @drop="handleDrop('waitingArray', $event)" :get-child-payload="getChildPayload"
                        :drop-placeholder="{ className: 'placeholder' }">
                        <Draggable v-for="(item, i) in waitingArray" :key="item.id" class="cursor-grabbing">
                            <SubtaskItem :index="i" :item="item" status="Waiting" array="waitingArray"
                                @edit-subtask="editSubtask" @delete-subtask="removeSubtask" />
                        </Draggable>
                    </Container>

                    <CreateSubtask status="Waiting" :task_id="task.id" @update-column="loadData" />
                </div>

                <div class="flex-shrink-0 w-64 p-3 border border-yellow-400 rounded-lg lg:w-full">
                    <div class="flex justify-start mb-2">
                        <p class="text-lg font bold">In Progress</p>
                    </div>

                    <Container group-name="subtasks" @drag-start="handleDragStart('inProgressArray', $event)"
                        @drop="handleDrop('inProgressArray', $event)" :get-child-payload="getChildPayload"
                        :drop-placeholder="{ className: 'placeholder' }">
                        <Draggable v-for="(item, i) in inProgressArray" :key="item.id" class="cursor-grabbing">
                            <SubtaskItem :index="i" :item="item" status="In Progress" array="inProgressArray"
                                @edit-subtask="editSubtask" @delete-subtask="removeSubtask" />
                        </Draggable>
                    </Container>

                    <CreateSubtask status="In Progress" :task_id="task.id" @update-column="loadData" />
                </div>

                <div class="flex-shrink-0 w-64 p-3 border border-blue-400 rounded-lg lg:w-full">
                    <div class="flex justify-start mb-2">
                        <p class="text-lg font bold">Finished</p>
                    </div>

                    <Container group-name="subtasks" @drag-start="handleDragStart('finishedArray', $event)"
                        @drop="handleDrop('finishedArray', $event)" :get-child-payload="getChildPayload"
                        :drop-placeholder="{ className: 'placeholder' }">
                        <Draggable v-for="(item, i) in finishedArray" :key="item.id" class="cursor-grabbing">
                            <SubtaskItem :index="i" :item="item" status="Finished" array="finishedArray"
                                @edit-subtask="editSubtask" @delete-subtask="removeSubtask" />
                        </Draggable>
                    </Container>

                    <CreateSubtask status="Finished" :task_id="task.id" @update-column="loadData" />
                </div>
            </div>
        </section>
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
