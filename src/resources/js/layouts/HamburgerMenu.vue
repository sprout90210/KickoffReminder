<template>
  <div
    class="fixed inset-y-0 z-40 duration-300 pt-16 md:pt-20 w-2/3 md:w-5/12 flex flex-col bg-gray-800 text-lg text-white"
    :class="
      isMenuOpen
        ? 'left-0 md:left-auto md:right-0'
        : 'left-[-100%] md:left-auto md:right-[-100%]'
    "
  >
    <div v-if="!isLoggedIn" class="flex flex-wrap flex-col md:flex-row my-10 justify-center items-center">
      <router-link :to="{ name: 'EmailVerificationRequest' }" @click="toggleMenu" class="registration-link m-3">新規登録</router-link>
      <router-link :to="{ name: 'Login' }" @click="toggleMenu" class="login-link m-3">ログイン</router-link>
      <button @click="loginLine" class="line-login-link m-3">LINEログイン</button>
    </div>
    
    <ul v-else-if="isLoggedIn" class="flex flex-col items-center">
      <li class="my-4 hover:underline">
        <router-link :to="{ name: 'Home' }" @click="toggleMenu">ホームに戻る</router-link>
      </li>
      <li class="my-4 hover:underline">
        <router-link :to="{ name: 'Favorites' }" @click="toggleMenu">お気に入りチーム</router-link>
      </li>
      <li class="my-4 hover:underline">
        <router-link :to="{ name: 'Reminders' }" @click="toggleMenu">リマインダー</router-link>
      </li>
      <li v-if="!isLineUser" class="my-4 hover:underline">
        <router-link :to="{ name: 'EditUser' }" @click="toggleMenu">ユーザー情報変更</router-link>
      </li>
      <li v-if="!isLineUser" class="my-4 hover:underline">
        <router-link :to="{ name: 'EditPassword' }" @click="toggleMenu">パスワード変更</router-link>
      </li>
      <li class="my-4 hover:underline">
        <router-link :to="{ name: 'DeleteUser' }" @click="toggleMenu">退会</router-link>
      </li>
      <li class="my-4 hover:underline text-red-600 cursor-pointer" @click="logout">
          ログアウト
      </li>
    </ul>
  </div>
</template>

<script setup>
import { computed } from "vue";
import { useStore } from "vuex";
import { useRouter } from "vue-router";

const store = useStore();
const router = useRouter();
const isLoggedIn = computed(() => store.state.auth.isLoggedIn);
const isLineUser = computed(() => store.state.auth.isLineUser);
const isMenuOpen = computed(() => store.state.ui.isMenuOpen);

const toggleMenu = () => {
  store.commit("toggleMenu");
};

const logout = () => {
  axios
    .post("/api/logout")
    .then((res) => {
      store.dispatch("userStatusUpdate", {
        isLoggedIn: false,
        isLineUser: false,
        receiveReminder: false,
      });
      store.dispatch("triggerPopup", { message: "ログアウトしました。" });
      router.push("/");
    })
    .catch((e) => {
      store.dispatch("handleError", { e: e });
    })
    .finally(() => {
      store.commit("toggleMenu");
    });
};

const loginLine = () => {
  location.href = "/line/login";
};
</script>
