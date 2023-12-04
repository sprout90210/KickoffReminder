<template>
  <div class="flex flex-col min-h-screen">
    <Header />
    <Popup />
    <router-view />
    <Footer />
  </div>
</template>


<script setup>
import Header from './layouts/Header.vue';
import Popup from "./layouts/Popup.vue";
import Footer from './layouts/Footer.vue';

</script>
