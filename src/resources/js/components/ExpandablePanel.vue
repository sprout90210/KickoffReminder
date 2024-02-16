<template>
  <tbody>
    <tr
      class="text-center text-sm font-light h-10"
      :class="
        isOpen
          ? 'bg-gradient-to-r from-violet-600 via-purple-500 to-fuchsia-500 text-white'
          : 'text-gray-600 border-b border-gray-200'
      "
    >
      <td
        @click="toggle"
        class="cursor-pointer text-base"
        :class="
          isOpen
            ? 'bg-purple-900 text-white'
            : 'bg-zinc-100 text-gray-400 md:hover:bg-fuchsia-500 md:hover:text-white'
        "
      >
        <div class="transform transition-transform h-full w-full flex justify-center items-center">
          <div class="duration-200" :class="isOpen ? 'rotate-180' : 'rotate-0'">
            <ChevronDownIcon />
          </div>
        </div>
      </td>

      <td>{{ standing.position }}</td>
      <td class="text-left">
        <router-link
          :to="{ name: 'Team', params: { teamId: standing.team_id } }"
          class="flex items-center"
          :class="
            teamId == standing.team_id
              ? 'font-bold hover:cursor-default'
              : 'hover:underline'
          "
        >
          <div class="w-6 h-6 mr-2 custom-img-container">
            <img
              :src="crestUrl"
              alt="crest"
              class="custom-img"
            />
          </div>
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
        <div v-else-if="nextGame">
          <p class="flex relative items-center justify-center px-3 py-1 border-b">
            <span class="text-purple-400 text-sm">Next Match</span>
            <span class="absolute right-1 text-xxs text-gray-500">※時刻は日本時間です</span>
          </p>
          <Game :game="nextGame" />
        </div>
        <NotFound v-else />
      </td>
    </tr>
  </tbody>
</template>

<script setup>
import ChevronDownIcon from "./icons/ChevronDownIcon.vue";
import Loading from "./Loading.vue";
import Game from "./Game.vue";
import NotFound from "./NotFound.vue";
import { ref, computed } from "vue";
import { useRoute } from "vue-router";

const props = defineProps({
  standing: {
    type: Object,
    required: true,
  },
});

const route = useRoute();
const isOpen = ref(false);
const isLoading = ref(true);
const nextGame = ref();
const teamId = computed(() => route.params.teamId);
const crestUrl = computed(() => `https://kickoffreminder-bucket.s3.ap-northeast-1.amazonaws.com/crest/${props.standing.team.crest}` );

const toggle = () => {
  isOpen.value = !isOpen.value;
  if (!nextGame.value) {
    isLoading.value = true;
    axios
      .get(`/api/teams/${props.standing.team_id}/nextGame`)
      .then((res) => {
        nextGame.value = res.data;
      })
      .catch((e) => {
        nextGame.value = false;
      })
      .finally(() => {
        isLoading.value = false;
      });
  }
};
</script>
