import { ref } from 'vue'
import { defineStore } from 'pinia'
import moment from "moment";

export const useLinkStore = defineStore('links', () => {
    const links = ref([]);
    const lastUpdate = ref(null);

    async function fetchUpdateAsNeeded() {
        if (null === lastUpdate.value || moment.utc(lastUpdate.value).add(1, 'day').isBefore(moment().utc())) {
            lastUpdate.value = moment().utc();
        } else {
            return;
        }

        const response = await fetch('/api/link-blocks');
        links.value = await response.json();
    }

    return {lastUpdate, links, fetchUpdateAsNeeded};
}, {
    persist: true
});
