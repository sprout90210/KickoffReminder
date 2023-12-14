<template>
  <svg-icon type="mdi" :path="path"></svg-icon>
</template>

<script>
import SvgIcon from '@jamescoyle/vue-icon';
import { mdiChevronDown } from '@mdi/js';

export default {
  name: "ChevronDownIcon",
  components: {
    SvgIcon
  },
  data() {
    return {
       path: mdiChevronDown,
    }
  }
}
</script>