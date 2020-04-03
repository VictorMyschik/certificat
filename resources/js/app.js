require('./bootstrap');

window.Vue = require('vue');
//Vue.use(require('vue-resource'));

Vue.component('data-component', require('./components/DataComponent.vue'));
Vue.component('mr_admin_certificates_list', require('./components/MrAdminCertificatesList.vue').default);
Vue.component('pagination', require('laravel-vue-pagination'));

const app = new Vue({
  el: '#app'
});