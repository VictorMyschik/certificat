require('./bootstrap');

window.Vue = require('vue');
//Vue.use(require('vue-resource'));

Vue.component('mr-table', require('./components/MrTable.vue').default);
Vue.component('pagination', require('laravel-vue-pagination'));

const app = new Vue({
  el: '#app'
});