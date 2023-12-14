<template>
  <div>
    <header
      class="inset-0 z-20 h-14 sm:h-16 text-white flex items-center bg-gray-800"
    >
      <router-link to="/" class="ml-5 p-1 inline-block text-md font-semibold">
        Kickoff Reminder
      </router-link>
      <button
        @click="toggleMenu"
        class="z-50 w-8 h-9 bg-gray-800 fixed top-2.5 sm:top-3.5 right-4 sm:right-7 rounded border border-gray-600 hover:border-gray-500"
      >
        <CloseIcon v-show="isMenuOpen" class="m-auto" />
        <MenuIcon v-show="!isMenuOpen" class="m-auto" />
      </button>
    </header>
    <div
      v-if="isMenuOpen"
      class="fixed inset-0 bg-black bg-opacity-70 z-30"
      @click="toggleMenu"
    ></div>
    <HamburgerMenu />
  </div>
</template>

<script setup>
import MenuIcon from "../components/icons/MenuIcon.vue";
import CloseIcon from "../components/icons/CloseIcon.vue";
import HamburgerMenu from "./HamburgerMenu.vue";
import { computed, watch } from "vue";
import { useStore } from "vuex";

const store = useStore();
const isMenuOpen = computed(() => store.state.isMenuOpen);

const toggleMenu = () => {
  store.commit("toggleMenu");
};

watch(isMenuOpen, (newValue) => {
  document.body.style.overflow = newValue ? "hidden" : "";
});
</script>
