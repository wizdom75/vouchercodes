<template>
  <card :title="$t('admin_submission')">
    <table class="table">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">Shop</th>
          <th scope="col">Code</th>
          <th scope="col">Expiry date</th>
          <th scope="col"></th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="feed in submission.data" :key="feed.id">
          <th scope="row">{{feed.id}}</th>
          <td>{{feed.retailer_name}}</td>
          <td>{{feed.code}}</td>
          <td>{{feed.expiry_date}}</td>
          <td>
            <button
              data-toggle="modal"
              data-target=".feedModalCenter"
              data-whatever="Edit"
              @click="editItem(feed)"
              class="btn btn-info rounded-circle"
            >
              <fa icon="edit" fixed />
            </button>
            <button @click="deleteItem(feed.id)" class="btn btn-danger rounded-circle ml-5">
              <fa icon="trash" fixed />
            </button>
          </td>
        </tr>
      </tbody>
    </table>
    <pagination
      :limit="3"
      :show-disabled="true"
      :data="submission"
      :align="'center'"
      @pagination-change-page="getResults"
    ></pagination>
  </card>
</template>

<script>
import Form from "vform";
import axios from "axios";

export default {
  layout: "admin",
  scrollToTop: false,

  metaInfo() {
    return { title: this.$t("admin_submission") };
  },

  data() {
    return {
      submission: {},
      form: new Form({
        retailer_mid: "",
        type: "",
        title: "",
        code: "",
        blurb: "",
        terms: "",
        url: "",
        valid_from: "",
        valid_to: "",
        id: ""
      })
    };
  },
  mounted() {
    this.getResults(this.pg);
    axios
      .get("/api/admin/retailers/index")
      .then(response => {
        this.retailers = response.data;
      })
      .catch(error => {
        console.log(this.retailers);
      });
  },

  methods: {
    getResults(page) {
      if (typeof page === "undefined") {
        page = 1;
      }
      this.pg = page;
      axios
        .get("/api/admin/suggested-codes?page=" + page)
        .then(response => {
          this.submission = response.data;
        })
        .catch(error => {
          console.log(this.form);
        });
    },
    async store() {
      if (this.edit === false) {
        await this.form.post("post", "/api/admin/submission");
        this.getResults(this.pg);
      } else {
        await this.form
          .submit("patch", "/api/admin/submission/" + this.form.id)
          .catch(err => console.log(err));
        this.getResults(this.pg);
      }
    },
    deleteItem(id) {
      if (
        confirm(
          "This action cannot be undone, Are you sure you want to delete this item?"
        )
      ) {
        fetch("/api/admin/submission/" + id, {
          method: "delete"
        })
          .then(res => res.json())
          .then(data => {
            this.getResults(this.pg);
          })
          .catch(err => console.log(err));
      }
    },
    editItem(feed) {
      this.edit = true;
      this.form.title = feed.title;
      this.form.code = feed.code;
      this.form.type = feed.type;
      this.form.blurb = feed.blurb;
      this.form.terms = feed.terms;
      this.form.url = feed.url;
      this.form.valid_from = feed.valid_from;
      this.form.valid_to = feed.valid_to;
      this.form.retailer_mid = feed.retailer_mid;
      this.form.id = feed.id;
    },
    clearForm() {
      this.form.reset();
      this.edit = false;
    },
    selectCSV() {
      this.csv = "";
      const e = window.event;
      const file = e.target.files[0];
      this.csv_file = file;
      this.prefix = this.$refs.affliate_prefix.value;
      console.log(this.csv_file, this.prefix);
      this.csvUpload(this.prefix);
    },
    csvUpload(prefix) {
      const fd = new FormData();
      fd.append("csv_file", this.csv_file, this.csv_file.name);
      axios
        .post("/api/admin/submission-csv/" + prefix, fd)
        .then(res => {
          console.log(res);
          this.getResults(this.pg);
        })
        .catch(err => {
          console.log(err);
        });
    }
  }
};
</script>
