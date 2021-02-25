require('./bootstrap');

import Vue from 'vue'
import router from "./route"
import App from './components/Main'
import Vuelidate from 'vuelidate'
import Paginate from 'vuejs-paginate'

Vue.use(Vuelidate);
Vue.component('paginate', Paginate)

//Vue.component('main-v', require('./components/Main.vue').default);

const vm = new Vue({
  el: '#app',
  components: {App},
  router
});
