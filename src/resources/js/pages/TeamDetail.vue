<template>
  <div class="w-full text-gray-600">
    <Loading v-if="detailLoading" />
    <TeamHero v-else :team="team" :activeTab="activeTab" @tabChange="tabChange" />
    <div>
      <TeamStandings
        v-if="!standingsLoading && activeTab === 'standings'"
        :standings="standings"
        :teamId="teamId"
      />
      <div v-else-if="!resultsLoading && activeTab === 'results'">試合結果</div>
      <Loading v-else />
    </div>
  </div>
</template>

<script setup>
import TeamHero from "../components/TeamHero.vue";
import TeamStandings from "../components/TeamStandings.vue";
import Loading from "../components/Loading.vue";
import { ref, computed, watch, onMounted } from "vue";
import { useRoute, useRouter } from "vue-router";

const route = useRoute();
const team = ref({});
const standings = ref([]);
const activeTab = ref("standings");
const detailLoading = ref(true);
const standingsLoading = ref(true);
const resultsLoading = ref(true);
const scheduleLoading = ref(true);
const teamId = computed(() => route.params.teamId);

const getTeamDetail = () => {
  detailLoading.value = true;
  axios
    .get(`/api/teams/${teamId.value}`)
    .then((res) => {
      team.value = res.data;
      detailLoading.value = false;
    })
    .catch((e) => {
      console.log(e);
    });
};

const getTeamStandings = () => {
  standingsLoading.value = true;
  axios
    .get(`/api/teams/${teamId.value}/standings`)
    .then((res) => {
      standings.value = res.data.original;
      standingsLoading.value = false;
    })
    .catch((e) => {
      console.log(e);
    });
};

const tabChange = (tabName) => {
  activeTab.value = tabName;
};

onMounted(() => {
  getTeamDetail();
  getTeamStandings();
});

watch(route, () => {
  getTeamDetail();
});
</script>
