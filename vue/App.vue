<script setup lang="ts">
import RssResultList from "./components/RssResultList.vue";
import PageTitle from "./components/PageTitle.vue";
import Mascot from "./components/Mascot.vue";
import Footer from "./components/Footer.vue";
import LinkBlockList from "./components/LinkBlockList.vue";
</script>

<template>
    <div class="container-fluid d-flex flex-column main-container h-100">
        <PageTitle/>

        <div class="row flex-grow-1">
            <div class="col-12 col-md-6">
                <RssResultList/>
                <LinkBlockList/>
            </div>
            <div class="col-12 col-md-6 mascot-container">
                <Mascot/>
            </div>
        </div>
    </div>
    <Footer/>
</template>

<style>
[data-bs-theme="dark"] {
    --bs-body-bg: #191919;
}

body {
    height: 100vh;
}

#app {
    height: 100%;
}
</style>