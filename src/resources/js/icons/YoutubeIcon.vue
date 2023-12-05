<template>
  <svg-icon type="mdi" :path="path"></svg-icon>
</template>

<script>
import SvgIcon from '@jamescoyle/vue-icon';
import { mdiYoutube } from '@mdi/js';

export default {
  name: "YoutubeIcon",
  components: {
    SvgIcon
  },
  data() {
    return {
       path: mdiYoutube,
    }
  }
}
</script>