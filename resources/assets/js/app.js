import Vue from 'vue'
import BootstrapVue from 'bootstrap-vue'
import bTabs from 'bootstrap-vue/es/components/tabs/tabs';

require('./bootstrap');

Vue.use(BootstrapVue);
Vue.component('favorite', require('./components/Favorite.vue'));
Vue.component('episodes', require('./components/Episode.vue'));
Vue.component('b-tabs', bTabs);

const app = new Vue({
    el: '#app'
});
