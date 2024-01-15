<template>
  <svg-icon type="mdi" :path="path"></svg-icon>
</template>

<script>
import SvgIcon from '@jamescoyle/vue-icon';
import { mdiMenuRight } from '@mdi/js';

export default {
  name: "ArrowRightIcon",
  components: {
    SvgIcon
  },
  data() {
    return {
       path: mdiMenuRight,
    }
  }
}
</script>