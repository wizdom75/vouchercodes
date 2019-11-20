<template>
  <card :title="$t('submit_a_code')">
    <form @submit.prevent="update" @keydown="form.onKeydown($event)">
      <alert-success :form="form" :message="$t('info_updated')" />

      <!-- Retailer Name -->
      <div class="form-group row">
        <label class="col-md-3 col-form-label text-md-right">{{ $t('retailer_name') }}</label>
        <div class="col-md-7">
          <input
            v-model="form.name"
            :class="{ 'is-invalid': form.errors.has('name') }"
            class="form-control"
            type="text"
            name="name"
          />
          <has-error :form="form" field="name" />
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
            v-model="form.valid_to"
            :class="{ 'is-invalid': form.errors.has('valid_to') }"
            class="form-control"
            type="text"
            name="valid_to"
          />
          <has-error :form="form" field="valid_to" />
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
          <v-button :loading="form.busy" type="success">{{ $t('update') }}</v-button>
        </div>
      </div>
    </form>
  </card>
</template>

<script>
import Form from "vform";
import { mapGetters } from "vuex";

export default {
  scrollToTop: false,

  metaInfo() {
    return { title: this.$t("submit_a_code") };
  },

  data: () => ({
    form: new Form({
      name: "",
      email: ""
    })
  }),

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
    async update() {
      const { data } = await this.form.patch("/api/settings/profile");

      this.$store.dispatch("auth/updateUser", { user: data });
    }
  }
};
</script>
