<template>
  <div v-if="upcomingGames" class="flex flex-col flex-wrap">
    <h1 class="py-5 bg-stone-800 font-bold text-lg text-center text-white">試合情報</h1>
    <div>
      <div v-for="game in upcomingGames" :key="game.id" class="border-b">
        <Game :game="game" />
      </div>
    </div>
    <div class="p-5 text-xs text-right text-gray-700 ">
      ※時間は全て日本時間です。データの更新に時間がかかる場合があります。
    </div>
  </div>
</template>

<script setup>
import Game from "./Game.vue";
import { ref, computed, onMounted } from "vue";

const upcomingGames = ref();

const getUpcomingGames = () => {
  axios.get("/sanctum/csrf-cookie").then((res) => {
    axios
      .get("/api/upcoming-games")
      .then((res) => {
        upcomingGames.value = res.data;
      })
      .catch((e) => {
        console.log(e);
      });
  });
};

onMounted(() => {
  getUpcomingGames();
});
</script>
