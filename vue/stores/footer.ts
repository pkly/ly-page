import { ref } from 'vue'
import { defineStore } from 'pinia'
import moment from "moment";

export const useFooterStore = defineStore('footer', () => {
    const links = ref([]);
    const lastUpdate = ref(null);

    async function fetchUpdateAsNeeded() {
        if (null === lastUpdate.value || moment.utc(lastUpdate.value).add(1, 'day').isBefore(moment().utc())) {
            lastUpdate.value = moment().utc();
        } else {
            return;
        }

        const response = await fetch('/api/footer-links');
        links.value = await response.json();
    }

    return {lastUpdate, links, fetchUpdateAsNeeded};
}, {
    persist: true
});
