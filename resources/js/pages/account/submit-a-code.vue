<template>
  <card :title="$t('submit_a_code')">
    <form @submit.prevent="addCode" @keydown="form.onKeydown($event)">
      <alert-success :form="form" :message="$t('code_added')" />

      <!-- Retailer Name -->
      <div class="form-group row">
        <label class="col-md-3 col-form-label text-md-right">{{ $t('retailer_name') }}</label>
        <div class="col-md-7">
          <input
            v-model="form.retailer_name"
            :class="{ 'is-invalid': form.errors.has('retailer_name') }"
            class="form-control"
            type="text"
            name="retailer_name"
          />
          <has-error :form="form" field="retailer_name" />
        </div>
      </div>
      <!-- Voucher code -->
      <div class="form-group row">
        <label class="col-md-3 col-form-label text-md-right">{{ $t('code') }}</label>
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
      <!-- Discount Description -->
      <div class="form-group row">
        <label class="col-md-3 col-form-label text-md-right">{{ $t('description') }}</label>
        <div class="col-md-7">
          <input
            v-model="form.description"
            :class="{ 'is-invalid': form.errors.has('description') }"
            class="form-control"
            type="text"
            name="description"
          />
          <has-error :form="form" field="description" />
        </div>
      </div>
      <!-- Expiry date -->
      <div class="form-group row">
        <label class="col-md-3 col-form-label text-md-right">{{ $t('expiry_date') }}</label>
        <div class="col-md-7">
          <input
            v-model="form.expiry_date"
            :class="{ 'is-invalid': form.errors.has('expiry_date') }"
            class="form-control"
            type="text"
            name="expiry_date"
          />
          <has-error :form="form" field="expiry_date" />
        </div>
      </div>
      <!-- Source of code -->
      <div class="form-group row">
        <label class="col-md-3 col-form-label text-md-right">{{ $t('source_from') }}</label>
        <div class="col-md-7">
          <input
            v-model="form.source"
            :class="{ 'is-invalid': form.errors.has('source') }"
            class="form-control"
            type="text"
            name="source"
          />
          <has-error :form="form" field="source" />
        </div>
      </div>
      <!-- Any further info -->
      <div class="form-group row">
        <label class="col-md-3 col-form-label text-md-right">{{ $t('further_info') }}</label>
        <div class="col-md-7">
          <textarea
            v-model="form.further_info"
            :class="{ 'is-invalid': form.errors.has('further_info') }"
            class="form-control"
            name="further_info"
          ></textarea>

          <has-error :form="form" field="further_info" />
        </div>
      </div>

      <!-- Submit Button -->
      <div class="form-group row">
        <div class="col-md-9 ml-md-auto">
          <v-button :loading="form.busy" type="success">{{ $t('submit') }}</v-button>
        </div>
      </div>
    </form>
  </card>
</template>

<script>
import Form from "vform";
import { mapGetters } from "vuex";
import axios from "axios";

export default {
  scrollToTop: false,

  metaInfo() {
    return { title: this.$t("submit_a_code") };
  },

  data() {
    return {
      form: new Form({
        retailer_name: "",
        code: "",
        description: "",
        expiry_date: "",
        source_info: "",
        further_info: ""
      })
    };
  },

  computed: mapGetters({
    user: "auth/user"
  }),

  created() {
    // Fill the form with user data.
    this.form.keys().forEach(key => {
      this.form[key] = this.user[key];
    });
  },

  methods: {
    async addCode() {
      await this.form
        .submit("post", "/api/settings/suggest-a-code")
        .then(res => {
          console.log(res);
        })
        .catch(err => console.log(err));
    }
  }
};
</script>
