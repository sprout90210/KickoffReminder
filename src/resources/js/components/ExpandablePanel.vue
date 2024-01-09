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
            : 'bg-zinc-100 text-gray-400 hover:bg-fuchsia-500 hover:text-white'
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
          <div class="w-6 h-6 mr-2 flex items-center">
            <img
              :src="generateCrestUrlDev(standing.team.crest)"
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
        <NotFound v-else-if="!nextGame" />
        <div v-else>
          <p class="text-xxs text-right text-gray-400 pr-3 mt-4 border-b">※日本時間</p>
          <Game :game="nextGame" />
        </div>
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
import { useStore } from "vuex";

const store = useStore();
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
      })
      .catch((e) => {
        nextGame.value = false;
      })
      .finally(() => {
        isLoading.value = false;
      });
  }
};

const generateCrestUrlDev = (crest) => {
  const crestUrl = "/images/crest/" + crest;
  return crestUrl;
};
</script>
