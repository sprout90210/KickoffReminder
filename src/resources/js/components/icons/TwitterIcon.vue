<template>
  <svg-icon type="mdi" :path="path"></svg-icon>
</template>

<script>
import SvgIcon from '@jamescoyle/vue-icon';
import { mdiTwitter } from '@mdi/js';

export default {
  name: "TwitterIcon",
  components: {
    SvgIcon
  },
  data() {
    return {
       path: mdiTwitter,
    }
  }
}
</script>