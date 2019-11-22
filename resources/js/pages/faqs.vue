<template>
  <div>
    <div class="jumbotron mt-1">
      <h1 class="display-4 text-capitalize text-center text-white">{{page.title}}</h1>
    </div>
    <div class="container">
      <div class="text-muted">{{page.body}}</div>
    </div>
  </div>
</template>

<script>
import { mapGetters } from "vuex";
import axios from "axios";
export default {
  metaInfo() {
    return { title: this.page.title };
  },
  data() {
    return {
      title: window.config.appName,
      page: {
        title: "Frequently Asked Questions",
        body: ""
      }
    };
  },
  computed: mapGetters({
    authenticated: "auth/check"
  }),
  mounted() {
    axios
      .get("/api/pages/" + this.$route.params.slug)
      .then(response => {
        this.page.body = response.data;
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
