<template>
  <div>
    <div class="jumbotron mt-1 mb-0 nhs rounded-0">
      <h1 class="display-4 text-capitalize mt-3 text-center text-white">NHS Workers' Deals & Offers</h1>
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
            <PopularShops title="Popular shops" category="nhs"></PopularShops>
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
    return { title: this.$t("NHS staff deals") };
  },
  data() {
    return {
      title: window.config.appName,
      vouchers: "",
      feedback: null,
      retailers: [
        {
          name: "Retailer.com"
        },
        {
          name: "shop.co.uk"
        },
        {
          name: "amazon.co.uk"
        },
        {
          name: "Currys PC World"
        },
        {
          name: "Perfume Shop"
        },
        {
          name: "Gango.com"
        },
        {
          name: "advancedmp3players.co.uk"
        },
        {
          name: "ebay.co.uk"
        },
        {
          name: "Holland & Barratt"
        },
        {
          name: "HMV"
        },
        {
          name: "ASOS"
        },
        {
          name: "ASDA"
        },
        {
          name: "Tesco"
        }
      ]
    };
  },
  computed: mapGetters({
    authenticated: "auth/check"
  }),
  created() {
    this.getOffers();
  },
  methods: {
    getOffers() {
      axios
        .get("/api/nhs-offers")
        .then(response => {
          this.vouchers = response.data;
        })
        .catch(error => {
          console.log(error);
        });
    }
  }
};
</script>
<style scoped>
.nhs {
  background: url("/images/nhs.jpg") no-repeat center center;
  background-size: cover;
}
</style>