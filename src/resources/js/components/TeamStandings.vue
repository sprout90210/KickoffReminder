<template>
  <div class="py-4 sm:py-8 px-1 sm:px-8 md:px-16 lg:px-24">
    <table class="w-full">
      <TableHeader />
      <ExpandablePanel
        v-for="(standing, index) in standings"
        :key="standing.id"
        :standing="standing"
      />
    </table>
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
});
</script>
