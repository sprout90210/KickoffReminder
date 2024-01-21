<template>
  <p class="text-base cursor-pointer my-2">
    <button v-if="!isFavorite" @click="toggleFavorite" type="submit" :disabled="isSubmitting" class="underline text-gray-500 hover:text-yellow-600">
      &#9734;
      <span class="hover:underline">お気に入り登録</span>
    </button>
    <button v-if="isFavorite" @click="toggleFavorite" type="submit" :disabled="isSubmitting" class="underline text-yellow-600 hover:text-gray-500">
      <span class=""> &#9733; </span>
      <span class="underline">お気に入り登録済み</span>
    </button>
  </p>
</template>

<script setup>
import FavoritesService from '../modules/FavoritesService.js';
import { ref } from "vue";
import { useStore } from "vuex";

const store = useStore();
const isFavorite = ref(false);
const isSubmitting = ref(false);
const props = defineProps({
  teamId: {
    type: String,
    required: true,
  },
});

const toggleFavorite = () => {
  FavoritesService.toggleFavorite(props.teamId, isSubmitting, isFavorite);
};
</script>
