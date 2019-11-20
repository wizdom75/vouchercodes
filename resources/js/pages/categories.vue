<template>
  <div>
    <h1 class="h3 page-heading text-capitalize pt-3">Categories</h1>
  </div>
</template>
<script>
import { mapGetters } from "vuex";
export default {
  metaInfo() {
    return { title: this.$t("categories") };
  },
  data: () => ({
    title: window.config.appName
  }),
  computed: mapGetters({
    authenticated: "auth/check"
  })
};
</script>