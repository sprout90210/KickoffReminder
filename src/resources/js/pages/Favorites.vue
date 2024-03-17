<template>
  <div class="flex flex-col flex-grow items-center p-2 sm:px-5">
    <h1 class="mypage-header">
      <span>お気に入りチーム</span>
      <router-link :to="{ name: 'Reminders' }" class="absolute bottom-2 left-1 md:left-14 text-blue-600 hover:text-blue-700 text-sm underline">リマインダー</router-link>
    </h1>
    <Loading v-if="isLoading" />
    <div v-else-if="favorites.length" class="flex flex-wrap justify-center max-w-4xl">
      <FavoriteTeam
        v-for="favorite in favorites"
        :key="favorite.team_id"
        :team="favorite.team"
        @delete-favorite="deleteFavorite"
      />
    </div>
    <p v-else class="text-gray-400 my-16 text-lg">お気に入りチームを見つけましょう！</p>
    <router-link :to="{ name: 'Home' }" class="text-blue-400 hover:text-blue-500 my-10 text-sm underline">ホームに戻る</router-link>
  </div>
</template>

<script setup>
import Loading from "../components/Loading.vue";
import FavoriteTeam from "../components/FavoriteTeam.vue";
import { ref, onMounted } from "vue";
import { useRouter } from "vue-router";
import { useStore } from "vuex";

const store = useStore();
const router = useRouter();
const isLoading = ref(true);
const favorites = ref([]);

const deleteFavorite = (teamId) => {
  axios
    .delete(`/api/favorites/${teamId}`)
    .then(() => {
      favorites.value = favorites.value.filter((favorite) => favorite.team_id !== teamId);
      store.dispatch("triggerPopup", { message: "お気に入り解除しました。" });
    })
    .catch((e) => {
      store.dispatch("handleFavoriteError", { error: e });
    });
};

const getFavorites = () => {
  axios
    .get("/api/favorites")
    .then((res) => {
      favorites.value = res.data;
    })
    .catch((e) => {
      store.dispatch("handleError", { error: e, router: router });
    })
    .finally(() => {
      isLoading.value = false;
    });
};

onMounted(() => {
  getFavorites();
});
</script>