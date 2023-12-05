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
          <div class="duration-300" :class="isOpen ? 'rotate-180' : 'rotate-0'">
            <ChevronDownIcon />
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
        <div v-if="isLoading" class="pt-2">
          <Loading />
        </div>
        <div v-else>
          <p class="text-xxs text-right text-gray-400 pr-3 mt-2 border-b">※日本時間</p>
          <Game :game="nextGame" />
        </div>
      </td>
    </tr>
  </tbody>
</template>

<script setup>
import ChevronDownIcon from "../icons/ChevronDownIcon.vue";
import Loading from "./Loading.vue";
import Game from "./Game.vue";
import { ref, computed } from "vue";
import { useRoute } from "vue-router";

const route = useRoute();
const isOpen = ref(false);
const isLoading = ref(true);
const nextGame = ref();
const teamId = computed(() => route.params.teamId);

const props = defineProps({
  standing: {
    type: Object,
    required: true,
  },
});

const toggle = () => {
  isOpen.value = !isOpen.value;
  if (!nextGame.value) {
    isLoading.value = true;
    axios
      .get(`/api/teams/${props.standing.team_id}/nextGame`)
      .then((res) => {
        nextGame.value = res.data;
        isLoading.value = false;
      })
      .catch((e) => {
        console.log(e);
      });
  }
};

const generateCrestUrlDev = (crest) => {
  const crestUrl = "/images/" + crest;
  return crestUrl;
};
</script>
