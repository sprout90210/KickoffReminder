<template>
  <div class="flex flex-col flex-grow">
    <TeamHero />
    <div class="w-full flex flex-col items-center">
      <Standings
        v-show="!standingsLoading && activeTab === 'standings'"
        :standings="standings"
      />
      <Games v-show="!resultsLoading && activeTab === 'results'" :games="results" />
      <Games
        v-show="!schedulesLoading && activeTab === 'schedules'"
        :games="schedules"
      />
      <Loading
        v-show="
          (standingsLoading && activeTab === 'standings') ||
          (resultsLoading && activeTab === 'results') ||
          (schedulesLoading && activeTab === 'schedules')
        "
      />
    </div>
  </div>
</template>

<script setup>
import NotFound from "../components/NotFound.vue";
import TeamHero from "../components/TeamHero.vue";
import Standings from "../components/Standings.vue";
import Games from "../components/Games.vue";
import Loading from "../components/Loading.vue";
import { ref, computed, watch } from "vue";
import { useRoute } from "vue-router";
import { useStore } from "vuex";

const route = useRoute();
const store = useStore();
const standings = ref([]);
const results = ref([]);
const schedules = ref([]);
const standingsLoading = ref(true);
const resultsLoading = ref(true);
const schedulesLoading = ref(true);
const teamId = computed(() => route.params.teamId);
const activeTab = computed(() => store.state.activeTab);

const fetchData = (type, loadingRef, dataRef, endpoint) => {
  loadingRef.value = true;
  axios
    .get(`/api/teams/${teamId.value}/${endpoint}`)
    .then((res) => {
      dataRef.value = res.data;
      loadingRef.value = false;
    })
    .catch((e) => {
      loadingRef.value = false;
      store.dispatch("triggerPopup", { message: "データ取得に失敗しました。", color: "red" });
    });
};

watch(() => route.params.teamId, () => {
  fetchData('standings', standingsLoading, standings, 'standings');
  fetchData('results', resultsLoading, results, 'results');
  fetchData('schedules', schedulesLoading, schedules, 'schedules');
}, { immediate: true });
</script>
