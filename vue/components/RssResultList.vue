<script setup lang="ts">
import {onMounted, ref} from "vue";
import RssResult from "./RssResult.vue";
import HeaderBlock from "./HeaderBlock.vue";

const data = ref([]);

onMounted(async () => {
    const response = await fetch('/api/rss');
    data.value = await response.json();
});

</script>

<template>
    <HeaderBlock v-if="data.length">
        <template v-slot:header>
            Some shit here
        </template>
        <template v-slot:default>
            <RssResult v-for="d in data" :data="d" />
        </template>
    </HeaderBlock>
</template>

<style scoped>

</style>