<script setup lang="ts">
import {onMounted, ref} from "vue";
import {useMascotStore} from "./../stores/mascot";
import {SafeTeleport} from "vue-safe-teleport";

let mascot = ref(null);
let currentGroup = ref(null);
let store = ref(null);

onMounted(async () => {
    store.value = useMascotStore();
    await store.value.fetchUpdateAsNeeded();
    mascot.value = store.value.getCurrentMascot();
    currentGroup.value = store.value.currentGroup;
});

function onChange() {
    store.value.changeGroup(currentGroup.value);
    mascot.value = store.value.getCurrentMascot();
}
</script>

<template>
    <SafeTeleport to="#mascot-select-container">
        <select class="mascot-select form-select form-select-sm" v-if="currentGroup != null" v-model="currentGroup" @change="onChange">
            <option v-for="(d, i) in store.groups" :value="d.name" >{{d.name}}</option>
        </select>
    </SafeTeleport>

    <div class="mascot-container" v-if="mascot != null">
        <img v-if="['png', 'jpg', 'jpeg', 'gif', 'webp'].includes(mascot.ext)" :src="mascot.url" class="mascot img-mascot" />
        <video v-else :src="mascot.url" autoplay loop class="mascot video-mascot"></video>
    </div>
    <div v-else>
        Failed to load mascot?
    </div>
</template>

<style scoped lang="scss">
    .mascot-container {
        height: 100%;
    }

    .mascot {
        object-fit: contain;
        object-position: bottom right;
        width: 100%;
        height: 100%;
        max-height: calc(100vh - 3rem - 50px);
    }

    .mascot-select {
        width: 100px;
        border: 0;
    }
</style>