<template>
  <div class="h-32 text-xs flex flex-col justify-center">
    <div class="flex justify-between text-gray-500 p-2 sm:pl-4">
      <span>
        <span class="mr-3">{{ game.season.competition.name }}</span>
        <span>{{ game.group }}</span>
      </span>
      <span v-if="game.status === 'FINISHED'">{{ kickoffDate }} 試合終了</span>
      <span v-if="game.status === 'TIMED'">試合予定</span>
    </div>

    <div class="flex items-center sm:text-base justify-center font-bold">
      <router-link
        :to="{ name:'TeamDetail', params:{ teamId: game.home_team_id }}"
        class="w-28 sm:w-48 h-24 flex flex-col items-center justify-center"
      >
        <img
          :src="generateCrestUrlDev(game.home_team.crest)"
          alt="crest"
          class="w-8 h-8 m-2"
        />
        <p v-if="game.home_team.short_name">{{ game.home_team.short_name }}</p>
        <p v-else>{{ game.home_team.name }}</p>
      </router-link>
      <div
        v-if="game.status === 'TIMED'"
        class="flex-col flex w-16 pb-8 sm:mx-10 items-center justify-center"
      >
        <p class="font-light">{{ kickoffDate }}</p>
        <p class="pt-1 text-xl">{{ kickoffTime }}</p>
      </div>
      <div
        v-if="game.status === 'FINISHED'"
        class="flex w-16 text-xl sm:mx-10 items-center justify-center"
      >
        <span class="mr-3">{{ game.home_team_score }}</span>
        <span>-</span>
        <span class="ml-3">{{ game.away_team_score }}</span>
      </div>
      <router-link :to="{ name:'TeamDetail', params:{ teamId: game.away_team_id }}" class="w-28 sm:w-48 h-24 flex flex-col items-center justify-center">
        <img
          :src="generateCrestUrlDev(game.away_team.crest)"
          alt="crest"
          class="w-8 h-8 m-2"
        />
        <p v-if="game.away_team.short_name">{{ game.away_team.short_name }}</p>
        <p v-else>{{ game.away_team.name }}</p>
      </router-link>
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from "vue";

const props = defineProps({
  game: Object,
  required: true,
});

const kickoffDate = computed(() => {
  const utcDateTime = new Date(props.game.utc_date);
  utcDateTime.setHours(utcDateTime.getHours() + 9);
  const year = utcDateTime.getFullYear();
  const month = (utcDateTime.getMonth() + 1).toString().padStart(2, "0");
  const day = utcDateTime.getDate().toString().padStart(2, "0");
  return `${year}/${month}/${day}`;
});

const kickoffTime = computed(() => {
  const utcDateTime = new Date(props.game.utc_date);
  utcDateTime.setHours(utcDateTime.getHours() + 9);
  const hours = utcDateTime.getHours().toString().padStart(2, "0");
  const minutes = utcDateTime.getMinutes().toString().padStart(2, "0");
  return `${hours}:${minutes}`;
});

const generateCrestUrlDev = (crest) => {
  const crestUrl = "/images/" + crest;
  return crestUrl;
};
</script>
