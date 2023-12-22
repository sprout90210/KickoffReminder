<template>
  <div class="hero-container">
    <Loading v-if="isLoading" />
    <div v-else class="flex flex-row sm:flex-row justify-center items-center">
      <div class="hero-img-container">
        <img
          :src="generateImgUrlDev(competition.emblem)"
          alt="emblem"
          class="custom-img"
        />
      </div>
      <div class="flex flex-col items-center sm:mx-10">
        <h1 class="text-gray-800 text-lg font-bold">{{ competition.name }}</h1>
      </div>
    </div>
    <TabList />
  </div>
</template>

<script setup>
import TabList from "./TabList.vue";
import Loading from "./Loading.vue";
import { ref, computed, watch, onMounted } from "vue";
import { useRoute, useRouter } from "vue-router";
import { useStore } from "vuex";

const store = useStore();
const route = useRoute();
const router = useRouter();
const competition = ref();
const isLoading = ref(true);
const competitionId = computed(() => route.params.competitionId);

const generateImgUrlDev = (ImgName) => {
  const ImgUrl = "/images/emblem/" + ImgName;
  return ImgUrl;
};

const handleError = (e) => {
  if (e.response.status === 404) {
    router.push("/not-found");
  } else{
    store.dispatch("triggerPopup", { message: "データ取得に失敗しました。" });
  }
};

const getCompetition = () => {
  isLoading.value = true;
  axios
    .get(`/api/competitions/${competitionId.value}`)
    .then((res) => {
      competition.value = res.data;
      isLoading.value = false;
    })
    .catch(handleError);
};

watch(() => route.params.competitionId, () => {
  getCompetition();
}, { immediate: true });
</script>
