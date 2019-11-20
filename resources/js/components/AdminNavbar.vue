<template>
  <nav class="navbar navbar-expand-lg navbar-light bg-dark">
    <div class="container-fluid">
      <router-link :to="{ name: 'admin.dashboard'}" class="logo text-light">Admin Panel</router-link>

      <button
        class="navbar-toggler"
        type="button"
        data-toggle="collapse"
        data-target="#navbarToggler"
        aria-controls="navbarToggler"
        aria-expanded="false"
      >
        <span class="navbar-toggler-icon" />
      </button>

      <div id="navbarToggler" class="collapse navbar-collapse">
        <!-- <ul class="navbar-nav">
          <locale-dropdown />
           <li class="nav-item">
            <a class="nav-link" href="#">Link</a>
          </li>
        </ul>-->
        <ul class="navbar-nav mx-auto">
          <div class="input-group">
            <input
              type="search"
              class="form-control placeholder border-0 rounded-0"
              placeholder="Enter search term here.."
            />
            <div class="input-group-append">
              <span class="input-group-text bg-white border-0 rounded-0">
                <fa icon="search" class="text-muted" fixed-width />
              </span>
            </div>
          </div>
        </ul>

        <ul class="navbar-nav ml-auto">
          <!-- Authenticated -->
          <li v-if="user" class="nav-item dropleft text-muted">
            <a
              class="nav-link dropdown text-muted"
              href="#"
              role="button"
              data-toggle="dropdown"
              aria-haspopup="true"
              aria-expanded="false"
            >
              <img :src="user.photo_url" class="rounded-circle profile-photo mr-1" />
            </a>
            <div class="dropdown-menu mt-5">
              <router-link :to="{ name: 'account.profile' }" class="dropdown-item pl-3">
                <fa icon="user" class="text-muted" fixed-width />
                {{ $t('account') }}
              </router-link>

              <div class="dropdown-divider" />
              <a href="#" class="dropdown-item pl-3" @click.prevent="logout">
                <fa icon="sign-out-alt" class="text-muted" fixed-width />
                {{ $t('logout') }}
              </a>
            </div>
          </li>
          <!-- Guest -->

          <li v-else class="nav-item dropleft">
            <a
              class="nav-link"
              href="#"
              role="button"
              data-toggle="dropdown"
              aria-haspopup="true"
              aria-expanded="false"
            >
              <fa icon="user" style="regular" class="text-primary" fixed-width />
            </a>
            <div class="dropdown-menu mt-5">
              <router-link
                :to="{ name: 'login' }"
                class="nav-link"
                active-class="active"
              >{{ $t('login') }}</router-link>

              <div class="dropdown-divider" />
              <router-link
                :to="{ name: 'register' }"
                class="nav-link"
                active-class="active"
              >{{ $t('register') }}</router-link>
            </div>
          </li>
        </ul>
      </div>
    </div>
  </nav>
</template>

<script>
import { mapGetters } from "vuex";
// import LocaleDropdown from "./LocaleDropdown";

export default {
  // components: {
  //   LocaleDropdown
  // },

  data() {
    return {
      appName: window.config.appName,
      categories: [
        {
          title: "Cars",
          slug: "cars"
        },
        {
          title: "Trucks",
          slug: "trucks"
        },
        {
          title: "Lorries",
          slug: "lories"
        },
        {
          title: "Jets",
          slug: "jets"
        },
        {
          title: "Helicopters",
          slug: "helicopters"
        },
        {
          title: "Jumbo Jets",
          slug: "jumbo-jets"
        },
        {
          title: "Canoes",
          slug: "canoes"
        },
        {
          title: "Bobsleds",
          slug: "bobsleds"
        },
        {
          title: "Buses",
          slug: "buses"
        },
        {
          title: "Hover Craft",
          slug: "hover-craft"
        }
      ]
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
.profile-photo {
  width: 2rem;
  height: 2rem;
  margin: -0.375rem 0;
}
.navbar-brand {
  font-size: 30px;
  font-weight: bold;
  font-family: "Lato", sans-serif;
}
.megamenu {
  position: static;
}
.dropdown-menu {
  width: 100%;
}
.fix-gap {
  margin-top: -4px;
}
</style>
