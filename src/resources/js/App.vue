<template>
  <div>
    <Header />
    <router-view></router-view>
    <Footer />
  </div>
</template>


<script setup>
import { onMounted } from "vue";
import { useStore } from "vuex";
import Header from './layouts/Header.vue';
import Footer from './layouts/Footer.vue';

const store = useStore();

onMounted(() => {
  store.dispatch('checkLoginStatus');
});
</script>
