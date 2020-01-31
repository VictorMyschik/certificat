require('./bootstrap');

window.Vue = require('vue');
//Vue.use(require('vue-resource'));

//Vue.component('pagination', require('laravel-vue-pagination'));
Vue.component('data-component', require('./components/DataComponent.vue'));

const app = new Vue({
    el: '#app'
});
