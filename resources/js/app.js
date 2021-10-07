require('./bootstrap');

import Vue from 'vue'
import router from "./route"
import App from './components/Main'
import Vuelidate from 'vuelidate'

Vue.use(Vuelidate);

//Vue.component('main-v', require('./components/Main.vue').default);

const vm = new Vue({
  el: '#app',
  components: {App},
  router
});
