<template>
  <div>
    <nav class="navbar navbar-expand-lg navbar-light bg-white">
      <div class="container">
        <router-link :to="{ name: 'home'}" class="logo text-primary">{{ appName }}</router-link>

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
                class="form-control placeholder rounded-0 border-right-0"
                placeholder="Enter search term here.."
                @focus="searching = true"
                @blur="searching = false"
                v-on:input="searchTimeOut()"
              />
              <div class="input-group-append">
                <span class="search-form input-group-text bg-white border-left-0 rounded-0">
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
    <div class="search-results" v-if="term.length > 0">
      <div class="container h-100">
        <div class="row pt-3">
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
                v-on:click="clearInput()"
              ></SearchOfferCard>
            </div>
            <div v-else-if="offers.length < 1">
              <p class="text-muted mt-3">No offers</p>
            </div>
          </div>
          <div class="col-3">
            <div class="page-heading text-uppercase">Shops ({{shops.length}})</div>
            <div v-if=" shops.length > 0" v-on:click="clearInput()">
              <router-link
                v-for="offer in shops"
                :to="'/'+offer.slug "
                class="card dropdown-item pl-3 mt-1"
                :key="offer.id"
                v-on:click="clearInput()"
              >{{ offer.title }}</router-link>
            </div>
            <div v-else-if="shops.length < 1">
              <p class="text-muted mt-3">No shops</p>
            </div>
          </div>
          <div class="col-3">
            <div class="page-heading text-uppercase">Categories ({{cats.length}})</div>
            <div v-if=" cats.length > 0" v-on:click="clearInput()">
              <router-link
                v-for="offer in cats"
                :to="'/cat/'+offer.slug "
                class="card dropdown-item pl-3 mt-1"
                :key="offer.id"
                v-on:click="clearInput()"
              >{{ offer.title }}</router-link>
            </div>
            <div v-else-if="cats.length < 1">
              <p class="text-muted mt-3">No categories</p>
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
      shops: {},
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
    },
    searchTimeOut() {
      if (this.timer) {
        clearTimeout(this.timer);
        this.timer = null;
      }
      this.timer = setTimeout(() => {
        // your code
        this.term = document.getElementById("searchTxt").value;
        axios
          .get("/api/live-search/" + this.term)
          .then(response => {
            this.offers = response.data[0];
            this.shops = response.data[1];
            this.cats = response.data[2];
          })
          .catch(error => {
            console.log(this.offers);
          });
      }, 500);
    },
    clearInput() {
      document.getElementById("searchTxt").reset();
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
/* input[type="search"] {
  background: rgb(253, 246, 246);
  border: 0 none;
  color: #d7d7d7;
  width: 250px;
  padding: 6px 15px 6px 35px;
  -webkit-border-radius: 20px;
  -moz-border-radius: 20px;
  border-radius: 20px;
  margin: 3px 80px;
}

input[type="search"]:focus {
  background: #ccc;
  color: #6a6f75;
  padding-left: 10%;
  margin-left: -100px;
  width: 300px;
  position: relative;
  z-index: 1000;
  outline: none;
}

input[type="search"] {
  -webkit-transition: all 0.7s ease 0s;
  -moz-transition: all 0.7s ease 0s;
  -o-transition: all 0.7s ease 0s;
  transition: all 0.7s ease 0s;
} */
</style>
