
require('./bootstrap');
import Vue           from 'vue';
import Notifications from 'vue-notification';
import VueStar from 'vue-star'

Vue.use(Notifications);
Vue.component('VueStar', VueStar)
Vue.component('favorite', require('./components/Favorite.vue'));
Vue.component('episodes', require('./components/Episode.vue'));
Vue.component('watched', require('./components/Watched.vue'));
Vue.component('follow', require('./components/Follow.vue'));
Vue.component('followers', require('./components/Followers.vue'));
Vue.component('following', require('./components/Following.vue'));

const app = new Vue({
    el: '#app'
});
