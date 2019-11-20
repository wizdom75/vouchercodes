<template>
  <div class="row mt-3">
    <div class="col-md-3">
      <card :title="$t('account')" class="account-card">
        <ul class="nav flex-column nav-pills">
          <li v-for="tab in tabs" :key="tab.route" class="nav-item">
            <router-link :to="{ name: tab.route }" class="nav-link" active-class="active">
              <fa :icon="tab.icon" fixed-width />
              {{ tab.name }}
            </router-link>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link" @click.prevent="logout">
              <fa icon="sign-out-alt" fixed-width />
              <i class="far fa-heart"></i>
              {{ $t('logout') }}
            </a>
          </li>
        </ul>
      </card>
    </div>

    <div class="col-md-9">
      <transition name="fade" mode="out-in">
        <router-view />
      </transition>
    </div>
  </div>
</template>

<script>
export default {
  middleware: "auth",

  computed: {
    tabs() {
      return [
        {
          icon: "user",
          name: this.$t("profile"),
          route: "account.profile"
        },
        {
          icon: "heart",
          name: this.$t("favourite_shops"),
          route: "account.favouriteShops"
        },
        {
          icon: "upload",
          name: this.$t("submit_a_code"),
          route: "account.submitACode"
        },
        {
          icon: "envelope",
          name: this.$t("email_settings"),
          route: "account.emailSettings"
        },
        {
          icon: "lock",
          name: this.$t("password"),
          route: "account.password"
        }
      ];
    }
  },
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

<style>
.account-card .card-body {
  padding: 0;
}
</style>
