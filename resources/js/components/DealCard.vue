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
            v-if="voucher_type === 'deal' || voucher_type === 'discount'"
            class="bg-info text-white d-block"
          >DEAL</span>
          <span
            v-if="voucher_type === 'sale' || voucher_type === 'promotion'"
            class="bg-danger text-white d-block"
          >SALE</span>
        </div>
      </div>
      <div class="card-body">
        <h2 class="h6 page-heading">
          <span class="text-black">{{voucher_title}}</span>
        </h2>
        <!-- <span v-html="voucher_blurb" class="small text-muted"></span> -->
      </div>
      <div class="card-right p-3">
        <div class="text-center" v-if="voucher_id == paramCode">
          <input
            class="border-0 btn mt-3 ml-4 text-black rounded-0 btn-lg btn-block pr-1"
            type="text"
            :value="voucher_code"
          />
          <span class="tiny">Enter this code at the checkout</span>
        </div>
        <div v-else>
          <button
            v-if="voucher_type === 'code' || voucher_type === 'voucher'"
            class="btn btn-primary mt-3 ml-4 text-white rounded-0 btn-lg btn-block"
            data-toggle="modal"
            :data-target="'#revealCode_'+voucher_id"
            v-on:click="openNewBackgroundTab('/out/redirect/'+voucher_mid+'/'+voucher_id, voucher_id)"
          >
            Get this code
            <fa icon="angle-right" class="text-white" fixed-width />
          </button>
        </div>

        <button
          v-if="voucher_type === 'promotion' || voucher_type === 'sale'"
          class="btn btn-primary mt-3 ml-4 text-white rounded-0 btn-lg btn-block"
          v-on:click="openNewBackgroundTab('/out/redirect/'+voucher_mid+'/'+voucher_id)"
        >
          Get this sale
          <fa icon="angle-right" class="text-white" fixed-width />
        </button>
        <a
          :href="'/out/redirect/'+voucher_mid+'/'+voucher_id"
          v-on:click="'window.open('+window.location+'); return true;'"
        >
          <button
            v-if="voucher_type === 'deal' || voucher_type === 'discount'"
            class="btn btn-primary mt-3 ml-4 text-white rounded-0 btn-lg btn-block"
          >
            Get this deal
            <fa icon="angle-right" class="text-white" fixed-width />
          </button>
        </a>
      </div>

      <!-- Modal to reveal code -->
      <div
        v-if="voucher_id == paramCode"
        class="modal fade show bg-dark"
        style="padding-right: 16px; display: block;"
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
                <span v-on:click="closeModal('revealCode_'+voucher_id)" aria-hidden="true">&times;</span>
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
    feedback: { type: String, default: null },
    paramCode: { type: Number, default: null }
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
    openNewBackgroundTab(outlink, rc = null) {
      window.open(outlink, "_self");
      let url = window.location.href;
      if (rc) {
        url = url.split("?")[0];
        url += "?rc=" + rc;
        window.open(url);
      } else {
        url = url.split("?")[0];
        window.open(url);
      }
    },
    closeModal(modalId) {
      document.getElementById(modalId).removeAttribute("class");
      document.getElementById(modalId).style.display = "none";
    }
  },
  mounted: () => {
    let url = window.location.href;

    let queryString = window.location.search;
    let urlParams = new URLSearchParams(queryString);
    let code = urlParams.get("rc");
  }
};
</script>
<style scoped>
input[type="text"],
textarea {
  outline: none;
  box-shadow: none !important;
  border: 1px dashed rgb(58, 56, 56) !important;
  text-align: center;
  padding: 10px 15px;
}
@media screen and (max-width: 768px) {
  /** extra offer card styling */
  .card-body {
    max-width: 70%;
  }
  .card-right {
    max-width: 100%;
  }
}
@media screen and (min-width: 769px) {
  /** extra offer card styling */
  .card-body {
    max-width: 50%;
  }
  .card-right {
    max-width: 30%;
  }
}
.tiny {
  font-size: 0.6rem;
  text-align: justify;
}
</style>
