<template>
  <div class="overflow-hidden flex-1 min-w-[120px] lg:min-w-[140px] h-28 lg:h-44 duration-500">
    <router-link
      :to="{ name: 'Competition', params: { competitionId: competition.id } }"
      class="h-full w-full hover:scale-110 transition-transform duration-300 flex flex-col justify-center items-center"
    >
      <p class="font-bold text-xs lg:text-sm">{{ competition.name}}</p>
      <div class="w-16 h-16 lg:h-20 lg:w-20 m-2 custom-img-container">
        <img :src="emblemUrl" alt="emblem" class="custom-img" />
      </div>
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

const emblemUrl = computed(() => `https://kickoffreminder-bucket.s3.ap-northeast-1.amazonaws.com/emblem/${props.competition.id}.png`);
</script>
