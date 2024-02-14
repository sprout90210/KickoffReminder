<template>
  <div class="hero-container">
    <Loading v-if="isLoading" />
    <div v-else class="flex flex-row sm:flex-row justify-center items-center">
      <div class="hero-img-container">
        <img
          :src="emblemUrl"
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

const route = useRoute();
const router = useRouter();
const competition = ref();
const isLoading = ref(true);
const competitionId = computed(() => route.params.competitionId);
const emblemUrl = computed(() => `https://kickoffreminder-bucket.s3.ap-northeast-1.amazonaws.com/emblem/${competition.value.emblem}` );

const getCompetition = () => {
  isLoading.value = true;
  axios
    .get(`/api/competitions/${competitionId.value}`)
    .then((res) => {
      competition.value = res.data;
    })
    .catch((e) => {
      router.push("/not-found");
    })
    .finally(() => {
      isLoading.value = false;
    });
};

watch(
  () => route.params.competitionId,
  () => {
    getCompetition();
  },
  { immediate: true }
);
</script>
