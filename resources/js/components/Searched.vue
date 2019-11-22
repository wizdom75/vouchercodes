<template>
  <div class="card">
    <div class="card-body">
      <div class="card-title text-muted h4">Top deal searches</div>
      <div class="card-text">
        <router-link
          v-for="retailer in retailers"
          :to="'/'+retailer.slug"
          :loading="retailer.busy"
          class="btn btn-light text-muted m-1"
          :key="retailer.mid"
        >{{ retailer.title }} Voucher Codes</router-link>
      </div>
    </div>
  </div>
</template>

<script>
import { mapGetters } from "vuex";
import axios from "axios";
export default {
  name: "Searched",
  data() {
    return {
      retailers: "",
      monthYear: null
    };
  },
  created() {
    this.getMonthAndYear();
    axios
      .get("/api/searched")
      .then(response => {
        this.retailers = response.data;
      })
      .catch(error => {
        console.log(error);
      });
  },
  props: {
    title: { type: String, default: null },
    category: { type: String, default: "clothes" }
  },
  methods: {
    getMonthAndYear() {
      var dt = new Date();

      this.monthYear =
        dt.toLocaleString("default", { month: "long" }) +
        " " +
        dt.getFullYear();
    }
  }
};
</script>
