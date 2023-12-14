<template>
  <div
    class="fixed top-0 z-40 duration-300 pt-24 w-5/6 sm:w-4/12 h-screen flex flex-col bg-gray-800 text-sm text-white"
    :class="isMenuOpen ? 'right-0' : 'right-[-100%]'"
  >
    <div class="mb-5 flex flex-col items-center" v-if="!isLoggedIn">
      <div class="flex mb-10">
        <router-link
          to="/login"
          @click="toggleMenu"
          class="login-link"
          >ログイン</router-link
        >
        <router-link
          to="/registration"
          @click="toggleMenu"
          class="registration-link"
        >
          新規登録
        </router-link>
      </div>
      <button @click="loginLine" class="line-login-link">LINEログイン</button>
    </div>
    <ul class="flex flex-col items-center"  v-if="isLoggedIn">
      <li class="my-3 hover:underline">
        <router-link to="/favorites" @click="toggleMenu">お気に入りチーム</router-link>
      </li>
      <li class="my-3 hover:underline">
        <router-link to="/reminders" @click="toggleMenu">通知リスト</router-link>
      </li>
      <li v-if="!isLineUser" class="my-3 hover:underline">
        <router-link to="/user/edit" @click="toggleMenu">ユーザー情報変更</router-link>
      </li>
      <li class="my-3 hover:underline">
        <router-link to="/user/delete" @click="toggleMenu">退会</router-link>
      </li>
      <li class="my-3">
        <button
          type="button"
          class="cursor-pointer hover:underline"
          @click="logout"
        >
          ログアウト
        </button>
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
const isLoggedIn = computed(() => store.state.isLoggedIn);
const isLineUser = computed(() => store.state.isLineUser);
const isMenuOpen = computed(() => store.state.isMenuOpen);

const toggleMenu = () => {
  store.commit("toggleMenu");
};

const logout = () => {
  axios.get("/sanctum/csrf-cookie").then((res) => {
    axios
      .post("/api/logout")
      .then((res) => {
        store.commit("toggleMenu");
        store.dispatch("logout");
        store.dispatch("triggerPopup", { message: "ログアウトしました。" });
        router.push("/");
      })
      .catch((e) => {
        store.dispatch("triggerPopup", { message: "ログアウトに失敗しました。" });
      });
  });
};

const loginLine = () => {
  location.href = "/line/login";
};
</script>
