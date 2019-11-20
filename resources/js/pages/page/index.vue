<template>
  <div class="row mt-1">
    <div class="col-12">
      <transition name="fade" mode="out-in">
        <router-view />
      </transition>
    </div>
  </div>
</template>

<script>
export default {
  // middleware: "auth"
};
</script>

<style>
.card-body {
  padding: 0;
}
</style>
