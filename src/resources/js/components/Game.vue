<template>
  <div class="h-28 text-xxs flex flex-col justify-center sm:px-4">
    <p class="flex justify-between text-gray-500 p-2">
      <span>
        <span class="mr-4">{{ game.competition.name }}</span>
        <span class="hidden sm:inline">{{ game.group }}</span>
      </span>
      <span v-if="game.status === 'FINISHED' || game.status === 'IN_PLAY'">
        {{ kickoff.date }}
      </span>
      <span v-else-if="game.status === 'TIMED'">試合予定</span>
    </p>

    <div class="h-20 flex items-center justify-center mb-1 sm:text-sm text-gray-600">
      <TeamCard :team="game.home_team" />
      <div class="w-20 flex flex-col items-center justify-center pb-4 sm:mx-10">
        <p
          v-if="game.status === 'TIMED' || game.status === 'SCHEDULED'"
          class="font-light"
        >
          {{ kickoff.date }}
        </p>
        <p v-if="game.status === 'TIMED'" class="mt-1 text-lg font-semibold">
          {{ kickoff.time }}
        </p>
        <p v-if="game.status === 'SCHEDULED'" class="mt-2 text-md">時刻未定</p>
        <p v-if="game.status === 'IN_PLAY'" class="font-light text-green-500">試合中</p>
        <p
          v-if="game.status === 'FINISHED' || game.status === 'IN_PLAY'"
          class="pt-1 text-xl"
        >
          <span>{{ game.home_team_score }}</span>
          <span class="mx-3">-</span>
          <span>{{ game.away_team_score }}</span>
        </p>
      </div>
      <TeamCard :team="game.away_team" />
    </div>
  </div>
</template>

<script setup>
import TeamCard from "./TeamCard.vue";
import { ref, computed, onMounted } from "vue";

const props = defineProps({
  game: Object,
  required: true,
});

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
const kickoff = computed(() => formatDateAndTime(props.game.utc_date));
</script>
