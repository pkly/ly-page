<script setup lang="ts">

const props = defineProps({
    data: { type: Object, required: true },
});

</script>

<template>
    <div class="rss">
        <div class="header">{{props.data.title}}</div>
    </div>
</template>

<style scoped>

</style>