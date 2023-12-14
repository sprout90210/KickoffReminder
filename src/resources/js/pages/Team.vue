<template>
  <div class="w-full text-gray-500">
    <TeamHero :activeTab="activeTab" @tabChange="tabChange" />
    <div>
      <Standings
        v-show="!standingsLoading && activeTab === 'standings'"
        :standings="standings"
      />
      <Results
        v-show="!resultsLoading && activeTab === 'results'"
        :results="results"
      />
      <Schedules
        v-show="!schedulesLoading && activeTab === 'schedules'"
        :schedules="schedules"
      />
      <div v-show="(standingsLoading && activeTab === 'standings') || (resultsLoading && activeTab === 'results') || (schedulesLoading && activeTab === 'schedules')" class="py-32">
        <Loading/>
      </div>
    </div>
  </div>
</template>

<script setup>
import TeamHero from "../components/TeamHero.vue";
import Standings from "../components/Standings.vue";
import Results from "../components/Results.vue";
import Schedules from "../components/Schedules.vue";
import Loading from "../components/Loading.vue";
import { ref, computed, watch, onMounted } from "vue";
import { useRoute, useRouter } from "vue-router";

const route = useRoute();
const standings = ref();
const results = ref();
const schedules = ref();
const standingsLoading = ref(true);
const resultsLoading = ref(true);
const schedulesLoading = ref(true);
const activeTab = ref("standings");
const teamId = computed(() => route.params.teamId);

const tabChange = (tabName) => {
  activeTab.value = tabName;
};

const getStandings = () => {
  standingsLoading.value = true;
  axios
    .get(`/api/teams/${teamId.value}/standings`)
    .then((res) => {
      standings.value = res.data;
      standingsLoading.value = false;
    })
    .catch((e) => {
      console.log(e);
    });
};

const getResults = () => {
  resultsLoading.value = true;
  axios
    .get(`/api/teams/${teamId.value}/results`)
    .then((res) => {
      results.value = res.data;
      resultsLoading.value = false;
    })
    .catch((e) => {
      console.log(e);
    });
};

const getSchedules = () => {
  schedulesLoading.value = true;
  axios
    .get(`/api/teams/${teamId.value}/schedules`)
    .then((res) => {
      schedules.value = res.data;
      schedulesLoading.value = false;
    })
    .catch((e) => {
      console.log(e);
    });
};

onMounted(() => {
  getStandings();
  getResults();
  getSchedules();
});

watch(route, () => {
  getStandings();
  getResults();
  getSchedules();
});
</script>
