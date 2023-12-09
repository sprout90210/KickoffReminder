<template>
  <router-link
    :to="detailUrl"
    class="flex-1 min-w-[100px] sm:min-w-[150px] h-32 sm:h-40 p-1 duration-300 flex flex-col justify-center items-center"
  >
    <p class="font-semibold text-xxs sm:text-sm">{{ team.name }}</p>
    <div class="w-12 h-12 sm:h-16 sm:w-16 m-2">
      <img :src="crestUrl" class="w-full h-auto max-h-full object-contain" />
    </div>
  </router-link>
</template>

<script setup>
import { computed } from "vue";

const props = defineProps({
  team: {
    type: Object,
    required: true,
  },
});
const crestUrl = computed(() => `images/crest/${props.team.id}.png` );
const detailUrl = computed(() => `/teams/${props.team.id}` );
</script>
