<template>
  <div class="jumbotron text-center bg-dark rounded-0 mailist">
    <div class="text-white">
      <p class="h3">Subscribe to our mailing list for daily deal offers.</p>
    </div>
    <div class="text-light col-md-3 mx-auto">
      <div v-if="flashMessage === null" class="input-group mb-3">
        <input
          name="email"
          id="email"
          type="text"
          class="form-control"
          placeholder="email@example.com"
          aria-label="Email subscription"
          aria-describedby="basic"
        />
        <div class="input-group-append">
          <button @click="subscribe" class="input-group-text" id="basic">Subscribe</button>
        </div>
      </div>
      <div v-else-if="flashMessage === 'success'" class="input-group mb-3">
        <div class="display-4">Thank you for signing up</div>
      </div>
      <div v-else-if="flashMessage === 'warning'" class="input-group mb-3">
        <p class="h3 text-white">
          Oops :/ This did not work.
          <button
            @click="flashMessage=null"
            class="btn btn-success"
          >Try Again</button>
        </p>
      </div>
    </div>
  </div>
</template>
<script>
import axios from "axios";
export default {
  name: "Subscribe",
  data() {
    return {
      email: null,
      flashMessage: null
    };
  },
  methods: {
    subscribe() {
      const fd = new FormData();
      this.email = document.getElementById("email").value;
      if (this.validateEmail(this.email)) {
        fd.set("email", this.email);
        axios
          .post("/api/subscribe", fd)
          .then(res => {
            this.flashMessage = "success";
            console.log(res);
          })
          .catch(err => {
            this.flashMessage = "warning";
            console.log(err);
          });
      } else {
        this.flashMessage = "warning";
      }
    },
    validateEmail(email) {
      var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
      return re.test(String(email).toLowerCase());
    }
  }
};
</script>
<style scoped>
.overlay::after {
  content: "";
  display: block;
  position: fixed;
  padding: 100px 0;
  width: 100%;
  height: 100%;
  top: 0;
  left: 0;
  background-color: rgba(black, 0.5);
}
</style>
