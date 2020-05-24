/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 */

Vue.component('mr-table', require('./components/MrTable.vue').default);
Vue.component('mr-search-certificate-page', require('./components/MrSearchCertificatePage.vue').default);
Vue.component('mr-admin-redis-data', require('./components/Admin/MrAdminRedisData.vue').default);
Vue.component('mr-certificate-details', require('./components/MrCertificateDetails.vue').default);
Vue.component('mr-excel-block', require('./components/MrExcelBlock.vue').default);
Vue.component('mr-my-certificate', require('./components/MrMyCertificate.vue').default);
Vue.component('mr-certificate-watch', require('./components/MrCertificateWatch.vue').default);
Vue.component('pagination', require('laravel-vue-pagination'));
// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
});