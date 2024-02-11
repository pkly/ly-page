<script setup lang="ts">
import RssResultList from "./components/RssResultList.vue";
import PageTitle from "./components/PageTitle.vue";
import Mascot from "./components/Mascot.vue";
</script>

<template>
    <div class="container-fluid flex-grow-1 main-container">
        <PageTitle/>

        <div class="row">
            <div class="col-12 col-md-6">
                <RssResultList/>
            </div>
            <div class="col-12 col-md-6 mascot-container">
                <Mascot/>
            </div>
        </div>
    </div>
</template>
