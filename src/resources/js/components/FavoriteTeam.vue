<template>
  <div
    class="rounded-lg border flex flex-col justify-center items-center m-1 p-1 sm:p-2 w-24 sm:w-36 h-28 sm:h-36 text-xxs sm:text-sm text-gray-600"
  >
    <p
      @click="deleteFavorite"
      class="mb-4 underline text-red-500 text-xxs sm:text-xs cursor-pointer"
    >
      お気に入り解除
    </p>
    <TeamCard :team="team" />
  </div>
</template>

<script setup>
import TeamCard from "./TeamCard.vue";
import FavoritesService from '../modules/FavoritesService.js';
import { computed } from "vue";
import { useStore } from "vuex";

const store = useStore();
const emit = defineEmits(["deleteFavorite"]);
const props = defineProps({
  team: {
    type: Object,
    required: true,
  },
});

const deleteFavorite = () => {
  FavoritesService.deleteFavorite(props.team.id, emit);
};
</script>
