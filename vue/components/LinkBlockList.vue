<script setup lang="ts">
import {onMounted, ref} from "vue";
import {useLinkStore} from "../stores/links";
import HeaderBlock from "./HeaderBlock.vue";

const links = ref([]);

onMounted(async () => {
    const store = useLinkStore();
    await store.fetchUpdateAsNeeded();
    links.value = store.links;
})

</script>

<template>
    <HeaderBlock v-for="(d, i) in links" :key="i" class="link-block">
        <template v-slot:header>
            {{d.title}}

            <small v-if="d.description != null">{{d.description}}</small>
        </template>
        <template v-slot:default>
            <a v-for="(sub, j) in d.subLinkBlocks" :key="j" :href="sub.url" class="btn btn-outline-info btn-sm">
                {{sub.title}}
            </a>
        </template>
    </HeaderBlock>
</template>

<style scoped lang="scss">
small {
    display: block;
    font-size: 0.7rem;
}

a {
    padding: 0.2rem 0.4rem;
    border-radius: 0;
    margin: 0 0.15rem;

    &:first-child {
        margin-left: 0;
    }
}
</style>