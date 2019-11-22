<template>
  <card :title="$t('some_stats')">
    <div class="row">
      <div class="col-3 card border-2 border-warning rounded-0 m-1">
        <fa icon="users" class="text-warning" size="5x" />
        <h2 class="h4 text-muted text-center">{{users}}</h2>
        <p class="text-muted text-center">Profiles</p>
      </div>
      <div class="col-3 card border-2 border-info rounded-0 m-1">
        <fa icon="chart-line" class="text-info mx-auto" size="5x" />
        <h2 class="h4 text-muted text-center">{{clicks}}</h2>
        <p class="text-muted text-center">Clicks</p>
      </div>
      <div class="col-3 card border-2 border-danger rounded-0 m-1">
        <fa icon="tags" class="text-danger text-center" size="5x" />
        <h2 class="h4 text-muted text-center">{{vouchers}}</h2>
        <p class="text-muted text-center">Offers</p>
      </div>
      <div class="col-3 card border-2 border-success rounded-0 m-1">
        <fa icon="store" class="text-success text-center" size="5x" />
        <h2 class="h4 text-muted text-center">{{retailers}}</h2>
        <p class="text-muted text-center">Shops</p>
      </div>
    </div>
  </card>
</template>

<script>
import Form from "vform";
import { mapGetters } from "vuex";
import axios from "axios";

export default {
  layout: "admin",
  scrollToTop: false,

  metaInfo() {
    return { title: this.$t("admin_dashboard") };
  },

  data() {
    return {
      users: "",
      clicks: "",
      retailers: "",
      vouchers: ""
    };
  },

  computed: mapGetters({
    user: "auth/user"
  }),

  created() {
    axios.get("/api/admin/users-mumber").then(res => {
      this.users = res.data;
    });
    axios.get("/api/admin/clicks-mumber").then(res => {
      this.clicks = res.data;
    });
    axios.get("/api/admin/retailers-mumber").then(res => {
      this.retailers = res.data;
    });
    axios.get("/api/admin/vouchers-mumber").then(res => {
      this.vouchers = res.data;
    });
  },

  methods: {
    async update() {
      const { data } = await this.form.patch("/api/settings/profile");

      this.$store.dispatch("auth/updateUser", { user: data });
    }
  }
};
</script>
