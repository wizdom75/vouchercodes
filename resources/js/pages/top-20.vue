<template>
  <div>
    <div class="jumbotron mt-0 mb-0 top-20 rounded-0">
      <h1 class="display-4 text-capitalize text-center text-white">Top 20 Offers</h1>
    </div>
    <div class="container">
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
            :shop_logo="voucher.logo"
            :shop_title="voucher.store"
            :feedback="feedback"
            :paramCode="paramCode"
          ></DealCard>
          <div class="mt-3">
            <Searched></Searched>
          </div>
        </div>
        <div class="col-md-4">
          <SquareAd></SquareAd>
          <div class="mt-3">
            <BrowseCard></BrowseCard>
          </div>
          <div class="mt-3">
            <PopularShops title="Popular shops" category="food"></PopularShops>
          </div>
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
    return { title: this.$t("top-20") };
  },
  data() {
    return {
      title: window.config.appName,
      vouchers: "",
      feedback: null,
      loading: true,
      paramCode: null
    };
  },
  created() {
    this.getOffers();
    let queryString = window.location.search;
    let urlParams = new URLSearchParams(queryString);
    this.paramCode = urlParams.get("rc");
    let paramCode = urlParams.get("rc");
  },
  methods: {
    getOffers() {
      axios
        .get("/api/top-20-offers")
        .then(response => {
          this.vouchers = response.data;
        })
        .catch(error => {
          console.log(error);
        });
    }
  },
  computed: mapGetters({
    authenticated: "auth/check"
  })
};
</script>
<style scoped>
.top-20 {
  background: url("/images/top-20.jpg") no-repeat center center;
  background-size: cover;
}
</style>