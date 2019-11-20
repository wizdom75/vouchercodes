<template>
  <div>
    <div class="jumbotron mt-1 mb-3 top-20 rounded-0">
      <h1 class="display-4 text-capitalize mt-3 text-center text-white">Top 20 Offers</h1>
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
          :shop_logo="voucher.logo"
          :shop_title="voucher.store"
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
                  :key="retailer.id"
                >{{retailer.name}}</a>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="banner-square">
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
                  :key="retailer.name"
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
    return { title: this.$t("top-20") };
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
  created() {
    this.getOffers();
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