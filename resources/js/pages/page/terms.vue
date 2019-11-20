<template>
  <div>
    <div class="jumbotron mt-1 rounded-0">
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
      path: "",
      path_arr: [],
      page: ""
    };
  },
  computed: mapGetters({
    authenticated: "auth/check"
  }),
  mounted() {
    this.path_arr = window.location.pathname.split("/");

    console.log(this.path_arr);
    axios
      .get("/api/page/" + this.path_arr[2])
      .then(response => {
        this.page = response.data;
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
