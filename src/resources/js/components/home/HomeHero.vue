<template>
  <div class="bg-home-1">
    <h1 class="text-5xl sm:text-8xl font-black">Kickoff Reminder</h1>
    <div class="text-lg sm:text-xl my-12 sm:mt-24 flex flex-col">
      <p>サッカーの試合を常に把握しましょう。</p>
      <p>簡単な登録だけで、好きなチームの試合通知が受け取れます。</p>
    </div>
    <div v-if="!isLoggedIn" class="flex flex-wrap items-center justify-center">
      <router-link :to="{ name: 'EmailVerificationRequest' }" class="registration-link m-3 sm:m-3">新規登録</router-link>
      <router-link :to="{ name: 'Login' }" class="login-link m-3 sm:m-3">ログイン</router-link>
      <button @click="loginLine" class="line-login-link m-2 sm:m-3">LINEログイン</button>
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