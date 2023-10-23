<template>
  <div
    class="relative pt-2 pb-8 bg-gradient-to-tr from-gray-300 via-gray-50 to-white"
  >
    <div v-if="!isLoading" class="flex flex-row sm:flex-row justify-center items-center py-4">
      <div class="p-2 pr-4 sm:pl-16">
        <img
          :src="generateImgUrlDev(competition.emblem)"
          alt="emblem"
          class="w-20 h-20 sm:h-32 sm:w-32"
        />
      </div>
      <div class="flex flex-col items-center sm:mx-10">
        <h1 class="text-gray-800 text-lg font-bold">{{ competition.name }}</h1>
      </div>
    </div>
    <div v-else class="py-1 sm:py-8">
      <Loading />
    </div>
    <div class="flex absolute bottom-0 z-2 left-0 pl-3 sm:pl-12">
      <TabButton
        v-for="tab in tabs"
        :key="tab.tabName"
        :activeTab="activeTab"
        :tabName="tab.tabName"
        @click="tabChange(tab.tabName)"
      >
        {{ tab.label }}
      </TabButton>
    </div>
  </div>
</template>

<script setup>
import TabButton from "./TabButton.vue";
import Loading from "./Loading.vue";
import { ref, computed, watch, onMounted } from "vue";
import { useRoute } from "vue-router";

const route = useRoute();
const competition = ref();
const isLoading = ref(true);
const isOpen = ref(false);
const competitionId = computed(() => route.params.competitionId);
const tabs = [
  { tabName: "standings", label: "順位" },
  { tabName: "results", label: "結果" },
  { tabName: "schedules", label: "予定" },
];

const props = defineProps({
  activeTab: {
    type: String,
    required: true,
  },
});

const toggle = () => {
  isOpen.value = !isOpen.value;
};

const getCompetitionDetail = () => {
  isLoading.value = true;
  axios
    .get(`/api/competitions/${competitionId.value}`)
    .then((res) => {
      competition.value = res.data;
      isLoading.value = false;
    })
    .catch((e) => {
      console.log(e);
    });
};

const emit = defineEmits(["tabChange"]);
const tabChange = (tabName) => {
  emit("tabChange", tabName);
};

const generateImgUrlDev = (ImgName) => {
  const ImgUrl = "/images/" + ImgName;
  return ImgUrl;
};

onMounted(() => {
  getCompetitionDetail();
});

watch(route, () => {
  getCompetitionDetail();
});
</script>
