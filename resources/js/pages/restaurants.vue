<template>
  <div>
    <div class="jumbotron jumbotron-fluid mt-0 mb-0 restuarant">
      <h1
        class="text-white text-capitalize display-4 text-center"
      >Restaurant Vouchers & offers near you</h1>
      <div class="lead text-center">
        <div class="input-group">
          <input
            type="text"
            class="form-control-lg col-md-4 mx-auto border-0 rounded-0"
            placeholder="Your location"
            aria-label="Recipient's username"
            aria-describedby="basic-addon2"
          />
          <div class="input-group mt-3">
            <button class="btn btn-info btn-lg mx-auto rounded-0" type="button">Find Resturant Deals</button>
          </div>
        </div>
      </div>
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
    return { title: "Restaurant Discount Voucher Codes" };
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
        .get("/api/restuarant-offers")
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
.restuarant {
  background: url("/images/restuarant.jpg") no-repeat center center;
  background-size: cover;
}
</style>