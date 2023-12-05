<template>
  <svg-icon type="mdi" :path="path"></svg-icon>
</template>

<script>
import SvgIcon from '@jamescoyle/vue-icon';
import { mdiInstagram } from '@mdi/js';

export default {
  name: "InstagramIcon",
  components: {
    SvgIcon
  },
  data() {
    return {
       path: mdiInstagram,
    }
  }
}
</script>