<template>
  <div class="p-1 sm:p-8 border-b-purple">
    <div class="flex justify-between text-gray-400 text-xs ml-6 pb-1">
      <p>
      試合結果
      </p>
      <p>※日本時間</p>
    </div>
    <div v-for="(game, index) in results" :key="game.id" class="border-t">
      <Game :game="game" />
    </div>
  </div>
</template>

<script setup>
import Game from "./Game.vue";

const props = defineProps({
  results: {
    type: Array,
    required: true,
  },
});
</script>
