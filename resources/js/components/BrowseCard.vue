<template>
  <div>
    <div class="card">
      <div class="card-body">
        <div class="card-title text-muted h4">{{title}}</div>
        <div class="card-text">
          <div v-for="alpha in alphas" class="btn btn-light text-uppercase px-2 m-1" :key="alpha">
            <router-link v-if="alpha === '#'" :to=" '/retailers/num' ">0-9</router-link>
            <router-link v-else :to=" '/retailers/'+alpha ">{{alpha}}</router-link>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  name: "BrowseCard",

  props: {
    title: { type: String, default: "Browse by shop" }
  },
  data() {
    return {
      alphas: [
        "#",
        "a",
        "b",
        "c",
        "d",
        "e",
        "f",
        "g",
        "h",
        "i",
        "j",
        "k",
        "l",
        "m",
        "n",
        "o",
        "p",
        "q",
        "r",
        "s",
        "t",
        "u",
        "v",
        "w",
        "x",
        "y",
        "z"
      ]
    };
  }
};
</script>