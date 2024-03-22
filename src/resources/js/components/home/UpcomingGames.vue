<template>
  <div v-if="upcomingGames.length" class="flex flex-col items-center w-full">
    <h1 class="home-section-header w-full text-white bg-stone-800">直近の試合</h1>
    <Games :games="upcomingGames" class="border-b" />
  </div>
</template>

<script setup>
import Games from "../Games.vue";
import { ref, onMounted } from "vue";

const upcomingGames = ref([]);

const getUpcomingGames = () => {
  axios
    .get("/api/upcoming-games")
    .then((res) => {
      upcomingGames.value = res.data;
    });
};

onMounted(() => {
  getUpcomingGames();
});
</script>
