<template>
  <div :class="styles" :key="voucher_title">
    <a :href="shop_link" class="nav-link p-0 m-1 h-100">
      <div class="card d-flex align-items-stretch">
        <img v-if="shop_banner" class="card-img-top" :src="shop_banner" :alt="voucher_title" />
        <img
          v-else
          class="card-img-top"
          :src="'https://via.placeholder.com/740x332/2CB/fff.png?text='+shop_name"
          :alt="voucher_title"
        />
        <div class="nested-logo">
          <img class="w-100 logo-image" :src="shop_logo" :alt="shop_name" />
        </div>
        <div class="card-body">
          <h5 class="text-muted text-uppercase small">{{ shop_name }}</h5>
          <p class="card-text text-black text-justify">{{ voucher_title | truncate(30) }}</p>
        </div>
      </div>
    </a>
  </div>
</template>

<script>
export default {
  name: "FeaturedCard",

  props: {
    voucher_title: { type: String, default: null },
    shop_link: { type: String, default: null },
    shop_logo: { type: String, default: null },
    shop_name: { type: String, default: null },
    shop_banner: { type: String, default: null },
    styles: { type: String, default: '"col-md-4 col-sm-6 mb-3 p-0"' }
  }
};
</script>

<style scoped>
.top-right {
  position: absolute;
  right: 10px;
  top: 18px;
}
.title {
  font-size: 85px;
}
.top-left {
  position: absolute;
  right: 10px;
  top: 18px;
}
.nested-logo {
  position: absolute;
  padding-top: 24%;
  padding-left: 5%;
  width: 30%;
}
.card-img-top {
  object-fit: cover;
  min-height: 60%;
  max-height: 60%;
}
.card-body {
  max-height: 40%;
  min-height: 40%;
}
.logo-image {
  border: 1px solid rgb(218, 222, 226);
}
</style>

