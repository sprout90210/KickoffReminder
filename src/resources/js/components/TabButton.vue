<template>
  <button
    @click="changeActiveTab()"
    class="px-8 py-3 rounded-t-md text-gray-700 text-sm duration-200"
    :class="{
      'bg-white font-bold hover:cursor-default': isActive,
      'bg-gray-400 hover:bg-fuchsia-500 hover:text-white': !isActive,
    }"
  >
    <slot></slot>
  </button>
</template>

<script setup>
import { computed } from "vue";
import { useStore } from "vuex";

const props = defineProps({
  tabName: {
    type: String,
    required: true,
  }
});

const store = useStore();
const activeTab = computed(() => store.state.ui.activeTab );
const isActive = computed(() => activeTab.value == props.tabName)

const changeActiveTab = () => {
  store.dispatch("changeActiveTab", props.tabName);
};
</script>
