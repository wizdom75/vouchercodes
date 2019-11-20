<template>
  <div>
    <div class="jumbotron mt-1 rounded-0 mb-3 contact">
      <h1 class="display-4 text-center text-white">{{page.title}}</h1>
    </div>
    <div
      v-if="flashMessage=null"
      class="alert alert-success"
      role="alert"
    >Your message has been sent.</div>

    <div class="bg-primary text-light col-md-9 mx-auto p-3 mb-3">
      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" class="form-control" id="name" />
          </div>
          <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" class="form-control" id="email" />
          </div>
          <div class="form-group">
            <label for="subject">Subject:</label>
            <select type="subject" class="form-control" id="subject">
              <option value>-Please select-</option>
              <option value="Feedback">Feedback</option>
              <option value="Offer not working">Offer not working</option>
              <option value="Merchant listing">Merchant listing</option>
              <option value="Other">Other</option>
            </select>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label for="message">Message:</label>
            <textarea class="form-control" id="message" rows="6"></textarea>
          </div>
          <button
            id="sendButton"
            type="submit"
            class="btn btn-info mb-2 btn-block"
            @click="sendMessage"
          >Send message</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { mapGetters } from "vuex";
import axios from "axios";
export default {
  metaInfo() {
    return { title: "" + this.page.title };
  },
  data() {
    return {
      title: window.config.appName,
      flashMessage: null,
      page: {
        title: "Contact us"
      },
      name: "",
      email: "",
      subject: "",
      message: ""
    };
  },
  computed: mapGetters({
    authenticated: "auth/check"
  }),
  methods: {
    sendMessage() {
      const fd = new FormData();
      this.name = document.getElementById("name").value;
      this.email = document.getElementById("email").value;
      this.subject = document.getElementById("subject").value;
      this.message = document.getElementById("message").value;
      if (
        this.name.lenth > 3 &&
        this.message.length > 150 &&
        this.subject.length > 1 &&
        this.validateEmail(this.email)
      ) {
        document.getElementById("sendButton").disabled = false;
      }

      fd.set("name", this.name);
      fd.set("email", this.email);
      fd.set("subject", this.subject);
      fd.set("message", this.message);
      axios
        .post("/api/send-message", fd)
        .then(res => {
          this.flashMessage = "success";
          console.log(res);
        })
        .catch(err => {
          this.flashMessage = "warning";
          console.log(err);
        });
    },
    validateEmail(email) {
      var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
      return re.test(String(email).toLowerCase());
    }
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
  padding-top: 35%;
  padding-left: 5%;
  width: 30%;
}

.contact {
  background: url("/images/contact.jpg") no-repeat center center;
  background-size: cover;
}
</style>
