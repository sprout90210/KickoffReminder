<template>
  <div class="flex-1 min-w-[120px] lg:min-w-[140px] h-24 lg:h-40 duration-300" :class="team.color">
    <router-link
      :to="{ name: 'Team', params: { teamId: team.id } }"
      class="h-full w-full flex flex-col justify-center items-center"
    >
      <p class="font-semibold text-xs lg:text-sm">{{ team.name }}</p>
      <div class="w-12 h-12 lg:h-16 lg:w-16 m-2">
        <img :src="crestUrlDev" class="custom-img" alt="crest" />
      </div>
    </router-link>
  </div>
</template> 

<script setup>
import { computed } from "vue";

const props = defineProps({
  team: {
    type: Object,
    required: true,
  },
});
const crestUrlDev = computed(() => `images/crest/${props.team.id}.png`);
</script>
