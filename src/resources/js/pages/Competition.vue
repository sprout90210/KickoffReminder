<template>
  <div class="flex flex-col flex-grow">
    <CompetitionHero />
    <div class="flex flex-col items-center">
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
import CompetitionHero from "../components/CompetitionHero.vue";
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
const competitionId = computed(() => route.params.competitionId);
const activeTab = computed(() => store.state.ui.activeTab );

const fetchData = (type, loadingRef, dataRef, endpoint) => {
  loadingRef.value = true;
  axios
    .get(`/api/competitions/${competitionId.value}/${endpoint}`)
    .then((res) => {
      dataRef.value = res.data;
    })
    .catch((e) => {
      store.dispatch("triggerPopup", { message: "データ取得に失敗しました。", color: "red" });
    })
    .finally(() => {
      loadingRef.value = false;
    });
};

watch(() => route.params.competitionId, () => {
  fetchData('standings', standingsLoading, standings, 'standings');
  fetchData('results', resultsLoading, results, 'results');
  fetchData('schedules', schedulesLoading, schedules, 'schedules');
}, { immediate: true });
</script>
