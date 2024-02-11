<script setup lang="ts">
import {onMounted, ref} from "vue";
import {useMascotStore} from "./../stores/mascot";

let mascot = ref(null);

onMounted(async () => {
    const store = useMascotStore();
    await store.fetchUpdateAsNeeded();
    mascot.value = store.getCurrentMascot();
});
</script>

<template>
    <div v-if="mascot != null">
        <img v-if="['png', 'jpg', 'jpeg', 'gif', 'webp'].includes(mascot.ext)" :src="mascot.url" class="mascot img-mascot" />
        <video v-else :src="mascot.url" autoplay loop class="mascot video-mascot"></video>
    </div>
    <div v-else>
        Failed to load mascot?
    </div>
</template>

<style scoped lang="scss">
    .mascot {
        object-fit: contain;
        object-position: bottom right;
        width: 100%;
        height: 100%;
        max-height: calc(100vh - 3rem - 50px);
    }
</style>