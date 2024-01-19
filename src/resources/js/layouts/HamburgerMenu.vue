<template>
  <div
    class="fixed top-0 z-40 duration-300 pt-24 w-5/6 md:w-5/12 h-screen flex flex-col bg-gray-800 text-sm md:text-base text-white"
    :class="
      isMenuOpen
        ? 'left-0 md:left-auto md:right-0'
        : 'left-[-100%] md:left-auto md:right-[-100%]'
    "
  >
    <div v-if="!isLoggedIn" class="flex flex-wrap mb-10 justify-center items-center">
      <router-link to="/registration" @click="toggleMenu" class="registration-link m-3">新規登録</router-link>
      <router-link to="/login" @click="toggleMenu" class="login-link m-3">ログイン</router-link>
      <button @click="loginLine" class="line-login-link m-3">LINEログイン</button>
    </div>
    
    <ul v-if="isLoggedIn" class="flex flex-col items-center">
      <li class="my-3 hover:underline">
        <router-link to="/favorites" @click="toggleMenu">お気に入りチーム</router-link>
      </li>
      <li class="my-3 hover:underline">
        <router-link to="/reminders" @click="toggleMenu">通知リスト</router-link>
      </li>
      <li v-if="!isLineUser" class="my-3 hover:underline">
        <router-link to="/user/edit" @click="toggleMenu">ユーザー情報変更</router-link>
      </li>
      <li v-if="!isLineUser" class="my-3 hover:underline">
        <router-link to="/password/edit" @click="toggleMenu">パスワード変更</router-link>
      </li>
      <li class="my-3 hover:underline">
        <router-link to="/user/delete" @click="toggleMenu">退会</router-link>
      </li>
      <li class="my-3">
        <button @click="logout" type="button" class="cursor-pointer hover:underline">
          ログアウト
        </button>
      </li>
    </ul>
  </div>
</template>

<script setup>
import handleError from "../modules/HandleError.js";
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
      handleError(e);
    })
    .finally(() => {
      store.commit("toggleMenu");
    });
};

const loginLine = () => {
  location.href = "/line/login";
};
</script>
