<script setup lang="ts">
import {onMounted, ref} from "vue";
import RssResult from "./RssResult.vue";
import HeaderBlock from "./HeaderBlock.vue";

const data = ref([]);
const done = ref(false);

onMounted(async () => refresh());

async function refresh() {
    const response = await fetch('/api/rss');
    data.value = await response.json();
}

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
    <HeaderBlock v-if="data.length && !done" :has-data="data.length > 0" @onSuccess="refresh">
        <template v-slot:header>
            <span v-if="data.length">RSS results found</span>
            <span v-else>...And that's all, folks!</span>
        </template>
        <template v-slot:default>
            <RssResult v-for="(d, i) in data" :data="d" :key="i" @onSuccess="handleOnSuccess"/>
        </template>
    </HeaderBlock>
</template>
