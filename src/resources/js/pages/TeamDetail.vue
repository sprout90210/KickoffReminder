<template>
  <div class="w-full text-gray-600">
    <TeamHero :activeTab="activeTab" @tabChange="tabChange" />
    <div>
      <TeamStandings
        v-if="!standingsLoading && activeTab === 'standings'"
        :standings="standings"
        :teamId="teamId"
      />
      <div v-else-if="!resultsLoading && activeTab === 'results'">試合結果</div>
      <div v-else class="py-32">
      <Loading/>
      </div>
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
const standings = ref();
const activeTab = ref("standings");
const standingsLoading = ref(true);
const resultsLoading = ref(true);
const scheduleLoading = ref(true);
const teamId = computed(() => route.params.teamId);

const tabChange = (tabName) => {
  activeTab.value = tabName;
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

onMounted(() => {
  getTeamStandings();
});
</script>
