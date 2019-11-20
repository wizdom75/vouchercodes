<template>
  <card :title="$t('submission')">
    <table class="table">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">Affiliate</th>
          <th scope="col">URL</th>
          <th scope="col">Compression</th>
          <th scope="col">
            <button
              type="button"
              class="btn btn-success rounded-circle"
              data-toggle="modal"
              @click="clearForm()"
              data-target=".feedModalCenter"
            >
              <fa icon="plus" class="text-white" fixed />
            </button>
          </th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="feed in submission.data" :key="feed.id">
          <th scope="row">{{feed.id}}</th>
          <td>{{feed.affiliate}}</td>
          <td>{{feed.url}}</td>
          <td>{{feed.compression}}</td>
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
    <div
      class="modal fade feedModalCenter"
      tabindex="-1"
      role="dialog"
      aria-labelledby="feedModalCenterLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="feedModalCenter">Add a new feed</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form @submit.prevent="store" @keydown="form.onKeydown($event)">
            <alert-success :form="form" :message="$t('new_feed_created')" />
            <!-- Affiliate supplying feed  -->
            <div class="form-group row p-3">
              <label class="col-md-3 col-form-label text-md-right">{{ $t('affiliate_feed') }}</label>
              <div class="col-md-7">
                <select
                  v-model="form.affiliate"
                  :class="{ 'is-invalid': form.errors.has('affiliate') }"
                  class="form-control"
                  name="affiliate"
                >
                  <option value>-Please Select-</option>
                  <option
                    v-for="affiliate in affiliates"
                    :value="affiliate.prefix"
                    :key="affiliate.prefix"
                  >{{affiliate.name}}</option>
                </select>
                <has-error :form="form" field="retailer_mid" />
                <input v-model="form.retailer_mid" type="hidden" name="retailer_mid" />
              </div>
            </div>
            <!-- feed compression -->
            <div class="form-group row p-3">
              <label class="col-md-3 col-form-label text-md-right">{{ $t('feed_compression') }}</label>
              <div class="col-md-7">
                <select
                  v-model="form.compression"
                  :class="{ 'is-invalid': form.errors.has('compression') }"
                  class="form-control"
                  type="text"
                  name="compression"
                >
                  <option value>-Please select-</option>
                  <option value="none">None</option>
                  <option value="gz">GZip</option>
                  <option value="zip">ZIP</option>
                  <option value="rar">RAR</option>
                </select>
                <has-error :form="form" field="type" />
              </div>
            </div>
            <!-- feed url -->
            <div class="form-group row p-3">
              <label class="col-md-3 col-form-label text-md-right">{{ $t('feed_url') }}</label>
              <div class="col-md-7">
                <textarea
                  v-model="form.url"
                  :class="{ 'is-invalid': form.errors.has('url') }"
                  class="form-control"
                  type="text"
                  name="url"
                ></textarea>
                <has-error :form="form" field="url" />
              </div>
            </div>

            <!-- Submit Button -->
            <div class="form-group row p-3">
              <div class="col-md-9 ml-md-auto">
                <v-button :loading="form.busy" type="success">{{ $t('Save') }}</v-button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </card>
</template>

<script>
import Form from "vform";
import axios from "axios";

export default {
  layout: "admin",
  scrollToTop: false,

  metaInfo() {
    return { title: this.$t("Admin submission") };
  },

  data() {
    return {
      submission: "",
      retailers: "",
      edit: false,
      submission: {},
      page: "",
      pg: "",
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
      }),
      affiliates: [
        {
          prefix: "AW",
          name: "Affiliate Window"
        },
        {
          prefix: "CJ",
          name: "Commission Junction"
        },
        {
          prefix: "AF",
          name: "Affiliate Future"
        },
        {
          prefix: "SS",
          name: "Sharesale"
        },
        {
          prefix: "WG",
          name: "Webgains"
        },
        {
          prefix: "PR",
          name: "Paid on Results"
        }
      ]
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
        .get("/api/admin/submission?page=" + page)
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
