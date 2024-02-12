<script setup lang="ts">
import {onMounted, ref} from "vue";
import RssResult from "./RssResult.vue";
import HeaderBlock from "./HeaderBlock.vue";

const data = ref([]);
const done = ref(false);

onMounted(async () => {
    const response = await fetch('/api/rss');
    data.value = await response.json();
});

const successes = ref(0);

function handleOnSuccess() {
    successes.value++;

    if (successes.value === data.value.length) {
        setTimeout(() => {
            done.value = true;
        }, 5000);
    }
}

</script>

<template>
    <HeaderBlock v-if="data.length && !done">
        <template v-slot:header>
            Some shit here
        </template>
        <template v-slot:default>
            <RssResult v-for="(d, i) in data" :data="d" :key="i" @onSuccess="handleOnSuccess"/>
        </template>
    </HeaderBlock>
</template>

<style scoped>

</style>