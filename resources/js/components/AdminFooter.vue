<template>
  <footer class="text-light p-5 mt-3 mb-0 bg-info border-0">
    <hr class="text-light" />
    <h2 class="page-header footer-brand text-white text-center">{{appName}}&reg;</h2>
    <div class="text-center small">Copyright &copy; 2019</div>
  </footer>
</template>
<script>
import { mapGetters } from "vuex";
export default {
  name: "AdminFooter",
  data() {
    return {
      appName: window.config.appName
    };
  },

  computed: mapGetters({
    user: "auth/user"
  }),

  methods: {
    async logout() {
      // Log out the user.
      await this.$store.dispatch("auth/logout");

      // Redirect to login.
      this.$router.push({ name: "login" });
    }
  }
};
</script>
<style scoped>
ul {
  list-style-type: none;
  padding: 0;
}
.h4 {
  font-weight: 100;
  font-family: "lato";
  font-size: 20px;
}
.footer-brand {
  font-size: 22px;
  font-weight: bold;
  font-family: "Lato", sans-serif;
}
</style>