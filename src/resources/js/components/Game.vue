<template>
  <div class="h-28 text-xs flex flex-col justify-center sm:px-5">
    <p class="flex justify-between text-gray-500 p-2">
      <span>
        <router-link
          v-if="game.competition"
          :to="{ name: 'Competition', params: { competitionId: game.competition.id } }"
          class="mr-4 hover:underline"
        >
          {{ game.competition.name }}
        </router-link>
        <span class="hidden sm:inline">{{ game.group }}</span>
      </span>
      <span v-if="game.status === 'SCHEDULED' || game.status === 'TIMED'">試合予定</span>
      <span v-else-if="game.status === 'FINISHED'">試合終了</span>
    </p>

    <div class="h-20 flex items-center justify-center mb-1 text-sm text-gray-700">
      <TeamCard :team="game.home_team" />

      <div class="w-24 flex flex-col items-center justify-center pb-4 sm:mx-10">
        <div calss="font-light">
          <p v-if="game.status === 'IN_PLAY'" class="font-light text-green-500">試合中</p>
          <p v-else>
            {{ kickoff.date }}
          </p>
        </div>

        <div class="mt-1 text-xl font-bold">
          <p v-if="game.status === 'SCHEDULED'" class="text-sm font-light">時刻未定</p>
          <p v-else-if="game.status === 'TIMED'">{{ kickoff.time }}</p>
          <p v-else-if="game.status === 'IN_PLAY' || game.status === 'FINISHED'">
            <span>{{ game.home_team_score }}</span>
            <span class="mx-3">-</span>
            <span>{{ game.away_team_score }}</span>
          </p>
        </div>
      </div>

      <TeamCard :team="game.away_team" />
    </div>
  </div>
</template>

<script setup>
import TeamCard from "./TeamCard.vue";
import { computed } from "vue";

const props = defineProps({
  game:{
    type: Object,
    required: true,
  } 
});

const kickoff = computed(() => formatDateAndTime(props.game.utc_date));

const formatDateAndTime = (utcDate) => {
  const localDateTime = new Date(utcDate);
  localDateTime.setHours(localDateTime.getHours() + 9);
  const year = localDateTime.getFullYear();
  const month = (localDateTime.getMonth() + 1).toString().padStart(2, "0");
  const day = localDateTime.getDate().toString().padStart(2, "0");
  const hours = localDateTime.getHours().toString().padStart(2, "0");
  const minutes = localDateTime.getMinutes().toString().padStart(2, "0");
  return {
    date: `${year}/${month}/${day}`,
    time: `${hours}:${minutes}`,
  };
};
</script>
