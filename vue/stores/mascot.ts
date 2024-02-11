import { ref, computed } from 'vue'
import { defineStore } from 'pinia'
import moment from "moment";

export const useMascotStore = defineStore('mascot', () => {
    const groups = ref([]);
    const currentGroup = ref(null);
    const currentIndex = ref(0);
    const lastIndexes = ref([]);
    const lastIndexUpdate = ref(null);
    const lastGroupUpdate = ref(null);

    async function fetchUpdateAsNeeded() {
        if (null === lastGroupUpdate.value || moment(lastGroupUpdate.value).add(1, 'day').isBefore(moment())) {
            lastGroupUpdate.value = moment();
        } else {
            return;
        }

        const response = await fetch('/api/mascot-groups');
        groups.value = await response.json();

        if (currentGroup.value === null) {
            for (const group of groups.value) {
                if (group.default) {
                    changeGroup(group.name);
                    break;
                }
            }
        }
    }

    function changeGroup(name: string) {
        const group = getGroupByName(name);

        if (null === group) {
            return false;
        }

        currentGroup.value = group.name;
        currentIndex.value = Math.floor(Math.random() * group.mascots.length);
        lastIndexes.value = [];

        return true;
    }

    function getGroupByName(name: string) {
        for (const group of groups.value) {
            if (group.name === name) {
                return group;
            }
        }

        return null;
    }

    function rollIndex() {

    }

    function getCurrentMascot() {
        if (currentGroup.value === null) {
            return null;
        }

        const group = getGroupByName(currentGroup.value);

        if (lastIndexUpdate.value === null) {
            lastIndexUpdate.value = moment();
        } else if (moment(lastIndexUpdate.value).add(1, 'minute').isBefore(moment())) {
            rollIndex();
        }

        return group.mascots[currentIndex.value];
    }

    return {groups, currentGroup, currentIndex, lastIndexes, updateAvailable: fetchUpdateAsNeeded, changeGroup, getCurrentMascot};
}, {
    persist: true
});
