<template>
  <svg-icon type="mdi" :path="path"></svg-icon>
</template>

<script>
import SvgIcon from '@jamescoyle/vue-icon';
import { mdiStadiumVariant } from '@mdi/js';

export default {
  name: "StadiumIcon",
  components: {
    SvgIcon
  },
  data() {
    return {
       path: mdiStadiumVariant,
    }
  }
}
</script>