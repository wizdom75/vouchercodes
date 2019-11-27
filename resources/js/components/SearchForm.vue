<template>
  <div>
    <input  @focus="searching = true"
            @blur="searching = false"
            v-on:input="searchTimeOut()"
            type="search"
            class="form-control-lg col-md-4 border-0 text-center" 
            name="searchTxt" 
            id="searchTxt" 
            placeholder="Search voucher codes" />
  </div>
</template>
<script>
import { mapGetters } from "vuex";
import axios from "axios";
export default {
  name: "SearchForm",
  data() {
    return {
      q: null,
      results: null,
      searching:null
    };
  },
  methods: {}
};
</script>

<style scoped>
</style>