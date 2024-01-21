<template>
  <div v-if="games.length" class="p-1 sm:py-5 w-full max-w-3xl text-gray-500">
    <p class="text-right text-xs border-b p-2">※試合時刻は日本時間です。</p>
    <Game v-for="game in games" :key="game.id" :game="game" class="border-b" />
    <p class="text-right text-xs my-3">※ 全てのコンペティションが表示されていない場合があります。</p>
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
