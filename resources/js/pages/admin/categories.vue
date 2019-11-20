<template>
  <card :title="$t('categories')">
    <table class="table">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">Parent</th>
          <th scope="col">Title / Slug</th>
          <th scope="col">Image</th>
          <th scope="col">Icon</th>
          <th scope="col">
            <button
              type="button"
              class="btn btn-success rounded-circle"
              data-toggle="modal"
              @click="clearForm()"
              data-target=".categoryModalCenter"
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
        <tr v-for="category in categories.data" :key="category.id">
          <th scope="row">{{category.id}}</th>
          <td>{{category.parent_id}}</td>
          <td>
            {{category.title}}
            <br />
            {{category.slug}}
          </td>
          <td>{{category.image}}</td>
          <td>{{category.icon}}</td>
          <td>
            <button
              data-toggle="modal"
              data-target=".categoryModalCenter"
              data-whatever="Edit"
              @click="editItem(category)"
              class="btn btn-info rounded-circle"
            >
              <fa icon="edit" fixed />
            </button>
            <button @click="deleteItem(category.id)" class="btn btn-danger rounded-circle ml-5">
              <fa icon="trash" fixed />
            </button>
          </td>
        </tr>
      </tbody>
    </table>
    <pagination
      :limit="3"
      :show-disabled="true"
      :data="categories"
      :align="'center'"
      @pagination-change-page="getResults"
    ></pagination>
    <div
      class="modal fade categoryModalCenter"
      tabindex="-1"
      role="dialog"
      aria-labelledby="categoryModalCenterLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="categoryModalCenter">Add a new category</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form @submit.prevent="store" @keydown="form.onKeydown($event)">
            <alert-success :form="form" :message="$t('new_category_created')" />
            <!-- category parent -->
            <div class="form-group row p-3">
              <label class="col-md-3 col-form-label text-md-right">{{ $t('category_parent') }}</label>
              <div class="col-md-7">
                <select
                  v-model="form.parent_id"
                  :class="{ 'is-invalid': form.errors.has('parent_id') }"
                  class="form-control"
                  name="parent_id"
                >
                  <option>-Please select-</option>
                  <option v-for="cat in cats" :value="cat.id" :key="cat.id">{{cat.title}}</option>
                </select>
                <has-error :form="form" field="parent_id" />
              </div>
            </div>

            <!-- category title -->
            <div class="form-group row p-3">
              <label class="col-md-3 col-form-label text-md-right">{{ $t('category_title') }}</label>
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
            <!-- category slug -->
            <div class="form-group row p-3">
              <label class="col-md-3 col-form-label text-md-right">{{ $t('category_slug') }}</label>
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
            <!-- category image -->
            <div class="form-group row p-3">
              <label class="col-md-3 col-form-label text-md-right">{{ $t('category_image') }}</label>
              <div class="col-md-7">
                <input
                  :class="{ 'is-invalid': form.errors.has('image') }"
                  class="form-control"
                  type="file"
                  name="image"
                />
                <has-error :form="form" field="image" />
              </div>
            </div>
            <!-- category icon -->
            <div class="form-group row p-3">
              <label class="col-md-3 col-form-label text-md-right">{{ $t('category_icon') }}</label>
              <div class="col-md-7">
                <input
                  v-model="form.icon"
                  :class="{ 'is-invalid': form.errors.has('icon') }"
                  class="form-control"
                  type="text"
                  name="icon"
                />
                <has-error :form="form" field="icon" />
              </div>
            </div>
            <!-- category description -->
            <div class="form-group row p-3">
              <label class="col-md-3 col-form-label text-md-right">{{ $t('category_description') }}</label>
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
    <!-- Beginning of modal for bulk importation of categories -->
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
            <h5 class="modal-title" id="bulkImportCSV">Import Categories from CSV</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form
            @submit.prevent="csvUpload"
            @keydown="form.onKeydown($event)"
            enctype="multipart/form-data"
          >
            <alert-success :form="form" :message="$t('new_categories_imported')" />
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
                <!-- <v-button :loading="form.busy" type="success">{{ $t('upload') }}</v-button> -->
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
    <!-- End of modal for bulk importation of categories -->
  </card>
</template>

<script>
import Form from "vform";
import axios from "axios";

export default {
  layout: "admin",
  scrollToTop: false,

  metaInfo() {
    return { title: this.$t("Admin Categories") };
  },

  data() {
    return {
      categories: "",
      cats: "",
      edit: false,
      pg: "",
      form: new Form({
        parent_id: "",
        title: "",
        slug: "",
        description: "",
        image: "",
        icon: ""
      })
    };
  },
  mounted() {
    this.getResults(this.pg);
    axios
      .get("/api/admin/categories/index")
      .then(response => {
        this.cats = response.data;
      })
      .catch(error => {
        console.log(this.form);
      });
  },

  methods: {
    getResults(page) {
      if (typeof page === "undefined") {
        page = 1;
      }
      this.pg = page;
      axios
        .get("/api/admin/categories?page=" + page)
        .then(response => {
          this.categories = response.data;
        })
        .catch(error => {
          console.log(this.form);
        });
    },
    async store() {
      if (this.edit === false) {
        await this.form.post("/api/admin/categories");
        this.getResults(this.pg);
        this.form.reset();
      } else {
        await this.form.patch("/api/admin/categories/" + this.form.id);
        this.getResults(this.pg);
        this.form.reset();
      }
    },
    deleteItem(slug) {
      if (
        confirm(
          "This action cannot be undone, Are you sure you want to delete this item?"
        )
      ) {
        fetch("/api/admin/categories/" + slug, {
          method: "delete"
        })
          .then(data => {
            this.getResults(this.pg);
          })
          .catch(err => console.log(err));
      }
    },
    editItem(category) {
      this.edit = true;
      this.form.title = category.title;
      this.form.slug = category.slug;
      this.form.description = category.description;
      this.form.image = category.image;
      this.form.icon = category.icon;
      this.form.id = category.id;
    },
    clearForm() {
      this.form.reset();
      this.edit === false;
    },
    selectCSV() {
      this.csv = "";
      const e = window.event;
      const file = e.target.files[0];
      this.csv_file = file;
      console.log(this.csv_file);
      this.csvUpload();
    },
    csvUpload() {
      const fd = new FormData();
      fd.append("csv_file", this.csv_file, this.csv_file.name);
      axios
        .post("/api/admin/categories-csv", fd)
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
