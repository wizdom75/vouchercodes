<template>
  <div>
    <div class="jumbotron mt-3">
      <h1 class="display-4 text-capitalize text-center text-white">{{page.title}}</h1>
    </div>

    <div class="text-muted">{{page.body}}</div>
  </div>
</template>

<script>
import { mapGetters } from "vuex";
import axios from "axios";
export default {
  metaInfo() {
    return { title: "" + this.page.title };
  },
  data() {
    return {
      title: window.config.appName,
      page: {
        title: "Site Support",
        more: ""
      }
    };
  },
  computed: mapGetters({
    authenticated: "auth/check"
  }),
  mounted() {
    axios
      .get("/api/pages/support")
      .then(response => {
        this.page.more = response.data;
      })
      .catch(error => {
        console.log(error);
      });
  }
};
</script>

<style scoped>
.top-right {
  position: absolute;
  right: 10px;
  top: 18px;
}
.title {
  font-size: 85px;
}
.top-left {
  position: absolute;
  right: 10px;
  top: 18px;
}
.nested-logo {
  position: absolute;
  padding-top: 35%;
  padding-left: 5%;
  width: 30%;
}
</style>
