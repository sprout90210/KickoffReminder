<template>
  <button
    class="px-4 sm:px-8 py-1.5 sm:py-2 ml-3 sm:ml-5 rounded-t text-sm duration-300"
    :class="{
      'bg-white font-bold hover:cursor-default': isActive,
      'bg-gray-300 hover:bg-fuchsia-400 hover:text-white': !isActive,
    }"
  >
    <slot></slot>
  </button>
</template>

<script setup>
import { computed, defineProps } from "vue";

const props = defineProps({
  activeTab: String,
  tabName: String,
});

const isActive = computed(() => props.activeTab === props.tabName);
</script>
