<template>
  <card class="text-center mt-5 mb-5 p-12 border-0">
    <h3 class="display-1 text-muted">{{ $t('page_not_found') }}</h3>

    <div class="links">
      <router-link :to="{ name: 'home' }">{{ $t('go_home') }}</router-link>
    </div>
  </card>
</template>

<script>
export default {
  name: "NotFound"
};
</script>
