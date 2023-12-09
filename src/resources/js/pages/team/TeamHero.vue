<template>
  <div
    class="relative pt-5 pb-12 sm:pb-16 text-gray-700 bg-gradient-to-tr from-gray-300 via-gray-50 to-white"
  >
    <div v-if="!isLoading" class="flex flex-col sm:flex-row justify-center items-center">
      <div class="p-2 sm:pl-16">
        <img
          :src="generateImgUrlDev(team.crest)"
          alt="crest"
          class="w-24 h-24 sm:h-32 sm:w-32"
        />
      </div>
      <div class="flex flex-col items-center sm:mx-10">
        <h1 class="my-2 sm:my-6 text-sm sm:text-xl font-semibold">{{ team.name }}</h1>
        <FavoriteButton :teamId="teamId" />
        <div class="m-2 flex text-xs items-center" v-if="team.venue">
          <StadiumIcon />
          <span class="ml-1">{{ team.venue }}</span>
        </div>
        <div class="flex h-8 m-2">
          <a
            v-if="team.twitter_url"
            :href="team.twitter_url"
            target="_blank"
            rel="noopener noreferrer"
            class="block w-8 h-8 mx-2 rounded-full text-sky-400 hover:text-sky-500"
          >
            <TwitterIcon class="w-8 h-8 rounded-full" />
          </a>
          <a
            v-if="team.youtube_url"
            :href="team.youtube_url"
            target="_blank"
            rel="noopener noreferrer"
            class="block w-8 h-8 mx-2 rounded-full text-red-500 hover:text-red-600"
          >
            <YoutubeIcon class="w-8 h-8 rounded-full" />
          </a>
          <a
            v-if="team.instagram_url"
            :href="team.instagram_url"
            target="_blank"
            rel="noopener noreferrer"
            class="block w-8 h-8 mx-2 rounded-full text-amber-600 hover:text-amber-700"
          >
            <InstagramIcon class="w-8 h-8 rounded-full" />
          </a>
        </div>
        <div class="text-xs sm:text-sm my-4" v-if="team.website_url">
          <span> Website: </span>
          <a
            :href="team.website_url"
            target="_blank"
            rel="noopener noreferrer"
            class="text-sky-500 hover:text-sky-700"
          >
            {{ team.website_url }}
          </a>
        </div>
      </div>
    </div>
    <div v-else class="pt-20 pb-16 sm:py-9">
      <Loading />
    </div>
    <div class="flex absolute bottom-0 left-0 pl-3 sm:pl-12">
      <TabButton
        :activeTab="activeTab"
        tabName="standings"
        @click="tabChange('standings')"
      >
        順位
      </TabButton>
      <TabButton :activeTab="activeTab" tabName="results" @click="tabChange('results')">
        結果
      </TabButton>
      <TabButton
        :activeTab="activeTab"
        tabName="schedules"
        @click="tabChange('schedules')"
      >
        予定
      </TabButton>
    </div>
  </div>
</template>

<script setup>
import StadiumIcon from "../../icons/StadiumIcon.vue";
import YoutubeIcon from "../../icons/YoutubeIcon.vue";
import TwitterIcon from "../../icons/TwitterIcon.vue";
import InstagramIcon from "../../icons/InstagramIcon.vue";
import FavoriteButton from "./FavoriteButton.vue";
import TabButton from "../../components/TabButton.vue";
import Loading from "../../components/Loading.vue";
import { ref, computed, watch, onMounted } from "vue";
import { useStore } from "vuex";
import { useRoute } from "vue-router";

const route = useRoute();
const store = useStore();
const team = ref();
const isLoading = ref(true);
const teamId = computed(() => route.params.teamId);
const isFavorite = ref(false);

const props = defineProps({
  activeTab: {
    type: String,
    required: true,
  },
});

const getTeamDetail = () => {
  isLoading.value = true;
  axios
    .get(`/api/teams/${teamId.value}`)
    .then((res) => {
      team.value = res.data;
      isLoading.value = false;
    })
    .catch((e) => {
      store.dispatch("triggerPopup", { message: "エラーが発生しました。" });
    });
};

const emit = defineEmits(["tabChange"]);
const tabChange = (tabName) => {
  emit("tabChange", tabName);
};

const generateImgUrlDev = (ImgName) => {
  const ImgUrl = "/images/crest/" + ImgName;
  return ImgUrl;
};

onMounted(() => {
  getTeamDetail();
});

watch(route, () => {
  getTeamDetail();
});
</script>
