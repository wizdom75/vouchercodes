<template>
  <card :title="$t('pages')">
    <table class="table">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">Title</th>
          <th scope="col">Type</th>
          <th scope="col">
            <button
              type="button"
              class="btn btn-success rounded-circle"
              data-toggle="modal"
              @click="clearForm()"
              data-target=".pageModalCenter"
            >
              <fa icon="plus" class="text-white" fixed />
            </button>
          </th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="page in pages.data" :key="page.id">
          <th scope="row">{{page.id}}</th>
          <td>{{page.title}}</td>
          <td>{{page.type}}</td>
          <td>
            <button
              data-toggle="modal"
              data-target=".pageModalCenter"
              data-whatever="Edit"
              @click="editItem(page)"
              class="btn btn-info rounded-circle"
            >
              <fa icon="edit" fixed />
            </button>
            <button @click="deleteItem(page.slug)" class="btn btn-danger rounded-circle ml-5">
              <fa icon="trash" fixed />
            </button>
          </td>
        </tr>
      </tbody>
    </table>
    <div
      class="modal fade pageModalCenter"
      tabindex="-1"
      role="dialog"
      aria-labelledby="pageModalCenterLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="pageModalCenter">Add a new page</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form @submit.prevent="store" @keydown="form.onKeydown($event)">
            <alert-success :form="form" :message="message" />

            <!-- Page title -->
            <div class="form-group row p-3">
              <label class="col-md-3 col-form-label text-md-right">{{ $t('page_title') }}</label>
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
            <!-- Page slug -->
            <div class="form-group row p-3">
              <label class="col-md-3 col-form-label text-md-right">{{ $t('page_slug') }}</label>
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
            <!-- Page type -->
            <div class="form-group row p-3">
              <label class="col-md-3 col-form-label text-md-right">{{ $t('page_type') }}</label>
              <div class="col-md-7">
                <select
                  v-model="form.type"
                  :class="{ 'is-invalid': form.errors.has('type') }"
                  class="form-control"
                  name="type"
                >
                  <option value>-Please select-</option>
                  <option value="about">About</option>
                  <option value="cookies">Cookies</option>
                  <option value="privacy">Privacy</option>
                  <option value="terms">Terms</option>
                  <option value="blog">Blog</option>
                </select>
                <has-error :form="form" field="type" />
              </div>
            </div>
            <!-- Page body -->
            <div class="form-group row p-3">
              <label class="col-md-3 col-form-label text-md-right">{{ $t('page_body') }}</label>
              <div class="col-md-7">
                <textarea
                  v-model="form.body"
                  :class="{ 'is-invalid': form.errors.has('password_confirmation') }"
                  class="form-control"
                  name="body"
                ></textarea>
                <input type="hidden" name="id" v-model="form.id" />
                <has-error :form="form" field="body" />
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
  </card>
</template>

<script>
import Form from "vform";
import axios from "axios";

export default {
  layout: "admin",
  scrollToTop: false,

  metaInfo() {
    return { title: this.$t("admin_pages") };
  },

  data() {
    return {
      pages: "",
      edit: false,
      message: "",
      form: new Form({
        title: "",
        slug: "",
        type: "",
        body: ""
      })
    };
  },
  mounted() {
    this.getResults();
  },

  methods: {
    getResults() {
      axios
        .get("/api/admin/pages/")
        .then(response => {
          this.pages = response.data;
        })
        .catch(error => {
          console.log(this.form);
        });
    },
    async store() {
      if (this.edit === false) {
        await this.form.post("/api/admin/pages");
        this.getResults();
        this.form.reset();
        this.message = "New page created successfully!";
      } else {
        await this.form.patch("/api/admin/pages/" + this.form.slug);
        this.getResults();
        this.form.reset();
        this.message = "Page updated successfully!";
      }
    },
    deleteItem(slug) {
      if (
        confirm(
          "This action cannot be undone, Are you sure you want to delete this item?"
        )
      ) {
        fetch("/api/admin/pages/" + slug, {
          method: "delete"
        })
          .then(res => res.json())
          .then(data => {
            this.getResults();
          })
          .catch(err => console.log(err));
      }
    },
    editItem(page) {
      this.edit = true;
      this.form.title = page.title;
      this.form.slug = page.slug;
      this.form.type = page.type;
      this.form.body = page.body;
      this.form.id = page.id;
    },
    clearForm() {
      this.form.reset();
      this.edit = false;
    }
  }
};
</script>
