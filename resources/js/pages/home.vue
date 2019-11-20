<template>
  <div>
    <div class="jumbotron text-center bg-dark rounded-0 mt-1 first">
      <div id="overlay"></div>
      <div class="display-4 mb-4 text-white">Save money with ease.</div>

      <div class="text-white">
        <p class="h3">Voucher Codes for your favourite UK shops</p>
      </div>
    </div>
    <h1 class="h3 text-muted">Most Popular Today</h1>
    <div class="row">
      <FeaturedCard
        v-for="top in top20"
        :key="top.id"
        :voucher_title="top.title"
        :shop_link="top.slug"
        :shop_banner="'/images/vouchers/brown-hat.jpg'"
        :shop_logo="top.logo"
        :shop_name="top.store"
        :styles="'col-md-4 col-6 mb-3 p-0'"
      ></FeaturedCard>
    </div>
    <Subscribe></Subscribe>
    <h1 class="h3 text-muted">Health & Beauty</h1>
    <div class="row">
      <FeaturedCard
        v-for="top in featured1"
        :key="top.id"
        :voucher_title="top.title"
        :shop_link="top.slug"
        :shop_banner="'/images/vouchers/hollister.jpg'"
        :shop_logo="top.logo"
        :shop_name="top.store"
        :styles="'col-md-4 col-6 mb-3 p-0'"
      ></FeaturedCard>
    </div>
    <h1 class="h3 text-muted">Women's Fashion</h1>
    <div class="row">
      <FeaturedCard
        v-for="top in featured2"
        :key="top.id"
        :voucher_title="top.title"
        :shop_link="top.slug"
        :shop_banner="'/images/vouchers/hollister.jpg'"
        :shop_logo="top.logo"
        :shop_name="top.store"
        :styles="'col-md-3 col-6 mb-3 p-0'"
      ></FeaturedCard>
    </div>
    <h1 class="h3 text-muted">Travel</h1>
    <div class="row">
      <FeaturedCard
        v-for="top in featured3"
        :key="top.id"
        :voucher_title="top.title"
        :shop_link="top.slug"
        :shop_banner="'/images/vouchers/hollister.jpg'"
        :shop_logo="top.logo"
        :shop_name="top.store"
        :styles="'col-md-3 col-6 mb-3 p-0'"
      ></FeaturedCard>
    </div>
    <h1 class="h3 text-muted">Printable Vouchers</h1>
    <div class="row">
      <FeaturedCard
        v-for="top in featured4"
        :key="top.id"
        :voucher_title="top.title"
        :shop_link="top.slug"
        :shop_banner="'/images/vouchers/hollister.jpg'"
        :shop_logo="top.logo"
        :shop_name="top.store"
        :styles="'col-md-3 col-6 mb-3 p-0'"
      ></FeaturedCard>
    </div>
  </div>
</template>

<script>
import { mapGetters } from "vuex";
import axios from "axios";
export default {
  metaInfo() {
    return { title: this.$t("home") };
  },
  data() {
    return {
      title: window.config.appName,
      top20: "",
      featured1: "",
      featured2: "",
      featured3: "",
      featured4: ""
    };
  },
  mounted() {
    this.getOffers();
  },
  methods: {
    getOffers() {
      axios
        .get("/api/featured-offers")
        .then(response => {
          this.top20 = response.data[0];
          this.featured1 = response.data[1];
          this.featured2 = response.data[2];
          this.featured3 = response.data[3];
          this.featured4 = response.data[4];
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
.top-right {
  position: absolute;
  right: 10px;
  top: 18px;
}
.title {
  font-size: 85px;
}
.top-left {
  position: absolute;
  right: 10px;
  top: 18px;
}
.first {
  background: url("/images/firstbanner.jpg") no-repeat center center;
  background-size: cover;
}
.mailist {
  background: url("/images/mailist.jpg") no-repeat center center;
  background-size: cover;
}
#overlay {
  position: fixed; /* Sit on top of the page content */
  display: none; /* Hidden by default */
  width: 100%; /* Full width (cover the whole page) */
  height: 100%; /* Full height (cover the whole page) */
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: rgba(0, 0, 0, 0.9); /* Black background with opacity */
  z-index: 100; /* Specify a stack order in case you're using a different order for other elements */
}
</style>
