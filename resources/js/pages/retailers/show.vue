<template>
  <div class="container">
    <div v-if="loading" class="vh-100 mx-auto text-center">loading....</div>
    <div v-else-if="!loading" class="card mt-3 flex-row flex-wrap border-0 bg-light">
      <div class="card-header border-0">
        <img :src="shop.logo" :alt="shop.title" class="border-0 m-0" width="100px" />
      </div>
      <div class="card-body border-0 rounded-0">
        <h1 class="h4 mb-0">
          {{ shop.title }}
          <span class="text-muted">{{ monthYear }} Voucher Codes</span>
        </h1>

        <br />
        <button class="btn btn-sm btn-outline-secondary small rounded-0">Favorite</button>

        <a
          :href="'/out/redirect/'+shop.mid+'/0'"
          target="_blank"
          rel="noopener noreferrer"
          class="btn btn-sm btn-outline-secondary small rounded-0"
        >Go to store</a>
      </div>
    </div>

    <div class="row mb-5">
      <div class="col-md-8">
        <DealCard
          v-for="voucher in vouchers"
          :key="voucher.id"
          :voucher_id="voucher.id"
          :voucher_title="voucher.title"
          :voucher_blurb="voucher.blurb"
          :voucher_type="voucher.type"
          :voucher_terms="voucher.terms"
          :voucher_code="voucher.code"
          :voucher_url="voucher.url"
          :voucher_mid="voucher.mid"
          :shop_logo="shop.logo"
          :shop_title="shop.title"
          :feedback="feedback"
          :paramCode="paramCode"
        />

        <div class="mt-3">
          <Searched />
        </div>
      </div>
      <div class="col-md-4">
        <SquareAd />
        <div class="mt-3">
          <BrowseCard />
        </div>
        <div class="mt-3">
          <PopularShops title="Popular shops" :category="shop.title" />
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import { mapGetters } from "vuex";
import axios from "axios";
export default {
  metaInfo() {
    return { title: this.$route.params.slug };
  },
  data() {
    return {
      title: window.config.appName,
      feedback: null,
      vouchers: "",
      shop: {},
      months: null,
      monthYear: null,
      loading: true,
      paramCode: null
    };
  },
  computed: mapGetters({
    authenticated: "auth/check"
  }),
  created() {
    this.getMonthAndYear();
    let queryString = window.location.search;
    let urlParams = new URLSearchParams(queryString);
    this.paramCode = urlParams.get("rc");
    let paramCode = urlParams.get("rc");
    console.log(paramCode);
    axios
      .get("/api/retailer/" + this.$route.params.slug)
      .then(response => {
        this.shop = response.data;
        this.getOffers(response.data.mid);
      })
      .catch(error => {
        console.log(error);
      });
  },
  methods: {
    getMonthAndYear() {
      var dt = new Date();

      this.monthYear =
        dt.toLocaleString("default", { month: "long" }) +
        " " +
        dt.getFullYear();
    },
    getOffers(slug) {
      axios
        .get("/api/offers-by-retailer/" + slug)
        .then(response => {
          this.vouchers = response.data;
        })
        .then(res => {
          this.loading = false;
        })
        .catch(error => {
          console.log(error);
        });
    }
  }
};
</script>
