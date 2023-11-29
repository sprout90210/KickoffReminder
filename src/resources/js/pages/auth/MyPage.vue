<template>
  <div class="custom-container">
    <router-link to="/user/delete">退会</router-link>
    <router-link to="/user/edit">アカウント情報変更</router-link>
    <router-link to="/registration">登録登録</router-link>
    <button type="" class="hover:cursor-pointer hover:underline" @click="logout">
          ログアウト
        </button>
  </div>
</template>

<script setup>
import Loading from "../../components/Loading.vue";
import { ref, computed, watch, onMounted } from "vue";
import { useRoute, useRouter } from "vue-router";
import { useStore } from "vuex";

const route = useRoute();
const router = useRouter();
const store = useStore();
const activeTab = ref("standings");

const tabChange = (tabName) => {
  activeTab.value = tabName;
};

const logout = () => {
  axios.get("/sanctum/csrf-cookie").then((res) => {
    axios
      .post("/api/logout")
      .then((res) => {
        store.commit('setLoggedIn', false);
        store.dispatch("triggerPopup", { message: "ログアウトしました。" });
        router.push("/");
      })
      .catch((e) => {
          console.log(e);
      });
  });
};

</script>
