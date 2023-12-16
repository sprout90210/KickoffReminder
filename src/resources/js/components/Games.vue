<template>
  <div v-if="games.length" class="p-1 sm:py-10 w-full max-w-3xl">
    <p class="text-right text-gray-400 text-xxs w-full border-b pr-3">※日本時間</p>
    <Game v-for="game in games" :key="game.id" :game="game" class="border-b" />
  </div>
  <NotFound v-else />
</template>

<script setup>
import Game from "./Game.vue";
import NotFound from "./NotFound.vue";
 
const props = defineProps({
  games: {
    type: Array,
    required: true,
  },
});
</script>
