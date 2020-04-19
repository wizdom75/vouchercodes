import Vue from 'vue'
import store from '~/store'
import router from '~/router'
import i18n from '~/plugins/i18n'
import App from '~/components/App'

import '~/plugins'
import '~/components'
// Vue.prototype.$axios = axios
Vue.component('pagination', require('laravel-vue-pagination'))
Vue.config.productionTip = false
// Filter for truncating strings
Vue.filter('truncate', function (value, limit) {
  if (value.length > limit) {
    value = value.substring(0, (limit - 3)) + '...'
  }
  return value
})

/* eslint-disable no-new */
new Vue({
  i18n,
  store,
  router,
  ...App
})
