<template>
  <card :title="$t('admin_vouchers')">
    <table class="table">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">Retailer ID</th>
          <th scope="col">Title</th>
          <th scope="col">Type</th>
          <th scope="col">Code</th>
          <th scope="col">Valid to</th>
          <th scope="col">
            <button
              type="button"
              class="btn btn-success rounded-circle"
              data-toggle="modal"
              @click="clearForm()"
              data-target=".voucherModalCenter"
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
        <tr v-for="voucher in vouchers.data" :key="voucher.id">
          <th scope="row">{{voucher.id}}</th>
          <td>{{voucher.retailer_mid}}</td>
          <td>{{ voucher.title | truncate(20) }}</td>
          <td>{{voucher.type}}</td>
          <td>{{voucher.code}}</td>
          <td>{{voucher.valid_to}}</td>
          <td>
            <button
              data-toggle="modal"
              data-target=".voucherModalCenter"
              data-whatever="Edit"
              @click="editItem(voucher)"
              class="btn btn-info rounded-circle"
            >
              <fa icon="edit" fixed />
            </button>
            <button @click="deleteItem(voucher.id)" class="btn btn-danger rounded-circle ml-5">
              <fa icon="trash" fixed />
            </button>
          </td>
        </tr>
      </tbody>
    </table>
    <pagination
      :limit="3"
      :show-disabled="true"
      :data="vouchers"
      :align="'center'"
      @pagination-change-page="getResults"
    ></pagination>
    <div
      class="modal fade voucherModalCenter"
      tabindex="-1"
      role="dialog"
      aria-labelledby="voucherModalCenterLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="voucherModalCenter">Add a new voucher</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form @submit.prevent="store" @keydown="form.onKeydown($event)">
            <alert-success :form="form" :message="$t('new_voucher_created')" />
            <!-- voucher retailer_mid -->
            <div class="form-group row p-3">
              <label class="col-md-3 col-form-label text-md-right">{{ $t('voucher_retailer_mid') }}</label>
              <div class="col-md-7">
                <select
                  v-model="form.retailer_mid"
                  :class="{ 'is-invalid': form.errors.has('retailer_mid') }"
                  class="form-control"
                  name="retailer_mid"
                >
                  <option value>-Please Select-</option>
                  <option
                    v-for="retailer in retailers"
                    :value="retailer.mid"
                    :key="retailer.mid"
                  >{{retailer.title}}</option>
                </select>
                <has-error :form="form" field="retailer_mid" />
                <input v-model="form.retailer_mid" type="hidden" name="retailer_mid" />
              </div>
            </div>
            <!-- voucher type -->
            <div class="form-group row p-3">
              <label class="col-md-3 col-form-label text-md-right">{{ $t('voucher_type') }}</label>
              <div class="col-md-7">
                <select
                  v-model="form.type"
                  :class="{ 'is-invalid': form.errors.has('type') }"
                  class="form-control"
                  type="text"
                  name="type"
                >
                  <option value>-Please select-</option>
                  <option value="deal">Deal</option>
                  <option value="code">Code</option>
                  <option value="sale">Sale</option>
                </select>
                <has-error :form="form" field="type" />
              </div>
            </div>
            <!-- voucher title -->
            <div class="form-group row p-3">
              <label class="col-md-3 col-form-label text-md-right">{{ $t('voucher_title') }}</label>
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
            <!-- voucher code -->
            <div class="form-group row p-3">
              <label class="col-md-3 col-form-label text-md-right">{{ $t('voucher_code') }}</label>
              <div class="col-md-7">
                <input
                  v-model="form.code"
                  :class="{ 'is-invalid': form.errors.has('code') }"
                  class="form-control"
                  type="text"
                  name="code"
                />
                <has-error :form="form" field="code" />
              </div>
            </div>
            <!-- voucher blurb -->
            <div class="form-group row p-3">
              <label class="col-md-3 col-form-label text-md-right">{{ $t('voucher_blurb') }}</label>
              <div class="col-md-7">
                <input
                  v-model="form.blurb"
                  :class="{ 'is-invalid': form.errors.has('blurb') }"
                  class="form-control"
                  type="text"
                  name="blurb"
                />
                <has-error :form="form" field="blurb" />
              </div>
            </div>
            <!-- voucher terms -->
            <div class="form-group row p-3">
              <label class="col-md-3 col-form-label text-md-right">{{ $t('voucher_terms') }}</label>
              <div class="col-md-7">
                <input
                  v-model="form.terms"
                  :class="{ 'is-invalid': form.errors.has('terms') }"
                  class="form-control"
                  type="text"
                  name="terms"
                />
                <has-error :form="form" field="terms" />
              </div>
            </div>
            <!-- voucher url -->
            <div class="form-group row p-3">
              <label class="col-md-3 col-form-label text-md-right">{{ $t('voucher_url') }}</label>
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
            <!-- voucher valid_from -->
            <div class="form-group row p-3">
              <label class="col-md-3 col-form-label text-md-right">{{ $t('voucher_valid_from') }}</label>
              <div class="col-md-7">
                <input
                  v-model="form.valid_from"
                  :class="{ 'is-invalid': form.errors.has('valid_from') }"
                  class="form-control"
                  type="date"
                  name="valid_from"
                />
                <has-error :form="form" field="valid_from" />
              </div>
            </div>
            <!-- voucher valid_to -->
            <div class="form-group row p-3">
              <label class="col-md-3 col-form-label text-md-right">{{ $t('voucher_valid_to') }}</label>
              <div class="col-md-7">
                <input
                  v-model="form.valid_to"
                  :class="{ 'is-invalid': form.errors.has('valid_to') }"
                  class="form-control"
                  type="date"
                  name="valid_to"
                />
                <has-error :form="form" field="valid_to" />
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
    <!-- Beginning of modal for bulk importation of vouchers -->
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
            <h5 class="modal-title" id="bulkImportCSV">Import vouchers from CSV</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form
            @submit.prevent="csvUpload"
            @keydown="form.onKeydown($event)"
            enctype="multipart/form-data"
          >
            <alert-success :form="form" :message="$t('new_vouchers_imported')" />
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
    <!-- End of modal for bulk importation of vouchers -->
  </card>
</template>

<script>
import Form from "vform";
import axios from "axios";

export default {
  layout: "admin",
  scrollToTop: false,

  metaInfo() {
    return { title: this.$t("admin_vouchers") };
  },

  data() {
    return {
      vouchers: "",
      retailers: "",
      edit: false,
      vouchers: {},
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
        .get("/api/admin/vouchers?page=" + page)
        .then(response => {
          this.vouchers = response.data;
        })
        .catch(error => {
          console.log(this.form);
        });
    },
    async store() {
      if (this.edit === false) {
        await this.form.submit("post", "/api/admin/vouchers");
        this.getResults(this.pg);
      } else {
        await this.form
          .submit("patch", "/api/admin/vouchers/" + this.form.id)
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
        fetch("/api/admin/vouchers/" + id, {
          method: "delete"
        })
          .then(res => res.json())
          .then(data => {
            this.getResults(this.pg);
          })
          .catch(err => console.log(err));
      }
    },
    editItem(voucher) {
      this.edit = true;
      this.form.title = voucher.title;
      this.form.code = voucher.code;
      this.form.type = voucher.type;
      this.form.blurb = voucher.blurb;
      this.form.terms = voucher.terms;
      this.form.url = voucher.url;
      this.form.valid_from = voucher.valid_from;
      this.form.valid_to = voucher.valid_to;
      this.form.retailer_mid = voucher.retailer_mid;
      this.form.id = voucher.id;
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
        .post("/api/admin/vouchers-csv/" + prefix, fd)
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
