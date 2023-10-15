<template>
  <button
    class="px-3 sm:px-8 py-2 ml-3 sm:ml-5 rounded-t text-xs sm:text-sm duration-200"
    :class="{
      'bg-white font-bold hover:cursor-default': isActive,
      'bg-gray-300 hover:bg-fuchsia-400 hover:text-white': !isActive,
    }"
  >
    <slot></slot>
  </button>
</template>

<script setup>
import { computed } from "vue";

const props = defineProps({
  activeTab: {
    type: String,
    required: true,
  },
  tabName: {
    type: String,
    required: true,
  }
});

const isActive = computed(() => props.activeTab === props.tabName);
</script>
