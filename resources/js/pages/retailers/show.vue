<template>
  <div class="container">
    <div class="card mt-3 flex-row flex-wrap border-0 bg-light">
      <div class="card-header border-0">
        <img :src="shop.logo" :alt="shop.title" class="border-0 m-0" width="100px" />
      </div>
      <div class="card-body border-0 rounded-0">
        <h1 class="h4 mb-0">
          {{shop.title}}
          <span class="text-muted">{{monthYear}} Voucher Codes</span>
        </h1>

        <br />
        <button class="btn btn-sm btn-outline-secondary small rounded-0">Favorite</button>

        <a
          :href="'/out/redirect/'+shop.mid"
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
          <PopularShops title="Popular shops" :category="shop.title"></PopularShops>
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
    axios
      .get("/api/retailer/" + this.$route.params.slug)
      .then(response => {
        this.shop = response.data;
        this.getOffers(response.data.mid);
        console.log(this.shop);
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
        .catch(error => {
          console.log(error);
        });
    }
  }
};
</script>
