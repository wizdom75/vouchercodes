<template>
  <div class="basic-layout d-flex align-items-center justify-content-center m-0 bg-white">
    <child />
  </div>
</template>
<script>
import { mapGetters } from "vuex";
export default {
  name: "BasicLayout",

  data: () => ({
    title: ""
  }),
  computed: mapGetters({
    authenticated: "auth/check"
  })
};
</script>

<style lang="scss">
.basic-layout {
  color: #636b6f;
  height: 100vh;
  font-weight: 100;
  position: relative;

  .links > a {
    color: #636b6f;
    padding: 0 25px;
    font-size: 12px;
    font-weight: 600;
    letter-spacing: 0.1rem;
    text-decoration: none;
    text-transform: uppercase;
  }
}
</style>
