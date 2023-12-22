<template>
  <div class="hero-container">
    <Loading v-if="isLoading" />
    <div v-else class="flex flex-col sm:flex-row justify-center items-center">
      <div class="hero-img-container">
        <img
          alt="crest"
          :src="generateImgUrlDev(team.crest)"
          class="custom-img"
        />
      </div>
      <div class="flex flex-col items-center sm:mx-10">
        <h1 class="my-2 sm:my-6 text-sm sm:text-xl lg:text-2xl font-semibold">{{ team.name }}</h1>
        <FavoriteButton :teamId="teamId" />
        <p class="my-2 flex text-xs items-center" v-if="team.venue">
          <StadiumIcon />
          <span class="ml-1">{{ team.venue }}</span>
        </p>
        <div class="flex h-8 my-2">
          <a
            v-if="team.twitter_url"
            :href="team.twitter_url"
            target="_blank"
            rel="noopener noreferrer"
            class="sns-logo-container"
          >
            <TwitterIcon class="w-8 h-8 rounded-full text-sky-400 hover:text-sky-500" />
          </a>
          <a
            v-if="team.youtube_url"
            :href="team.youtube_url"
            target="_blank"
            rel="noopener noreferrer"
            class="sns-logo-container"
          >
            <YoutubeIcon class="w-8 h-8 rounded-full text-red-500 hover:text-red-600" />
          </a>
          <a
            v-if="team.instagram_url"
            :href="team.instagram_url"
            target="_blank"
            rel="noopener noreferrer"
            class="sns-logo-container"
          >
            <InstagramIcon class="w-8 h-8 rounded-full text-amber-600 hover:text-amber-700" />
          </a>
        </div>
        <p class="text-xs sm:text-sm my-2" v-if="team.website_url">
          <span> website: </span>
          <a
            :href="team.website_url"
            target="_blank"
            rel="noopener noreferrer"
            class="text-sky-500 hover:text-sky-700"
          >
            {{ team.website_url }}
          </a>
        </p>
      </div>
    </div>
    <TabList />
  </div>
</template>

<script setup>
import StadiumIcon from "./icons/StadiumIcon.vue";
import YoutubeIcon from "./icons/YoutubeIcon.vue";
import TwitterIcon from "./icons/TwitterIcon.vue";
import InstagramIcon from "./icons/InstagramIcon.vue";
import FavoriteButton from "./FavoriteButton.vue";
import TabList from "./TabList.vue";
import Loading from "./Loading.vue";
import { ref, computed, watch } from "vue";
import { useRoute, useRouter } from "vue-router";
import { useStore } from "vuex";

const store = useStore();
const route = useRoute();
const router = useRouter();
const team = ref();
const isLoading = ref(true);
const isFavorite = ref(false);
const teamId = computed(() => route.params.teamId);

const generateImgUrlDev = (ImgName) => {
  const ImgUrl = "/images/crest/" + ImgName;
  return ImgUrl;
};

const handleError = (e) => {
  if (e.response.status === 404) {
    router.push("/not-found");
  } else {
    store.dispatch("triggerPopup", { message: "データ取得に失敗しました。" });
  }
};

const getTeam = () => {
  isLoading.value = true;
  axios
    .get(`/api/teams/${teamId.value}`)
    .then((res) => {
      team.value = res.data;
      isLoading.value = false;
    })
    .catch(handleError);
};

watch(() => route.params.teamId, () => {
  getTeam();
}, { immediate: true });
</script>
