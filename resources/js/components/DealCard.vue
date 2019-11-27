<template>
  <div>
    <div class="card mt-3 flex-row flex-wrap" :key="voucher_id">
      <div class="card-header border-0">
        <div class="p-0 m-0 text-center border">
          <div>
            <img class="card-img-left m-0 p-0" :src="shop_logo" :alt="shop_title" width="90px" />
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
      <div class="card-body">
        <h2 class="h6 page-heading">
          <span class="text-black">{{voucher_title}}</span>
        </h2>
        <!-- <span v-html="voucher_blurb" class="small text-muted"></span> -->
      </div>
      <div class="card-right">
        <a :href="'/out/redirect/'+voucher_id"></a>
        <button
          v-if="voucher_type === 'code' || voucher_type === 'voucher'"
          class="btn btn-primary mt-3 ml-4 text-white rounded-0"
          data-toggle="modal"
          :data-target="'#revealCode_'+voucher_id"
          v-on:click="openNewBackgroundTab('/out/redirect/'+voucher_id)"
        >Get this code ></button>
        <a :href="'/out/redirect/'+voucher_id"></a>
        <button
          v-if="voucher_type === 'sale' || voucher_type === 'sale'"
          class="btn btn-primary mt-3 ml-4 text-white rounded-0"
          v-on:click="openNewBackgroundTab('/out/redirect/'+voucher_id)"
        >Get this sale ></button>

        <a
          :href="'/out/redirect/'+voucher_id"
          v-on:click="'window.open('+window.location+'); return true;'"
        >
          <button
            v-if="voucher_type === 'deal' || voucher_type === 'promotion'"
            class="btn btn-primary mt-3 ml-4 text-white rounded-0"
          >Get this deal ></button>
        </a>
      </div>
      <!-- Modal to reveal code -->
      <div
        class="modal fade"
        :id="'revealCode_'+voucher_id"
        tabindex="-1"
        role="dialog"
        aria-labelledby="revealCodeTitle"
        aria-hidden="true"
      >
        <div class="modal-dialog modal-dialog-centered rounded-0" role="document">
          <div class="modal-content text-center">
            <div class="text-right">
              <button type="button" class="mr-1 close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="text-center">
              <h5 class="modal-title" id="revealCodeTitle">{{voucher_title}}</h5>
            </div>
            <div class="modal-body mx-auto">
              <input class="border-0" type="text" :value="voucher_code" :id="'code_'+voucher_id" />

              <button
                v-on:click="copyCode('code_'+voucher_id)"
                type="button"
                class="btn btn-primary text-white ml-3"
              >
                <fa icon="cut"></fa>&nbsp;Copy code
              </button>
            </div>
            <div class="text-center">{{feedback}}</div>
          </div>
        </div>
      </div>

      <!-- EoF Modal to reveal code -->
    </div>
  </div>
</template>

<script>
export default {
  name: "DealCard",

  props: {
    voucher_id: { type: Number, default: null },
    voucher_title: { type: String, default: null },
    voucher_blurb: { type: String, default: null },
    voucher_type: { type: String, default: null },
    voucher_terms: { type: String, default: null },
    voucher_url: { type: String, default: null },
    voucher_mid: { type: String, default: null },
    voucher_code: { type: String, default: null },
    shop_logo: { type: String, default: null },
    shop_title: { type: String, default: null },
    feedback: { type: String, default: null }
  },
  methods: {
    copyCode(myInput) {
      this.feedback = "";
      var copyText = document.getElementById(myInput);
      copyText.select();
      copyText.setSelectionRange(0, 99999);
      document.execCommand("copy");
      this.feedback = "Copied to clipboard!";
    },
    openNewBackgroundTab(outlink) {
      var a = document.createElement("a");
      a.href = outlink;
      var evt = document.createEvent("MouseEvents");
      evt.initMouseEvent(
        "click",
        true,
        true,
        window,
        0,
        0,
        0,
        0,
        0,
        true,
        false,
        false,
        false,
        0,
        null
      );
      a.dispatchEvent(evt);
    }
  }
};
</script>
<style scoped>
input[type="text"],
textarea {
  outline: none;
  box-shadow: none !important;
  border: 1px dashed rgb(236, 226, 226) !important;
  text-align: center;
  padding: 10px 15px;
}

/** extra offer card styling */
.card-body {
  max-width: 60%;
}
.card-right {
  max-width: 30%;
}
</style>
