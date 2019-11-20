<template>
  <div>
    <span>All categories</span>
    <h1 class="h4 text-left text-muted">Category Voucher Codes & Deals</h1>
    <div class="jumbotron mt-1 rounded-0 mb-3 contact"></div>

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
          <div class="card">
            <div class="card-body">
              <div class="card-title text-muted h4">Top deal searches</div>
              <div class="card-text">
                <a
                  :href="retailer.name"
                  v-for="retailer in retailers"
                  class="btn btn-light text-muted m-1"
                  :key="retailer.name"
                >{{retailer.name}}</a>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="banner-square mt-3">
          <img
            class="banner w-100"
            src="https://via.placeholder.com/300x300.png/3d9/fff?text=Banner+Ad"
            alt
          />
        </div>
        <div class="mt-3">
          <BrowseCard></BrowseCard>
        </div>
        <div class="mt-3">
          <div class="card">
            <div class="card-body">
              <div class="card-title text-muted h4">Popular retailers</div>
              <div class="card-text">
                <p class="text-muted text-small">Even more deals, promos and codes for November 2019</p>
                <a
                  :href="retailer.name"
                  v-for="retailer in retailers"
                  class="btn btn-light text-muted m-1"
                  :key="retailer.id"
                >{{retailer.name}}</a>
              </div>
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
      monthYear: null
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
          this.vouchers = response.data;
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