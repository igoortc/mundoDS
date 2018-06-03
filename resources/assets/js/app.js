
require('./bootstrap')
import VueResource from 'vue-resource'
import Vue           from 'vue'
import Notifications from 'vue-notification'
import VuePaginate from 'vue-paginate'
import DatePicker from 'vue2-datepicker'
import BootstrapVue from 'bootstrap-vue'
import bTabs from 'bootstrap-vue/es/components/tabs/tabs'
import VueChatScroll from 'vue-chat-scroll'

Vue.use(VuePaginate)
Vue.use(VueResource)
Vue.use(Notifications)
Vue.use(DatePicker)
Vue.use(BootstrapVue)
Vue.use(VueChatScroll)
Vue.component('paginate', require('vuejs-paginate'))
Vue.component('favorite', require('./components/Favorite.vue'))
Vue.component('episodes', require('./components/Episode.vue'))
Vue.component('watched', require('./components/Watched.vue'))
Vue.component('follow', require('./components/Follow.vue'))
Vue.component('followers', require('./components/Followers.vue'))
Vue.component('following', require('./components/Following.vue'))
Vue.component('discussion', require('./components/Discussion.vue'))
Vue.component('image-upload', require('./components/ImageUpload.vue'))
Vue.component('dash-favorites', require('./components/dashboard/Favorites.vue'))
Vue.component('search', require('./components/dashboard/Search.vue'))
Vue.component('show-create', require('./components/admin/show/Create.vue'))
Vue.component('show-manage', require('./components/admin/show/Manage.vue'))
Vue.component('episode-create', require('./components/admin/episode/Create.vue'))
Vue.component('episode-manage', require('./components/admin/episode/Manage.vue'))
Vue.component('user-manage', require('./components/admin/user/Manage.vue'))
Vue.component('content-manage', require('./components/admin/content/Manage.vue'))
Vue.component('edit-profile', require('./components/user/Edit.vue'))
Vue.component('user-favorites', require('./components/user/Favorites.vue'))
Vue.component('datepicker', require('./components/Datepicker.vue'))
Vue.component('chat-list', require('./components/chat/List.vue'))
Vue.component('chat', require('./components/chat/Chat.vue'))
Vue.component('b-tabs', bTabs)

const app = new Vue({
    el: '#app'
});
