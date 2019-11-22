<template>
  <div>
    <router-link :to="'/'+shop_slug" class="nav-link">
      <div class="card mt-3 flex-row flex-wrap border-0 dropdown-item p-0" :key="voucher_id">
        <div class="card-header border-0">
          <div class="p-0 m-0 text-center border">
            <div>
              <img class="card-img-left m-0 p-0" :src="shop_logo" :alt="shop_title" width="80px" />
            </div>
            <span
              v-if="voucher_type === 'code' || voucher_type === 'voucher'"
              class="bg-warning text-white d-block"
            >CODE</span>
            <span
              v-if="voucher_type === 'deal' || voucher_type === 'promotion'"
              class="bg-info text-white d-block"
            >DEAL</span>
            <span v-if="voucher_type === 'sale'" class="bg-danger text-white d-block">SALE</span>
          </div>
        </div>
        <div class="card-body">{{voucher_title}}</div>
      </div>
    </router-link>
  </div>
</template>

<script>
export default {
  name: "SearchOfferCard",

  props: {
    voucher_id: { type: Number, default: null },
    voucher_title: { type: String, default: null },
    voucher_type: { type: String, default: null },
    voucher_mid: { type: String, default: null },
    voucher_code: { type: String, default: null },
    shop_logo: { type: String, default: null },
    shop_slug: { type: String, default: null },
    shop_title: { type: String, default: null }
  }
};
</script>
<style scoped>
/** extra offer card styling */
.card-body {
  max-width: 60%;
}
.card-right {
  max-width: 30%;
}
.card {
  max-width: 100%;
}
.card-text {
  word-wrap: break-word;
}
</style>
