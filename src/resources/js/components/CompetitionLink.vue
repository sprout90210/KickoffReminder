<template>
  <router-link
    :to="competitionUrl"
    class="flex-1 min-w-[100px] sm:min-w-[150px] h-28 sm:h-44 duration-300 flex flex-col justify-center items-center"
  >
    <p class="font-bold text-xxs sm:text-sm">{{ competition.name}}</p>
    <img :src="emblemUrl" alt="emblem" class="w-14 h-14 sm:w-20 sm:h-20 m-3" />
  </router-link>
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
const competitionUrl = computed(() => `/competitions/${props.competition.id}`);
</script>
