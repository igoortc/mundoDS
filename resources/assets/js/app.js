
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
Vue.component('image-upload', require('./components/ImageUpload.vue'));
Vue.component('dash-favorites', require('./components/dashboard/Favorites.vue'));
Vue.component('search', require('./components/dashboard/Search.vue'));
Vue.component('show-create', require('./components/admin/show/Create.vue'));
Vue.component('show-edit', require('./components/admin/show/Edit.vue'));
Vue.component('show-delete', require('./components/admin/show/Delete.vue'));
Vue.component('episode-create', require('./components/admin/episode/Create.vue'));
Vue.component('episode-edit', require('./components/admin/episode/Edit.vue'));
Vue.component('episode-delete', require('./components/admin/episode/Delete.vue'));
Vue.component('user-delete', require('./components/admin/user/Delete.vue'));

const app = new Vue({
    el: '#app'
});
