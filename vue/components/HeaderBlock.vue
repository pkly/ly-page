<script setup>
import {ref} from "vue";

const props = defineProps({
    hasData: {type: Boolean, required: true}
});

const busy = ref(false);
const emit = defineEmits(['onSuccess']);

async function request() {
    if (busy.value) {
        return;
    }

    busy.value = true;
    const response = await fetch('/api/mark-as-seen');

    if (response.status === 200) {
        emit('onSuccess');
    }
}
</script>

<template>
    <div class="header-block mb-3 pb-3 px-3 border-bottom border-info-subtle">
        <header>
            <div class="row">
                <div class="col-8">
                    <slot name="header"/>
                </div>
                <div class="col-4 text-end">
                    <button v-if="props.hasData" class="btn btn-sm btn-outline-info" @click="request">
                        Mark all as seen
                    </button>
                </div>
            </div>
        </header>
        <div>
            <slot name="default"/>
        </div>
    </div>
</template>

<style scoped lang="scss">
header {
    font-size: 1.2rem;
    margin-bottom: 1rem;
}
</style>