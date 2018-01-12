
require('./bootstrap');
import VueResource from 'vue-resource';
import Vue           from 'vue';
import Notifications from 'vue-notification';
import VuePaginate from 'vue-paginate';

Vue.use(VuePaginate);
Vue.use(VueResource);
Vue.use(Notifications);
Vue.component('paginate', require('vuejs-paginate'));
Vue.component('favorite', require('./components/Favorite.vue'));
Vue.component('episodes', require('./components/Episode.vue'));
Vue.component('watched', require('./components/Watched.vue'));
Vue.component('follow', require('./components/Follow.vue'));
Vue.component('followers', require('./components/Followers.vue'));
Vue.component('following', require('./components/Following.vue'));
Vue.component('comment', require('./components/Comments.vue'));

const app = new Vue({
    el: '#app'
});
