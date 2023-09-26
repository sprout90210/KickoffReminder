<template>
  <div class="py-4 sm:py-8">
    <div class="m-0 px-1 sm:px-8 md:px-16 lg:px-24">
      <table class="w-full">
        <TableHeader />
        <ExpandablePanel
          v-for="(standing, index) in standings"
          :key="standing.id"
          :standing="standing"
          :teamId="teamId"
        />
      </table>
    </div>
  </div>
</template>

<script setup>
import TableHeader from "../layouts/TableHeader.vue";
import ExpandablePanel from "./ExpandablePanel.vue";

const props = defineProps({
  standings: {
    type: Array,
    required: true,
  },
  teamId: {
    type: String,
    required: true,
  }
});
</script>
