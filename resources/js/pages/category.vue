<template>
  <div>
    <div class="container">
      <span>All categories</span>
    </div>

    <div class="jumbotron mt-1 rounded-0 mb-0 contact">
      <h1 class="display-4 text-capitalize text-center text-white">{{ctgry.title}}</h1>
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
            :shop_title="shop.title"
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
            <PopularShops title="Popular shops" :category="slg"></PopularShops>
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
    return { title: this.$route.params.slug };
  },
  data() {
    return {
      title: window.config.appName,
      feedback: null,
      vouchers: "",
      retailers: [
        {
          id: 1,
          name: "Retailer.com"
        },
        {
          id: 2,
          name: "shop.co.uk"
        },
        {
          id: 3,
          name: "amazon.co.uk"
        },
        {
          id: 4,
          name: "Currys PC World"
        },
        {
          id: 5,
          name: "Perfume Shop"
        },
        {
          id: 6,
          name: "Gango.com"
        },
        {
          id: 7,
          name: "advancedmp3players.co.uk"
        },
        {
          id: 8,
          name: "ebay.co.uk"
        },
        {
          id: 9,
          name: "Holland & Barratt"
        },
        {
          id: 10,
          name: "HMV"
        },
        {
          id: 11,
          name: "ASOS"
        },
        {
          id: 12,
          name: "ASDA"
        },
        {
          id: 13,
          name: "Tesco"
        }
      ],
      shop: {},
      months: null,
      monthYear: null,
      ctgry: null,
      slg: this.$route.params.slug
    };
  },
  computed: mapGetters({
    authenticated: "auth/check"
  }),
  created() {
    this.getMonthAndYear();
    this.getOffers();
  },
  methods: {
    getMonthAndYear() {
      var dt = new Date();

      this.monthYear =
        dt.toLocaleString("default", { month: "long" }) +
        " " +
        dt.getFullYear();
    },
    getOffers() {
      axios
        .get("/api/offers-by-category/" + this.$route.params.slug)
        .then(response => {
          this.vouchers = response.data[0];
          this.ctgry = response.data[1];
        })
        .catch(error => {
          console.log(error);
        });
    },
    feedback() {
      this.feedback = null;
    }
  }
};
</script>
<style scoped>
input[type="text"],
textarea {
  outline: none;
  box-shadow: none !important;
  border: 1px dashed rgb(236, 226, 226) !important;
  text-align: center;
  padding: 10px 15px;
}
</style>