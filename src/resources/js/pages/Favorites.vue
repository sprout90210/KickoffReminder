<template>
  <div class="flex flex-col flex-grow items-center p-2 sm:px-5">
    <h1 class="w-full my-3 sm:my-10 p-2 border-b-2 border-gray-400 text-center text-gray-600 font-semibold">お気に入り</h1>
    <Loading v-if="isLoading" />
    <div v-else-if="favorites.length" class="flex flex-wrap justify-center max-w-4xl">
      <FavoriteTeam
        v-for="favorite in favorites"
        :key="favorite.team_id"
        :team="favorite.team"
        @delete-favorite="deleteFavorite"
      />
    </div>
    <p v-else class="text-gray-400 my-16 text-lg">
      お気に入りチームを見つけましょう！
    </p>
    <router-link to="/" class="text-blue-400 hover:text-blue-500 my-10 text-sm underline">ホームに戻る</router-link>
  </div>
</template>

<script setup>
import handleError from "../modules/HandleError.js";
import Loading from "../components/Loading.vue";
import FavoriteTeam from "../components/FavoriteTeam.vue";
import { ref, onMounted } from "vue";
import { useStore } from "vuex";
import { useRouter } from "vue-router";

const store = useStore();
const router = useRouter();
const isLoading = ref(true);
const favorites = ref([]);

const deleteFavorite = (teamId) => {
  favorites.value = favorites.value.filter((favorite) => favorite.team_id !== teamId);
};

const getFavorites = () => {
  axios
    .get("/api/favorites")
    .then((res) => {
      favorites.value = res.data;
    })
    .catch((e) => {
      handleError(e);
    })
    .finally(() => {
      isLoading.value = false;
    });
};

onMounted(() => {
  getFavorites();
});
</script>