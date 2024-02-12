import { ref } from 'vue'
import { defineStore } from 'pinia'
import moment from "moment";

export const useTitleStore = defineStore('title', () => {
    const titles = ref([]);
    const lastUpdate = ref(null);

    async function fetchUpdateAsNeeded() {
        if (null === lastUpdate.value || moment.utc(lastUpdate.value).add(1, 'day').isBefore(moment().utc())) {
            lastUpdate.value = moment().utc();
        } else {
            return;
        }

        const response = await fetch('/api/page-titles');
        titles.value = await response.json();
    }

    function getTitle() {
        return titles.value.length ? titles.value[Math.floor(Math.random() * titles.value.length)] : '~';
    }

    return {lastUpdate, titles, getTitle, fetchUpdateAsNeeded};
}, {
    persist: true
});
