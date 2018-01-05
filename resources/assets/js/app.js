
require('./bootstrap');

Vue.component('favorite', require('./components/Favorite.vue'));
Vue.component('episodes', require('./components/Episode.vue'));
Vue.component('watched', require('./components/Watched.vue'));

const app = new Vue({
    el: '#app'
});
