<template>
  <div class="flex flex-col flex-grow items-center p-2 sm:px-5">
    <h1
      class="my-3 sm:my-10 p-1 border-b-2 border-gray-400 w-full flex items-end justify-between"
    >
      <span class="text-gray-600 font-semibold"> 試合通知リスト </span>
      <span class="text-gray-400 text-xs">※日本時間です。</span>
    </h1>

    <Loading v-if="isLoading" />
    <ul
      v-else-if="games && games.length !== 0"
      class="flex flex-col min-w-[50%] justify-center"
    >
      <li v-for="game in games" :key="game.id">
        <Game :game="game" class="border-b mx-1" />
      </li>
    </ul>

    <div v-else class="text-gray-400 my-12 text-xs sm:text-lg">
      試合通知を受け取りましょう！
    </div>

    <router-link to="/" class="text-blue-400 hover:text-blue-500 my-10 text-sm underline">
      ホームに戻る
    </router-link>
  </div>
</template>

<script setup>
import Loading from "../../components/Loading.vue";
import Game from "../../components/game/Game.vue";
import { ref, onMounted } from "vue";
import { useStore } from "vuex";

const store = useStore();
const isLoading = ref(true);
const games = ref([]);

const getReminders = () => {
  axios
    .get("/api/reminders")
    .then((res) => {
      isLoading.value = false;
      games.value = res.data;
    })
    .catch((e) => {
      isLoading.value = false;
      if (e.response && e.response.status === 404) {
        store.dispatch("triggerPopup", { message: "通知を受け取る試合はありません。" });
      } else {
        store.dispatch("triggerPopup", { message: "データ取得に失敗しました。" });
      }
    });
};

onMounted(() => {
  getReminders();
});
</script>
