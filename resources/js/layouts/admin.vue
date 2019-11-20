<template>
  <div class="main-layout">
    <admin-navbar />

    <div class="container-fluid">
      <child />
    </div>
    <admin-footer />
  </div>
</template>

<script>
import AdminNavbar from "~/components/AdminNavbar";
import AdminFooter from "~/components/AdminFooter";

export default {
  name: "AdminLayout",

  components: {
    AdminNavbar,
    AdminFooter
  }
};
</script>
