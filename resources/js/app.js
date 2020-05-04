require('./bootstrap');

window.Vue = require('vue');
//Vue.use(require('vue-resource'));

Vue.component('mr-table', require('./components/MrTable.vue').default);
Vue.component('mr-search-certificate', require('./components/MrSearchCertificate.vue').default);
Vue.component('mr-admin-redis-data', require('./components/Admin/MrAdminRedisData.vue').default);
Vue.component('mr-certificate-details', require('./components/MrCertificateDetails.vue').default);
Vue.component('pagination', require('laravel-vue-pagination'));

const app = new Vue({
  el: '#app'
});