<template>
  <div class="overflow-hidden flex-1 min-w-[120px] lg:min-w-[140px] h-28 lg:h-44 duration-500">
    <router-link
      :to="{ name: 'Competition', params: { competitionId: competition.id } }"
      class="h-full w-full hover:scale-110 transition-transform duration-300 flex flex-col justify-center items-center"
    >
      <p class="font-bold text-xs lg:text-sm">{{ competition.name}}</p>
      <img :src="emblemUrl" alt="emblem" class="w-14 h-14 lg:w-20 lg:h-20 m-3" />
    </router-link>
  </div>
</template>

<script setup>
import { computed } from "vue";

const props = defineProps({
  competition: {
    type: Object,
    required: true,
  },
});
const emblemUrl = computed(() => `images/emblem/${props.competition.id}.png`);
</script>
