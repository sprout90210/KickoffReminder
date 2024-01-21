<template>
  <div class="h-56 w-56 p-2 border border-gray-400 rounded-lg flex flex-col items-center text-gray-700">
    <h3 class="text-base font-bold mb-1">
      <slot></slot>
    </h3>
    <img :src="img" alt="procedure" class="h-44 w-44 rounded border border-gray-300">
  </div>
</template>

<script setup>
const props = defineProps({
  img:{
    type: String,
    required: true,
  } 
});
</script>
