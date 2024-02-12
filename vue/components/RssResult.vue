<script setup lang="ts">

import {ref} from "vue";
import moment from "moment";
import _ from "lodash";

const props = defineProps({
    data: { type: Object, required: true },
});
const emit = defineEmits(['onSuccess']);


const busy = ref(false);
const success = ref(false);
const error = ref(false);
const id = ref(_.uniqueId());

async function request() {
    if (busy.value) {
        return;
    }

    busy.value = true;
    const response = await fetch('/api/download-rss/' + props.data.id);

    if (response.status === 200) {
        success.value = true;
        emit('onSuccess');
    } else {
        error.value = true;
    }
}
</script>

<template>
    <div class="rss-wrapper" :class="{hide: success}">
        <div class="rss mb-3" :id="id" @click="request" :class="{busy: busy, success: success, failure: error}">
            <div class="row">
                <div class="col-12 col-md-9">
                    <div class="header text-info">{{props.data.title}}</div>
                </div>
                <div class="col-12 col-md-3 text-end">
                    <small>{{moment(props.data.createdAt).fromNow()}}</small>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped lang="scss">
.rss-wrapper {
    overflow: hidden;
    transition: 0.7s;
    max-height: 100px;

    &.hide {
        max-height: 0;
    }
}

.rss {
    padding: 0.3rem;
    border-bottom: var(--bs-info-border-subtle) 1px solid;
    border-right: var(--bs-info-border-subtle) 1px solid;

    &:hover {
        cursor: pointer;

        &.busy {
            cursor: not-allowed;
        }
    }

    transition: 0.6s;

    &.failure {
        background: var(--bs-danger);
        border-color: var(--bs-danger-border-subtle);
    }

    &.success {
        background: var(--bs-success);
        border-color: var(--bs-success-border-subtle);
    }
}
</style>