<template>
  <div
    class="fixed top-0 z-40 duration-300 pt-24 w-5/6 sm:w-4/12 h-screen flex flex-col bg-gray-800 text-sm text-white"
    :class="isMenuOpen ? 'right-0' : 'right-[-100%]'"
  >
    <div class="mb-5 flex flex-col items-center" v-if="!isLoggedIn">
      <div class="flex mb-4">
        <router-link
          to="/login"
          @click="toggleMenu"
          class="py-3 w-24 text-center block rounded border border-gray-300 hover:border-white text-gray-300 hover:text-white duration-200"
          >ログイン</router-link
        >
        <router-link
          to="/registration"
          @click="toggleMenu"
          class="py-3 w-24 ml-4 text-center block rounded bg-sky-500 hover:bg-sky-600 duration-200"
        >
          新規登録
        </router-link>
      </div>
      <button @click="loginLine" class="line-login-btn">LINEログイン</button>
    </div>
    <ul class="flex flex-col items-center"  v-if="isLoggedIn">
      <li class="my-3 hover:underline">
        <router-link to="/mypage" @click="toggleMenu">マイページ</router-link>
      </li>
      <li class="my-3">
        <button
          type="button"
          class="hover:cursor-pointer hover:underline"
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
