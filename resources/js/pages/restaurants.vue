<template>
  <div>
    <div class="jumbotron jumbotron-fluid mt-1 mb-3 restuarant">
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
                  v-for="retailer in sellers"
                  class="btn btn-light text-muted m-1"
                  :key="retailer.name"
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
                  v-for="retailer in sellers"
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
    return { title: "Restaurant Discount Voucher Codes" };
  },
  data() {
    return {
      title: window.config.appName,
      vouchers: "",
      feedback: null,
      sellers: [
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
      ]
    };
  },
  created() {
    this.getOffers();
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