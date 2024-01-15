<template>
  <div v-if="standings.length" class="p-1 sm:py-10 w-full max-w-3xl">
    <table class="w-full">
      <TableHeader />
      <ExpandablePanel
        v-for="standing in standings"
        :key="standing.team_id"
        :standing="standing"
      />
    </table>
  </div>
  <NotFound v-else />
</template>

<script setup>
import NotFound from "./NotFound.vue";
import TableHeader from "./TableHeader.vue";
import ExpandablePanel from "./ExpandablePanel.vue";

const props = defineProps({
  standings: {
    type: Array,
    required: true,
  },
});
</script>
