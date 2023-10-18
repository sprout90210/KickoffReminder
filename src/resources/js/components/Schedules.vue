<template>
  <div class="p-1 sm:p-8">
    <p class="text-right text-gray-400 text-xxs border-b pr-3 mt-2">※日本時間</p>
    <div v-for="(game, index) in schedules" :key="game.id" class="border-b">
      <Game :game="game" />
    </div>
  </div>
</template>

<script setup>
import Game from "./Game.vue";

const props = defineProps({
  schedules: {
    type: Array,
    required: true,
  },
});
</script>
