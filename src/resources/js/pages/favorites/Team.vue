<template>
  <div
    class="rounded-lg border flex flex-col items-center m-1 p-1 sm:p-2 w-28 sm:w-36 h-28 sm:h-36 text-xs sm:text-sm text-gray-600"
  >
    <router-link
      v-if="favorite.team.short_name"
      :to="teamUrl"
      class="overflow-hidden hover:underline font-semibold"
    >
      {{ favorite.team.short_name }}
    </router-link>
    <router-link
      v-else
      :to="teamUrl"
      class="overflow-hidden hover:underline font-semibold"
    >
      {{ favorite.team.name }}
    </router-link>
    <router-link :to="teamUrl" class="w-12 h-12 sm:h-16 sm:w-16 m-2">
      <img :src="ImgUrlDev" class="w-full h-auto max-h-full object-contain" />
    </router-link>

    <p
      @click="deleteFavorite"
      class="my-1 underline text-red-500 text-xxs sm:text-xs cursor-pointer"
    >
      お気に入り解除
    </p>
  </div>
</template>

<script setup>
import { computed } from "vue";
import { useStore } from "vuex";

const store = useStore();
const emit = defineEmits(["deleteFavorite"]);
const props = defineProps({
  favorite: {
    type: Object,
    required: true,
  },
});

const ImgUrlDev = computed(() => {
  return "/images/crest/" + props.favorite.team.crest;
});

const teamUrl = computed(() => {
  return "/teams/" + props.favorite.team_id;
});

const deleteFavorite = () => {
  axios
    .delete(`/api/favorites/${props.favorite.team_id}`)
    .then((res) => {
      emit("deleteFavorite", props.favorite.team_id);
      store.dispatch("triggerPopup", { message: "お気に入り登録解除しました。" });
    })
    .catch((e) => {
      store.dispatch("triggerPopup", { message: "エラーが発生しました。" });
    });
};
</script>
