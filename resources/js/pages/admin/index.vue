<template>
  <div class="row mt-3">
    <div class="col-md-3">
      <card :title="$t('admin_panel')" class="account-card">
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
  layout: "admin",
  middleware: "auth",

  computed: {
    tabs() {
      return [
        {
          icon: "tachometer-alt",
          name: this.$t("dashboard"),
          route: "admin.dashboard"
        },
        // {
        //   icon: "users",
        //   name: this.$t("users"),
        //   route: "admin.users"
        // },
        {
          icon: "folder",
          name: this.$t("categories"),
          route: "admin.categories"
        },
        {
          icon: "store",
          name: this.$t("retailers"),
          route: "admin.retailers"
        },
        {
          icon: "tag",
          name: this.$t("vouchers"),
          route: "admin.vouchers"
        },
        {
          icon: "upload",
          name: this.$t("submissions"),
          route: "admin.submissions"
        },
        {
          icon: "file-alt",
          name: this.$t("pages"),
          route: "admin.pages"
        },
        {
          icon: "plug",
          name: this.$t("feeds"),
          route: "admin.feeds"
        }
        // {
        //   icon: "lock",
        //   name: this.$t("password"),
        //   route: "admin.password"
        // }
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
