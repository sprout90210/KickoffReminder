<template>
<p class="text-xs my-2">
  <span v-if="isFavorite" @click="deleteFavorite" class="cursor-pointer ">
    <span class="text-yellow-500 ">
      &#9733;
    </span>
    <span class="hover:underline">
    お気に入り登録済
    </span>
  </span>
  <span v-else @click="storeFavorite" class="cursor-pointer">
    &#9734;
    <span class="hover:underline">
      お気に入り登録
    </span>
  </span>
</p>
    
</template>

<script setup>
import { ref } from "vue";
import { useStore } from "vuex";

const store = useStore();
const isFavorite = ref(false);
const props = defineProps({
  teamId: {
    type: String,
    required: true,
  },
})

// エラー処理
const handleFavoriteError = (e) => {
  if (e.response && e.response.status === 409) {
    isFavorite.value = true;
    store.dispatch("triggerPopup", {
      message: "このチームはすでにお気に入りに登録済みです。",
    });
  } else if (e.response && e.response.status === 401) {
    store.dispatch("triggerPopup", { message: "お気に入り登録するにはログインしてください。" });
  } else if (e.response && e.response.status === 422) {
    store.dispatch("triggerPopup", { message: "お気に入り数の上限に到達しました。" });
  } else {
    store.dispatch("triggerPopup", { message: "エラーが発生しました。" });
  }
};

const storeFavorite = () => {
  axios
    .post("/api/favorites", { team_id: props.teamId })
    .then((res) => {
      isFavorite.value = true;
      store.dispatch("triggerPopup", { message: "お気に入りに登録しました。" });
    })
    .catch(handleFavoriteError);
};
const deleteFavorite = () => {
  axios
    .delete(`/api/favorites/${props.teamId}`)
    .then((res) => {
      isFavorite.value = false;
      store.dispatch("triggerPopup", { message: "お気に入り登録解除しました。" });
    })
    .catch(handleFavoriteError);
};
</script>