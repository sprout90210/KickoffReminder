<template>
  <tbody>
    <tr
      class="text-center text-xs sm:text-sm font-light h-9 sm:h-10"
      :class="
        isOpen
          ? 'bg-gradient-to-r from-violet-600 via-purple-400 to-fuchsia-400 text-white'
          : 'text-gray-500 border-b border-gray-200'
      "
    >
      <td
        @click="toggle"
        class="cursor-pointer text-base"
        :class="
          isOpen
            ? 'bg-purple-900 text-white'
            : 'bg-zinc-100 text-gray-400 hover:bg-fuchsia-400 hover:text-white'
        "
      >
        <div
          class="transform transition-transform h-full w-full flex justify-center items-center"
        >
          <div class="duration-300" :class="isOpen ? 'rotate-90' : '-rotate-90'">
            &Lt;
          </div>
        </div>
      </td>

      <td>
        {{ standing.position }}
      </td>
      <td class="text-left">
        <router-link
          :to="{ name: 'TeamDetail', params: { teamId: standing.team_id } }"
          class="flex items-center"
          :class="
            teamId == standing.team_id
              ? 'font-bold hover:cursor-default'
              : 'hover:underline'
          "
        >
          <img
            :src="generateCrestUrlDev(standing.team.crest)"
            alt="crest"
            class="w-5 h-5 sm:h-6 sm:w-6 mr-2 sm:mr-4 block"
          />
          <span v-if="standing.team.short_name">
            {{ standing.team.short_name }}
          </span>
          <span v-else>
            {{ standing.team.name }}
          </span>
        </router-link>
      </td>
      <td class="hidden sm:table-cell">
        {{ standing.played_games }}
      </td>
      <td>
        {{ standing.won }}
      </td>
      <td>
        {{ standing.draw }}
      </td>
      <td>
        {{ standing.lost }}
      </td>
      <td class="hidden sm:table-cell">
        {{ standing.goals_for }}
      </td>
      <td class="hidden sm:table-cell">
        {{ standing.goals_against }}
      </td>
      <td class="hidden sm:table-cell">
        {{ standing.goal_difference }}
      </td>
      <td class="font-bold">
        {{ standing.points }}
      </td>
    </tr>
    <tr :class="isOpen ? 'table-row' : 'hidden'" class="border-b-2 border-gray-400">
      <td colspan="11">
        <Loading v-if="isLoading" />
        <div v-else class="m-0 py-8 h-full w-full flex justify-center">
          <div class="m-0 p-0">
            <div class="flex text-xs m-1 p-0 w-full">
              <p>{{ lastGame.season.competition.name }}</p>
              <p>{{ lastGame.utc_date }}</p>
            </div>
            <div class="flex">
              <div class="flex items-center justify-center text-xs font-bold">
                <div class="w-24 flex flex-col items-center justify-center">
                  <img
                    :src="generateCrestUrlDev(lastGame.home_team.crest)"
                    alt="crest"
                    class="w-10 h-10 m-3 p-0"
                  />
                  <p>{{ lastGame.home_team.name }}</p>
                </div>
                <div class="flex w-28 m-2 text-xl items-center justify-center">
                  <div class="m-4">{{ lastGame.home_team_score }}</div>
                  <div class="m-4">-</div>
                  <div class="m-4">{{ lastGame.away_team_score }}</div>
                </div>
                <div class="w-24 flex flex-col items-center justify-center">
                  <img
                    :src="generateCrestUrlDev(lastGame.away_team.crest)"
                    alt="crest"
                    class="w-10 h-10 m-3 p-0"
                  />
                  <div>{{ lastGame.away_team.name }}</div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </td>
    </tr>
  </tbody>
</template>

<script setup>
import Loading from "./Loading.vue";
import { ref, computed } from "vue";

const isOpen = ref(false);
const isLoading = ref(true);
const lastGame = ref({});
const nextGame = ref({});

const props = defineProps({
  standing: {
    type: Object,
    required: true,
  },
  teamId: String,
});

const convertedTime = computed(() => {
  const utcDate = new Date(lastGame.value.utc_date);
  const japanTime = new Date(utcDate.getTime() + 9 * 60 * 60 * 1000);
    return japanTime;
});

const toggle = () => {
  isOpen.value = !isOpen.value;
  isLoading.value = true;
  axios
    .get(`/api/teams/${props.standing.team_id}/recentGames`)
    .then((res) => {
      lastGame.value = res.data.lastGame;
      nextGame.value = res.data.nextGame;
      isLoading.value = false;
    })
    .catch((e) => {
      console.log(e);
    });
};

const generateCrestUrlDev = (crest) => {
  const crestUrl = "/images/" + crest;
  return crestUrl;
};
</script>
