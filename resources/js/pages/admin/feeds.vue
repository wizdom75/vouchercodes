<template>
  <card :title="$t('feeds')">
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
        <tr v-for="feed in feeds.data" :key="feed.id">
          <th scope="row">{{feed.id}}</th>
          <td>{{feed.affiliate}}</td>
          <td>{{ feed.url | truncate(40) }}</td>
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
            <button
              data-toggle="modal"
              data-target=".feedSettingsModalCenter"
              data-whatever="Edit"
              @click="testFeed(feed)"
              class="btn btn-dark rounded-circle ml-1"
            >
              <fa icon="tools" fixed />
            </button>
            <button @click="runFeed(feed)" class="btn btn-success rounded-circle ml-1">
              <fa icon="check" fixed />
            </button>
            <button @click="deleteItem(feed.id)" class="btn btn-danger rounded-circle ml-3">
              <fa icon="trash" fixed />
            </button>
          </td>
        </tr>
      </tbody>
    </table>
    <pagination
      :limit="3"
      :show-disabled="true"
      :data="feeds"
      :align="'center'"
      @pagination-change-page="getResults"
    ></pagination>
    <!-- BOF feedModal -->
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
                <has-error :form="form" field="affiliate" />
                <input v-model="form.retailer_mid" type="hidden" name="affiliate" />
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
                <v-button :loading="form.busy" type="success">{{ $t('save') }}</v-button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
    <!-- EOF feedModal -->

    <!-- BOF feedSettingsModal -->
    <div
      class="modal fade feedSettingsModalCenter"
      tabindex="-1"
      role="dialog"
      aria-labelledby="feedSettingsModalCenterLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog modal-xl">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="feedSettingsModalCenter">Datafeed Parameter Settings</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div v-if="loading" id="loading">
            <img id="loading-image" src="/images/loading.gif" alt="Loading..." />
          </div>
          <div v-else>
            <form @submit.prevent="storeParams" @keydown="form.onKeydown($event)">
              <alert-success :form="form" :message="$t('reed_params_set')" />
              <div class="row">
                <div class="container" style="overflow-x:auto;">
                  <table class="table-bordered">
                    <tr>
                      <th v-for="numcol in params[0]" :key="numcol">{{ numcol }}</th>
                    </tr>
                    <tr>
                      <td v-for="(key, item) in params[0]" :key="key">
                        <select
                          v-model="paramsForm.columns[item]"
                          :class="{ 'is-invalid': form.errors.has('compression') }"
                          id="sel1"
                          name="columns[]"
                        >
                          <option value>Select</option>
                          <option value="retailer_mid_col">Retailer ID</option>
                          <option value="type_col">Type</option>
                          <option value="code_col">Code</option>
                          <option value="title_col">Title</option>
                          <option value="category_slug_col">Category</option>
                          <option value="blurb_col">Description</option>
                          <option value="terms_col">Terms</option>
                          <option value="promo_id_col">Promotion ID</option>
                          <option value="url_col">Tracking URL</option>
                          <option value="valid_from_col">Valid from</option>
                          <option value="valid_to_col">Valid to</option>
                          <!-- <option <?=($feed->column_brand === $key)?'selected':''?> value="brand">Brand</option> -->
                        </select>
                      </td>
                    </tr>

                    <tr v-for="count in counter" :key="count">
                      <td v-for="item in params[count]" :key="item">{{ item | truncate(40) }}</td>
                    </tr>
                  </table>
                </div>
              </div>
              <!-- Submit Button -->
              <div class="form-group row p-3">
                <div class="col-md-9 ml-md-auto">
                  <input v-model="paramsForm.feed_id" type="text" value="feed.id" />
                  <v-button :loading="paramsForm.busy" type="success">{{ $t('save') }}</v-button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <!-- EOF feedSettingsModal -->
  </card>
</template>

<script>
import Form from "vform";
import axios from "axios";

export default {
  layout: "admin",
  scrollToTop: false,

  metaInfo() {
    return { title: this.$t("feeds") };
  },

  data() {
    return {
      loading: true,
      feeds: "",
      feed_url: "",
      feed_id: "",
      counter: [1, 2, 3, 4, 5],
      params: "",
      edit: false,
      feeds: {},
      page: "",
      pg: "",
      form: new Form({
        affiliate: "",
        url: "",
        compression: ""
      }),
      paramsForm: new Form({
        columns: [],
        feed_id: ""
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
  },

  methods: {
    getResults(page) {
      if (typeof page === "undefined") {
        page = 1;
      }
      this.pg = page;
      axios
        .get("/api/admin/feeds?page=" + page)
        .then(response => {
          this.feeds = response.data;
        })
        .catch(error => {
          console.log(this.form);
        });
    },
    async store() {
      if (this.edit === false) {
        await this.form.submit("post", "/api/admin/feeds");
        this.getResults(this.pg);
      } else {
        await this.form
          .submit("patch", "/api/admin/feeds/" + this.form.id)
          .catch(err => console.log(err));
        this.getResults(this.pg);
      }
    },
    async storeParams() {
      if (this.edit === false) {
        await this.paramsForm.submit("post", "/api/admin/feed-params");
        this.getResults(this.pg);
      } else {
        await this.paramsForm
          .submit("patch", "/api/admin/feed-params" + this.form.id)
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
        fetch("/api/admin/feeds/" + id, {
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
      this.form.affiliate = feed.affiliate;
      this.form.url = feed.url;
      this.form.compression = feed.compression;
      this.form.id = feed.id;
    },
    testFeed(feed) {
      const feed_url = feed.url;
      const feed_compression = feed.compression;
      const feed_affiliate = feed.affiliate;
      axios
        .get("/api/admin/feed-test/" + feed.id)
        .then(response => {
          this.params = response.data;
          console.log(response.data);
          this.loading = false;
        })
        .catch(error => {
          console.log(this.feed_url);
        });
    },
    runFeed(feed) {
      const feed_url = feed.url;
      const feed_compression = feed.compression;
      const feed_affiliate = feed.affiliate;
      axios
        .get("/api/admin/feed-run/" + feed.id)
        .then(response => {
          console.log(response.data);
          this.loading = false;
        })
        .catch(error => {
          console.log(this.feed_url);
        });
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
        .post("/api/admin/feeds-csv/" + prefix, fd)
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
<style scoped >
table td[class*="col-"],
table th[class*="col-"] {
  position: static;
  display: table-cell;
  float: none;
}
#loading {
  width: 100%;
  height: 100%;
  top: 0;
  left: 0;
  position: fixed;
  display: block;
  opacity: 0.7;
  background-color: #fff;
  z-index: 99;
  text-align: center;
}

#loading-image {
  position: absolute;
  top: 50%;
  left: 50%;
  z-index: 100;
}
</style>
