<template>
  <div class="main-layout">
    <navbar />

    <div class="container-fluid px-0">
      <child />
    </div>
    <footerBar />
  </div>
</template>

<script>
import Navbar from "~/components/Navbar";
import FooterBar from "~/components/Footer";

export default {
  name: "MainLayout",

  components: {
    Navbar,
    FooterBar
  }
};
</script>
