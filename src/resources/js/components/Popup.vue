<template>
  <div :class="showPopup ? 'opacity-100 z-50' : 'opacity-0 -z-50'" class="transition-opacity duration-300 fixed top-16 right-8 p-4 w-56 text-sm bg-sky-200 bg-opacity-90 rounded-lg">
    {{ popupMessage }}
  </div>
</template>

<script setup>
import { computed } from "vue";
import { useStore } from "vuex";

const store = useStore();
const showPopup = computed(() => store.state.showPopup);
const popupMessage = computed(() => store.state.popupMessage);
</script>
