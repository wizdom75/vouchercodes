<template>
  <div>
    <nav class="navbar navbar-expand-lg navbar-light bg-white">
      <div class="container">
        <router-link :to="{ name: 'home'}" class="logo text-success">{{ appName }}&reg;</router-link>

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
                id="searchTxt"
                class="form-control placeholder border-0 rounded-0"
                placeholder="Enter search term here.."
                @focus="searching = true"
                @blur="searching = false"
                v-on:input="liveSearch()"
              />
              <div class="input-group-append">
                <span class="search-form input-group-text bg-white border-0 rounded-0">
                  <fa icon="search" class="text-muted" fixed-width />
                </span>
              </div>
            </div>
          </ul>

          <ul class="navbar-nav ml-auto">
            <li class="nav-item">
              <router-link
                :to="{ name: 'home' }"
                class="nav-link text-primary"
                active-class="active"
              >{{ $t('home') }}</router-link>
            </li>
            <li class="nav-item">
              <router-link
                :to="{ name: 'top-20' }"
                class="nav-link text-primary"
                active-class="active"
              >{{ $t('top-20') }}</router-link>
            </li>
            <li class="nav-item">
              <router-link
                :to="{ name: 'restaurants' }"
                class="nav-link text-primary"
                active-class="active"
              >{{ $t('restaurants') }}</router-link>
            </li>
            <li class="nav-item">
              <router-link
                :to="{ name: 'students' }"
                class="nav-link text-primary"
                active-class="active"
              >{{ $t('students') }}</router-link>
            </li>
            <!-- categories dropdown -->
            <li class="nav-item dropdown text-muted megamenu">
              <a
                class="nav-link dropdown-toggle text-primary"
                href="#"
                role="button"
                data-toggle="dropdown"
                aria-haspopup="true"
                aria-expanded="false"
              >Categories</a>
              <div class="dropdown-menu text-center mt-1">
                <div class="container-fluid">
                  <div class="row container">
                    <div v-for="category in categories" class="col-md-4" :key="category.slug">
                      <router-link
                        :to="'/cat/'+category.slug "
                        class="dropdown-item pl-3"
                      >{{ category.title }}</router-link>
                    </div>
                  </div>
                </div>
              </div>
            </li>
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
    <div class="search-results" v-if="term.length > 1">
      <div class="container h-100">
        <div class="row">
          <div class="col-6">
            <div class="page-heading text-uppercase">Offers ({{offers.length}})</div>
            <div v-if=" offers.length > 0">
              <SearchOfferCard
                v-for="offer in offers"
                :key="offer.id"
                :voucher_id="offer.id"
                :voucher_title="offer.title"
                :voucher_type="offer.type"
                :voucher_mid="offer.mid"
                :shop_logo="offer.logo"
                :shop_title="offer.shop"
                :shop_slug="offer.slug"
              ></SearchOfferCard>
            </div>
          </div>
          <div class="col-3">
            <div class="page-heading text-uppercase">Shops ({{shops.length}})</div>
            <div v-if=" shops.length > 0">
              <div v-for="offer in shops" class="card" :key="offer.id">{{offer.title}}</div>
            </div>
          </div>
          <div class="col-3">
            <div class="page-heading text-uppercase">Categories ({{cats.length}})</div>
            <div v-if=" cats.length > 0">
              <div v-for="offer in cats" class="card" :key="offer.id">{{offer.title}}</div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { mapGetters } from "vuex";
import axios from "axios";
// import LocaleDropdown from "./LocaleDropdown";

export default {
  // components: {
  //   LocaleDropdown
  // },

  data() {
    return {
      appName: window.config.appName,
      categories: [],
      offers: [],
      stores: [],
      cats: [],
      term: "",
      searching: false
    };
  },
  mounted() {
    axios
      .get("/api/cats")
      .then(response => {
        this.categories = response.data;
      })
      .catch(error => {
        console.log(this.form);
      });
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
    },
    liveSearch() {
      this.term = document.getElementById("searchTxt").value;
      if (this.term.length > 1) {
        setTimeout(
          axios
            .get("/api/live-search/" + this.term)
            .then(response => {
              this.offers = response.data[0];
              this.shops = response.data[1];
              this.cats = response.data[2];
            })
            .catch(error => {
              console.log(this.offers);
            }),
          1000
        );
      }
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
.search-results {
  position: absolute;
  width: 100%;
  margin-left: 0%;
  z-index: 1000;
  background-color: #f7f9fb;
  min-height: 100vh;
}
</style>
