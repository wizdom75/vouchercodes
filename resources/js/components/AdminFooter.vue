<template>
  <footer class="text-light p-5 mt-3 mb-0 bg-success border-0">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-3">
          <ul>
            <h3 class="h4 text-uppercase">Savings</h3>
            <li class="link-item">
              <router-link
                :to="{ name: 'retailers' }"
                class="nav-item text-light"
                active-class="active"
              >{{ $t('retailers') }}</router-link>
            </li>
            <li class="link-item">
              <router-link
                :to="{ name: 'nhs' }"
                class="nav-item text-light"
                active-class="active"
              >{{ $t('nhs') }}</router-link>
            </li>
            <li class="link-item"></li>
            <li class="link-item">
              <router-link
                :to="{ name: 'exclusive' }"
                class="nav-item text-light"
                active-class="active"
              >{{ $t('exclusive') }}</router-link>
            </li>
          </ul>
        </div>
        <div class="col-md-3">
          <ul>
            <h3 class="h4 text-uppercase">Help</h3>
            <li class="link-item">
              <router-link
                :to="{ name: 'support' }"
                class="link-item text-light"
                active-class="active"
              >{{ $t('support') }}</router-link>
            </li>
            <li class="link-item">
              <router-link
                :to="{ name: 'faqs' }"
                class="link-item text-light"
                active-class="active"
              >{{ $t('faqs') }}</router-link>
            </li>
            <li class="link-item">
              <router-link
                :to="{ name:'contact' }"
                class="link-item text-light"
                active-class="active"
              >{{ $t('contact') }}</router-link>
            </li>
          </ul>
        </div>
        <div class="col-md-3">
          <ul>
            <h3 class="h4 text-uppercase">Legal</h3>
            <li class="link-item">
              <router-link
                :to="{name:'page.about'}"
                class="link-item text-light"
                active-class="active"
              >{{ $t('about') }}</router-link>
            </li>
            <li class="link-item">
              <router-link
                :to="{name:'page.terms'}"
                class="link-item text-light"
                active-class="active"
              >{{ $t('terms') }}</router-link>
            </li>
            <li class="link-item">
              <router-link
                :to="{ name: 'page.privacy'} "
                class="link-item text-light"
                active-class="active"
              >{{ $t('privacy') }}</router-link>
            </li>
            <li class="link-item">
              <router-link
                :to="{name:'page.cookies' }"
                class="link-item text-light"
                active-class="active"
              >{{ $t('cookies') }}</router-link>
            </li>
          </ul>
        </div>
        <div class="col-md-3">
          <ul>
            <h3 class="h4 text-uppercase">Social</h3>
            <li class="link-item">
              <fa :icon="['fab','facebook-f']" class="text-white" fixed-width />Facebook
            </li>
            <li class="link-item">
              <fa :icon="['fab','instagram']" class="text-white" fixed-width />Instagram
            </li>
            <li class="link-item">
              <fa :icon="['fab','twitter']" class="text-white" fixed-width />Twitter
            </li>
          </ul>
        </div>
      </div>
    </div>
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