<script setup lang="ts">
import {onMounted, ref} from "vue";
import {useFooterStore} from "../stores/footer";
import {TeleportTarget} from "vue-safe-teleport";

let links = ref([]);

onMounted(async () => {
    const store = useFooterStore();
    await store.fetchUpdateAsNeeded();
    links.value = store.links;
})
</script>

<template>
    <footer>
        <a v-for="(d, i) in links" :href="d.url" :key="i">
            {{d.title}}
        </a>
        <TeleportTarget id="mascot-select-container" />
    </footer>
</template>

<style scoped lang="scss">
footer {
    text-align: center;
    height: 35px;
    z-index: 1;
    position: fixed;
    bottom: 0;
    left: 0;
    width: 100%;

    a {
        display: inline-block;
        padding-left: 0.5rem;
        padding-right: 0.5rem;

        color: var(--bs-secondary);
        font-size: 0.8rem;
        text-decoration: none;
    }

    #mascot-select-container {
        display: inline-block;
        padding-left: 0.5rem;
        padding-right: 0.5rem;
    }
}
</style>