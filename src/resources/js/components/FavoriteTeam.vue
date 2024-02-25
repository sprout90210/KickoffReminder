<template>
  <div class="rounded-lg border flex flex-col justify-center items-center m-1 p-1 sm:p-2 w-28 sm:w-36 h-28 sm:h-36 text-sm text-gray-600">
    <button @click="deleteFavorite" class="mb-4 underline text-red-500 text-xs">お気に入り解除</button>
    <TeamCard :team="team" />
  </div>
</template>

<script setup>
import TeamCard from "./TeamCard.vue";

const props = defineProps({
  team: {
    type: Object,
    required: true,
  },
});

const emit = defineEmits(["deleteFavorite"]);

const deleteFavorite = () => {
  emit("deleteFavorite", props.team.id);
};
</script>
