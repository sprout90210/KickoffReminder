<template>
  <div class="flex flex-col flex-grow items-center p-2 sm:px-5">
    <h1 class="mypage-header">
      <router-link :to="{ name: 'Favorites' }" class="absolute bottom-2 left-1 md:left-14 text-blue-600 hover:text-blue-700 text-sm underline">お気に入り</router-link>
      <span>試合通知リスト</span>
      <span class="absolute right-1 bottom-2 text-gray-400 text-xs font-light">※日本時間</span>
    </h1>

    <div class="flex items-center text-sm text-gray-600 mb-8">
      <select
        @change="changeRemindTime"
        v-model="remindTime"
        id="remindTime"
        class="h-9 w-32 text-sm mx-5 text-gray-600 px-2 rounded shadow-lg shadow-gray-600/40 hover:cursor-pointer"
      >
        <option value="1">試合開始直前</option>
        <option value="15">試合15分前</option>
        <option value="60">試合1時間前</option>
        <option value="180">試合3時間前</option>
      </select>

      <label for="receiveReminder" class="mr-1 text-sm text-gray-600 hover:cursor-pointer">通知を受け取る</label>
      <input v-model="receiveReminder" @change="toggleReceiveReminder" type="checkbox" id="receiveReminder" class="hover:cursor-pointer">
    </div>

    <Loading v-if="isLoading" />
    <Games v-else-if="games.length" :games="games" />
    <p v-else class="text-gray-400 my-16 text-lg">試合通知を受け取りましょう！</p>
    <router-link :to="{ name: 'Home' }" class="text-blue-400 hover:text-blue-500 my-10 text-sm underline">ホームに戻る</router-link>
  </div>
</template>

<script setup>
import Loading from "../components/Loading.vue";
import Games from "../components/Games.vue";
import { ref, computed, onMounted } from "vue";
import { useRouter } from "vue-router";
import { useStore } from "vuex";

const router = useRouter();
const store = useStore();
const isLoading = ref(true);
const games = ref([]);
const remindTime = computed({
  get: () => store.state.auth.remindTime,
  set: value => store.commit("setRemindTime", value) 
});
const receiveReminder = computed({
  get: () => store.state.auth.receiveReminder,
  set: value => store.commit("setReceiveReminder", value) 
});

const changeRemindTime = () => {
  axios
    .put("/api/remind-time", { remindTime: remindTime.value })
    .then((res) => {
      store.dispatch("triggerPopup", { message: "通知時間を変更しました。", color: "green" });
    })
    .catch((e) => {
      store.dispatch("handleError", { error: e, router: router });
    });
};

const toggleReceiveReminder = () => {
  axios
    .put("/api/receive-reminder", { receiveReminder: receiveReminder.value })
    .then((res) => {
      store.dispatch("triggerPopup", { message: "設定を変更しました。", color: "green" });
    })
    .catch((e) => {
      store.commit("setReceiveReminder", !receiveReminder.value);
      store.dispatch("handleError", { error: e, router: router });
    });
};

const getReminders = () => {
  isLoading.value = true;
  axios
    .get("/api/reminders")
    .then((res) => {
      games.value = res.data.reminders;
      receiveReminder.value = res.data.receiveReminder;
      remindTime.value = res.data.remindTime;
    })
    .catch((e) => {
      store.dispatch("handleError", { error: e, router: router });
    })
    .finally(() => { isLoading.value = false; });
};

onMounted(() => {
  getReminders();
});
</script>
