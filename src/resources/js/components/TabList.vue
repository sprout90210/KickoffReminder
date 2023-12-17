<template>
  <div class="flex absolute bottom-0 left-0 pl-3 sm:pl-12">
    <TabButton
      v-for="tab in tabs"
      :key="tab.tabName"
      :activeTab="activeTab"
      :tabName="tab.tabName"
      @click="changeActiveTab(tab.tabName)"
    >
      {{ tab.label }}
    </TabButton>
  </div>
</template>

<script setup>
import TabButton from "./TabButton.vue";
import { ref, computed } from "vue";
import { useStore } from "vuex";

const store = useStore();
const activeTab = computed(() => store.state.activeTab );
const tabs = [
  { tabName: "standings", label: "順位" },
  { tabName: "results", label: "結果" },
  { tabName: "schedules", label: "予定" },
];

const changeActiveTab = (tabName) => {
  store.dispatch("changeActiveTab", tabName);
};

</script>