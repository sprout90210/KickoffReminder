<template>
  <div class="bg-home-1">
    <h1 class="text-6xl md:text-8xl font-black flex flex-col sm:flex-row items-start">
      <p class="sm:mr-10">Kickoff</p>
      <p>Reminder</p>
    </h1>
    <p class="subtitle text-gray-200 text-sm sm:text-base my-2">サッカー専門の試合通知サービス</p>
    <div v-if="!isLoggedIn" class="flex flex-wrap items-center justify-center sm:my-8">
      <router-link :to="{ name: 'EmailVerificationRequest' }" class="registration-link m-2 sm:m-5">新規登録</router-link>
      <router-link :to="{ name: 'Login' }" class="login-link m-2 sm:m-5">ログイン</router-link>
      <button @click="loginLine" class="line-login-link m-2 sm:m-5">LINEログイン</button>
    </div>
    <div class="text-sm sm:text-lg flex flex-col sm:flex-row items-start font-bold" :class="isLoggedIn ? 'my-20' : 'my-6'">
      <p class="mb-2">お気に入り登録一つで、</p>
      <p>あなたが応援するチームの試合時刻をお知らせします。</p>
    </div>
  </div>
</template>

<script setup>
import { computed, onMounted } from "vue";
import { useStore } from "vuex";

const store = useStore();
const isLoggedIn = computed(() => store.state.auth.isLoggedIn);

const loginLine = () => {
  location.href = "/line/login";
};
</script>