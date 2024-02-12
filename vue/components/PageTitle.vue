<script setup lang="ts">
import {onMounted, ref} from "vue";
import {useTitleStore} from "../stores/title";

const title = ref('~');

onMounted(async () => {
    const store = useTitleStore();
    await store.fetchUpdateAsNeeded();

    title.value = store.getTitle();
})

</script>

<template>
    <header class="mb-4">
        {{ title }}
    </header>
</template>

<style scoped>
header {
    font-size: 2.5rem;
}
</style>