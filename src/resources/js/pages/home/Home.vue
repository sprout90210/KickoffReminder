<template>
  <div class="custom-container">
    <div class="w-full">
      <h2 class="w-full py-5 bg-indigo-950 text-lg text-white text-center font-bold">リーグから探す</h2>
      <div class="flex flex-wrap w-full bg-gray-100">
        <router-link
          to="/competitions/2014"
          class="flex-grow sm:flex-basis-0 sm:flex-1 h-32 sm:h-44 py-4 sm:py-5 bg-orange-200 hover:bg-orange-300 duration-300 flex flex-col items-center"
        >
          <p class="font-bold">ラ・リーガ</p>
          <img src="images/PD.png" alt="emblem" class="w-16 sm:w-24 m-3" />
        </router-link>

        <router-link
          to="/competitions/2021"
          class="flex-grow sm:flex-basis-0 sm:flex-1 h-32 sm:h-44 py-4 sm:py-5 bg-purple-200 hover:bg-purple-300 duration-300 flex flex-col items-center"
        >
          <p class="font-bold">プレミアリーグ</p>
          <img src="images/PL.png" alt="emblem" class="w-16 sm:w-24 m-3" />
        </router-link>

        <router-link
          to="/competitions/2017"
          class="flex-grow sm:flex-basis-0 sm:flex-1 h-32 sm:h-44 py-4 sm:py-5 bg-sky-200 hover:bg-sky-300 duration-300 flex flex-col items-center"
        >
          <p class="font-bold">セリエ A</p>
          <img src="images/SA.png" alt="emblem" class="w-16 sm:w-24 m-3" />
        </router-link>

        <router-link
          to="/competitions/2002"
          class="flex-grow sm:flex-basis-0 sm:flex-1 h-32 sm:h-44 py-4 sm:py-5 bg-red-200 hover:bg-red-300 duration-300 flex flex-col items-center"
          ><p class="font-bold">ブンデスリーガ</p>
          <img src="images/BL1.png" alt="emblem" class="w-16 sm:w-24 m-3" />
        </router-link>

        <router-link
          to="/competitions/2015"
          class="flex-grow sm:flex-basis-0 sm:flex-1 h-32 sm:h-44 py-4 sm:py-5 bg-blue-200 hover:bg-blue-300 duration-300 flex flex-col items-center"
          ><p class="font-bold">リーグ・アン</p>
          <img src="images/FL1.png" alt="emblem" class="w-16 sm:w-24 m-3" />
        </router-link>

        <router-link
          to="/competitions/2015"
          class="flex-grow sm:flex-basis-0 sm:flex-1 h-32 sm:h-44 py-4 sm:py-5 bg-gray-200 hover:bg-gray-300 duration-300 flex flex-col items-center"
          >
          <p class="font-bold sm:hidden">UEFA CL</p>
          <p class="font-bold hidden sm:block">チャンピオンズリーグ</p>
          <img src="images/CL.png" alt="emblem" class="w-16 sm:w-24 m-3" />
        </router-link>
      </div>
    </div>

    <div>
      <button @click="getUser" class="custom-submit">ユーザー情報取得</button>
      <button @click="sendLine" class="custom-submit">lineそうしん</button>
    </div>
  </div>
</template>

<style>
/* .bg-img {
  @apply w-full h-screen bg-cover bg-center;
  background-image: url("images/ball.jpeg");
} */
</style>

<script setup>
import { onMounted } from "vue";
import { useRoute } from "vue-router";
import { useStore } from "vuex";

const route = useRoute();
const store = useStore();

const sendLine = () => {
  axios
    .post("/api/send-line")
    .then((res) => {
      console.log(res.data);
    })
    .catch((e) => {
      console.log(e);
    });
};

const getUser = () => {
  axios.get("/sanctum/csrf-cookie").then((res) => {
    axios
      .get("/api/user")
      .then((res) => {
        console.log(res.data);
      })
      .catch((e) => {
        console.log(e);
      });
  });
};

onMounted(() => {
  const query = route.query;
  if (query.line_login === "success") {
    store.dispatch("triggerPopup", { message: "LINEログインに成功しました。" });
  } else if (query.line_login === "faild") {
    store.dispatch("triggerPopup", { message: "LINEログインに失敗しました。" });
  }
});
</script>
