<template>
  <div class="h-28 text-xxs flex flex-col justify-center sm:px-4">
    <p class="flex justify-between text-gray-500 sm:text-xs p-2">
      <span>
        <span class="mr-4">{{ game.season.competition.name }}</span>
        <span class="hidden sm:inline">{{ game.group }}</span>
      </span>
      <span v-if="game.status === 'FINISHED' || game.status === 'IN_PLAY'">{{ kickoffDate }}</span>
      <span v-if="game.status === 'TIMED'">試合予定</span>
    </p>

    <div class="flex h-20 items-center sm:text-sm justify-center mb-2 text-gray-700">
      <div class="w-24 sm:w-32">
        <router-link
          :to="{ name: 'TeamDetail', params: { teamId: game.home_team_id } }"
          class="h-16 flex flex-col items-center justify-center"
        >
          <img
            :src="generateCrestUrlDev(game.home_team.crest)"
            alt="crest"
            class="w-7 h-7 sm:w-9 sm:h-9 mb-2"
          />
          <p v-if="game.home_team.short_name">{{ game.home_team.short_name }}</p>
          <p v-else>{{ game.home_team.name }}</p>
        </router-link>
      </div>

      <div class="w-20 flex sm:mx-10 items-center justify-center pb-4 flex-col">
        <p v-if="game.status === 'TIMED'" class="font-light">{{ kickoffDate }}</p>
        <p v-if="game.status === 'TIMED'" class="pt-1 text-xl">{{ kickoffTime }}</p>
        <p v-if="game.status === 'IN_PLAY'" class="font-light text-green-500">試合中</p>
        <p v-if="game.status === 'FINISHED' || game.status === 'IN_PLAY'" class="pt-1 text-xl">
          <span>{{ game.home_team_score }}</span>
          <span class="mx-3">-</span>
          <span>{{ game.away_team_score }}</span>
        </p>
      </div>

      <div class="w-24 sm:w-32 flex items-center justify-center flex-col">
        <router-link :to="{ name: 'TeamDetail', params: { teamId: game.away_team_id } }">
          <img
            :src="generateCrestUrlDev(game.away_team.crest)"
            alt="crest"
            class="w-7 h-7 sm:w-9 sm:h-9 mb-2"
          />
        </router-link>
        <router-link :to="{ name: 'TeamDetail', params: { teamId: game.away_team_id } }">
          <p v-if="game.away_team.short_name">{{ game.away_team.short_name }}</p>
          <p v-else>{{ game.away_team.name }}</p>
        </router-link>
      </div>
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
