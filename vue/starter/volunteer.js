import Vue from 'vue';
import App from './vue/AppVolunteer.vue';
import store from '@store/volunteerStore';
import VueRouter from 'vue-router';
import routes from '@route/routesVolunteer';
import VueCarousel from 'vue-carousel';
import VModal from 'vue-js-modal'

Vue.use(VModal);
/**
 * @Component load
 */
const AdminInput = () => import('@cus-com/Admin/AdminInput.vue').then(a => a.default);
Vue.component('AdminInput', AdminInput);

import GeneralInput from '@cus-com/GeneralInput.vue';

Vue.component('GeneralInput', GeneralInput);
/**
 * @Component load
 */

Vue.use(VueCarousel);
Vue.use(VueRouter);
export const router = new VueRouter({
    mode: 'history',
    routes
});
/**
 * @Route guard
 */
Vue.prototype.initRouter(router, store).StartRouteGuard();
/**
 *
 * @Route guard
 */
Vue.prototype.$context_name = "app_volunteer";
Vue.prototype.Route = Vue.prototype.initRouter(router, store).Route;
Vue.prototype.$utils.onWindowNewTap((info) => {
    store.commit('setWindowState', {WindowState: info});
});

export const app = new Vue({
    el: '#app',
    router,
    store,
    render: h => h(App),
});
