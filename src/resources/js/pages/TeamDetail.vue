<template>
  <div class="w-full text-gray-500">
    <TeamHero :activeTab="activeTab" @tabChange="tabChange" />
    <div>
      <TeamStandings
        v-if="!standingsLoading && activeTab === 'standings'"
        :standings="standings"
      />
      <TeamResults
        v-else-if="!resultsLoading && activeTab === 'results'"
        :results="results"
      />
      <TeamSchedules
        v-else-if="!schedulesLoading && activeTab === 'schedules'"
        :schedules="schedules"
      />
      <div v-else class="py-32">
        <Loading/>
      </div>
    </div>
  </div>
</template>

<script setup>
import TeamHero from "../components/TeamHero.vue";
import TeamStandings from "../components/TeamStandings.vue";
import TeamResults from "../components/TeamResults.vue";
import TeamSchedules from "../components/TeamSchedules.vue";
import Loading from "../components/Loading.vue";
import { ref, computed, watch, onMounted } from "vue";
import { useRoute, useRouter } from "vue-router";

const route = useRoute();
const standings = ref();
const results = ref();
const schedules = ref();
const activeTab = ref("standings");
const standingsLoading = ref(true);
const resultsLoading = ref(true);
const schedulesLoading = ref(true);
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
