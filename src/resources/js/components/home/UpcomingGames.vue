<template>
  <div v-if="upcomingGames.length" class="flex flex-col items-center">
    <h1 class="home-section-header bg-stone-800">
      試合情報
    </h1>
    <div class="max-w-2xl">
      <Game v-for="game in upcomingGames" :key="game.id" :game="game" class="border-b" />
    </div>
    <div class="p-5 text-xs text-right text-gray-700">
      ※時間は全て日本時間です。データの更新に時間がかかる場合があります。
    </div>
  </div>
</template>

<script setup>
import Game from "../Game.vue";
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
