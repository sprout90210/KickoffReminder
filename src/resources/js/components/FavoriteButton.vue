<template>
  <p class="text-base cursor-pointer my-2">
    <button v-if="!isFavorite" @click="toggleFavorite" type="submit" :disabled="isSubmitting" class="underline text-gray-500 md:hover:text-yellow-600">
      <span> &#9734; </span>
      <span class="underline">お気に入り登録</span>
    </button>
    <button v-if="isFavorite" @click="toggleFavorite" type="submit" :disabled="isSubmitting" class="underline text-yellow-600 md:hover:text-gray-500">
      <span> &#9733; </span>
      <span class="underline">お気に入り登録済み</span>
    </button>
  </p>
</template>

<script setup>
import { ref } from "vue";
import { useStore } from "vuex";

const props = defineProps({
  teamId: {
    type: String,
    required: true,
  },
});

const store = useStore();
const isFavorite = ref(false);
const isSubmitting = ref(false);

const toggleFavorite = () => {
  isSubmitting.value = true;
  const action = isFavorite.value ? "delete" : "post";
  const endpoint = isFavorite.value
    ? `/api/favorites/${props.teamId}`
    : "/api/favorites";
  const message = isFavorite.value
    ? "お気に入り解除しました。"
    : "お気に入り登録しました。";

  axios[action](endpoint, { team_id: props.teamId })
    .then(() => {
      isFavorite.value = !isFavorite.value;
      store.dispatch("triggerPopup", { message });
    })
    .catch((e) => {
      store.dispatch("handleFavoriteError", { error: e, isFavorite: isFavorite });
    })
    .finally(() => {
      isSubmitting.value = false;
    });
};
</script>
