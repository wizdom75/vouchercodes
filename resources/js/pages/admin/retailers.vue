<template>
  <card :title="$t('retailers')">
    <table class="table">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">Title</th>
          <th scope="col">Slug</th>
          <th scope="col">logo</th>
          <th scope="col">
            <button
              type="button"
              class="btn btn-success rounded-circle"
              data-toggle="modal"
              @click="clearForm()"
              data-target=".retailerModalCenter"
            >
              <fa icon="plus" class="text-white" fixed />
            </button>
            <button
              type="button"
              class="btn btn-warning rounded-circle ml-5"
              data-toggle="modal"
              @click="clearForm()"
              data-target=".bulkImportCSV"
            >
              <fa icon="upload" class="text-white" fixed />
            </button>
          </th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(retailer, counter) in retailers.data" :key="retailer.mid">
          <td>{{retailer.mid}}</td>
          <td>{{retailer.title}}</td>
          <td>{{retailer.slug}}</td>
          <td>
            <input
              style="display: none"
              name="logo"
              type="file"
              @change="selectFile(retailer.mid)"
              ref="logoInput"
            />
            <button @click="$refs['logoInput'][counter++].click()">
              <img
                :src="retailer.logo"
                :alt="retailer.title"
                class="img-thumbnail border-0"
                width="80px"
              />
            </button>
          </td>
          <td>
            <button
              data-toggle="modal"
              data-target=".retailerModalCenter"
              data-whatever="Edit"
              @click="editItem(retailer)"
              class="btn btn-info rounded-circle"
            >
              <fa icon="edit" fixed />
            </button>
            <button @click="deleteItem(retailer.mid)" class="btn btn-danger rounded-circle ml-5">
              <fa icon="trash" fixed />
            </button>
          </td>
        </tr>
      </tbody>
    </table>
    <pagination
      :limit="3"
      :show-disabled="true"
      :data="retailers"
      :align="'center'"
      @pagination-change-page="getResults"
    ></pagination>
    <!-- Modal form for adding retailers 1 by 1 -->
    <div
      class="modal fade retailerModalCenter"
      tabindex="-1"
      role="dialog"
      aria-labelledby="retailerModalCenterLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="retailerModalCenter">Add a new retailer</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form
            @submit.prevent="store"
            @keydown="form.onKeydown($event)"
            enctype="multipart/form-data"
          >
            <alert-success :form="form" :message="$t('new_retailer_created')" />
            <!-- retailer user_id -->
            <div class="form-group row p-3">
              <label class="col-md-3 col-form-label text-md-right">{{ $t('retailer_user_id') }}</label>
              <div class="col-md-7">
                <input
                  v-model="form.user_id"
                  :class="{ 'is-invalid': form.errors.has('user_id') }"
                  class="form-control"
                  type="text"
                  name="user_id"
                />
                <has-error :form="form" field="user_id" />
              </div>
            </div>
            <!-- retailer parent -->
            <div class="form-group row p-3">
              <label class="col-md-3 col-form-label text-md-right">{{ $t('retailer_mid') }}</label>
              <div class="col-md-7">
                <input
                  v-model="form.mid"
                  :class="{ 'is-invalid': form.errors.has('mid') }"
                  class="form-control"
                  type="text"
                  name="mid"
                />
                <has-error :form="form" field="mid" />
              </div>
            </div>
            <!-- retailer title -->
            <div class="form-group row p-3">
              <label class="col-md-3 col-form-label text-md-right">{{ $t('retailer_title') }}</label>
              <div class="col-md-7">
                <input
                  v-model="form.title"
                  :class="{ 'is-invalid': form.errors.has('title') }"
                  class="form-control"
                  type="text"
                  name="title"
                />
                <has-error :form="form" field="title" />
              </div>
            </div>
            <!-- retailer slug -->
            <div class="form-group row p-3">
              <label class="col-md-3 col-form-label text-md-right">{{ $t('retailer_slug') }}</label>
              <div class="col-md-7">
                <input
                  v-model="form.slug"
                  :class="{ 'is-invalid': form.errors.has('slug') }"
                  class="form-control"
                  type="text"
                  name="slug"
                />
                <has-error :form="form" field="slug" />
              </div>
            </div>
            <!-- retailer meta -->
            <div class="form-group row p-3">
              <label class="col-md-3 col-form-label text-md-right">{{ $t('retailer_meta') }}</label>
              <div class="col-md-7">
                <input
                  v-model="form.meta"
                  :class="{ 'is-invalid': form.errors.has('meta') }"
                  class="form-control"
                  type="text"
                  name="meta"
                />
                <has-error :form="form" field="meta" />
              </div>
            </div>
            <!-- retailer description -->
            <div class="form-group row p-3">
              <label class="col-md-3 col-form-label text-md-right">{{ $t('retailer_description') }}</label>
              <div class="col-md-7">
                <textarea
                  v-model="form.description"
                  :class="{ 'is-invalid': form.errors.has('description') }"
                  class="form-control"
                  name="description"
                ></textarea>
                <input type="hidden" name="id" v-model="form.id" />
                <has-error :form="form" field="description" />
              </div>
            </div>
            <!-- retailer url -->
            <div class="form-group row p-3">
              <label class="col-md-3 col-form-label text-md-right">{{ $t('retailer_url') }}</label>
              <div class="col-md-7">
                <input
                  v-model="form.url"
                  :class="{ 'is-invalid': form.errors.has('url') }"
                  class="form-control"
                  type="text"
                  name="url"
                />
                <has-error :form="form" field="url" />
              </div>
            </div>
            <!-- retailer tracking url -->
            <div class="form-group row p-3">
              <label class="col-md-3 col-form-label text-md-right">{{ $t('retailer_tracking_url') }}</label>
              <div class="col-md-7">
                <input
                  v-model="form.tracking_url"
                  :class="{ 'is-invalid': form.errors.has('tracking_url') }"
                  class="form-control"
                  type="text"
                  name="tracking_url"
                />
                <has-error :form="form" field="tracking_url" />
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
    <!-- EoF form for adding retailers 1 by 1 -->

    <!-- Beginning of modal for bulk importation of retailers -->
    <div
      class="modal fade bulkImportCSV"
      tabindex="-1"
      role="dialog"
      aria-labelledby="bulkImportCSVLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="bulkImportCSV">Import Retailers from CSV</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form
            @submit.prevent="csvUpload"
            @keydown="form.onKeydown($event)"
            enctype="multipart/form-data"
          >
            <alert-success :form="form" :message="$t('new_retailers_imported')" />
            <!-- Affiliate network -->
            <div class="form-group row p-3">
              <label class="col-md-3 col-form-label text-md-right">{{ $t('affiliate_network') }}</label>
              <div class="col-md-7">
                <select
                  :class="{ 'is-invalid': form.errors.has('affiliate_network') }"
                  class="form-control"
                  type="text"
                  name="affiliate_network"
                  ref="affliate_prefix"
                >
                  <option>-Please select-</option>
                  <option
                    v-for="affiliate in affiliates"
                    :value="affiliate.prefix"
                    :key="affiliate.prefix"
                  >{{affiliate.name}}</option>
                </select>
                <has-error :form="form" field="affiliate_network" />
              </div>
            </div>
            <!-- Select a CSV file -->
            <div class="form-group row p-3">
              <label class="col-md-3 col-form-label text-md-right">{{ $t('csv_file') }}</label>
              <div class="col-md-7">
                <input
                  :class="{ 'is-invalid': form.errors.has('csv_file') }"
                  class="form-control"
                  type="file"
                  name="csv_file"
                  @change="selectCSV()"
                />
              </div>
            </div>
            <!-- Submit Button -->
            <div class="form-group row p-3">
              <div class="col-md-9 ml-md-auto">
                <v-button :loading="form.busy" type="success">{{ $t('upload') }}</v-button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
    <!-- End of modal for bulk importation of retailers -->
  </card>
</template>

<script>
import Form from "vform";
import axios from "axios";
import objectToFormData from "object-to-formdata";

export default {
  layout: "admin",
  scrollToTop: false,

  metaInfo() {
    return { title: this.$t("admin_retailers") };
  },

  data() {
    return {
      retailers: {},
      pg: "",
      edit: false,
      form: new Form({
        mid: "",
        user_id: "",
        title: "",
        slug: "",
        meta: "",
        description: "",
        url: "",
        tracking_url: ""
      }),
      mid: null,
      logo: null,
      counter: 0,
      csv_file: null,
      prefix: null,
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
        .get("/api/admin/retailers?page=" + page)
        .then(response => {
          this.retailers = response.data;
        })
        .catch(error => {
          console.log(error);
        });
    },
    async store() {
      if (this.edit === false) {
        await this.form
          .post("post", "/api/admin/retailers")
          .catch(err => console.log(err));
        this.getResults(this.pg);
      } else {
        await this.form
          .submit("patch", "/api/admin/retailers/" + this.form.mid)
          .catch(err => console.log(err));
        this.getResults(this.pg);
      }
    },
    deleteItem(mid) {
      if (
        confirm(
          "This action cannot be undone, Are you sure you want to delete this item?"
        )
      ) {
        fetch("/api/admin/retailers/" + mid, {
          method: "delete"
        })
          .then(res => res.json())
          .then(data => {
            this.getResults(this.pg);
          })
          .catch(err => console.log(err));
      }
    },
    editItem(retailer) {
      this.edit = true;
      this.form.title = retailer.title;
      this.form.slug = retailer.slug;
      this.form.meta = retailer.meta;
      this.form.description = retailer.description;
      this.form.url = retailer.url;
      this.form.tracking_url = retailer.tracking_url;
      this.form.user_id = retailer.user_id;
      this.form.mid = retailer.mid;
    },
    clearForm() {
      this.form.reset();
      this.edit = false;
    },
    selectFile(mid) {
      this.logo = "";
      const e = window.event;
      const file = e.target.files[0];
      this.logo = file;
      this.mid = mid;

      console.log(this.logo, this.mid);
      this.fileUpload(this.mid);
    },
    fileUpload(mid) {
      const fd = new FormData();
      fd.append("logo", this.logo, this.logo.name);
      axios
        .post("/api/admin/logo-upload/" + mid, fd)
        .then(res => {
          console.log(res);
          this.getResults(this.pg);
        })
        .catch(err => {
          console.log(err);
        });
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
        .post("/api/admin/retailers-csv/" + prefix, fd)
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
