<template>
  <div class="container">
    <h1 class="h3 page-heading text-capitalize mt-3">{{head}}</h1>

    <BrowseCard title></BrowseCard>

    <div class="row mb-5">
      <div class="col-md-8">
        <div class="card mt-3 flex-row flex-wrap p-5">
          <router-link
            v-for="retailer in retails"
            :to="'/'+retailer.slug"
            :loading="retailer.busy"
            class="col-md-4 p-1"
            :key="retailer.mid"
          >{{ retailer.title }}</router-link>
        </div>
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
          <PopularShops title="Popular shops" category="all"></PopularShops>
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
    return {
      title: this.$t("retailers"),
      metaTags: [
        {
          name: "description",
          content: "The home page of our example app."
        },
        {
          property: "og:description",
          content: "The home page of our example app."
        }
      ]
    };
  },
  data() {
    return {
      title: window.config.appName,
      retails: null,
      head: null,
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
  computed: mapGetters({
    authenticated: "auth/check"
  }),
  mounted() {
    if (this.$route.params.char === undefined) {
      this.head = "All Retailers";
      axios
        .get("/api/sellers/all")
        .then(response => {
          this.retails = response.data;
        })
        .catch(error => {
          console.log(error);
        });
    } else {
      if (typeof this.$route.params.char === "string")
        this.head = "All " + this.$route.params.char + " Retailers";
      axios
        .get("/api/sellers/" + this.$route.params.char)
        .then(response => {
          this.retails = response.data;
        })
        .catch(error => {
          console.log(error);
        });
    }
  }
};
</script>