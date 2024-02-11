<script setup lang="ts">
import {ref} from "vue";

const loading = ref(true);
const data = ref([]);

</script>

<template>
    <div v-if="loading">
        Loading shit!
    </div>
    <div v-else>
        displaying shit here:

        {data}
    </div>
</template>

<style scoped>

</style>