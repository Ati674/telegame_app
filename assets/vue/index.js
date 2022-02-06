import Vue from 'vue';
import App from './App';
import main from './router/main';
import "vue-cookie-accept-decline/dist/vue-cookie-accept-decline.css";
import VueCookieAcceptDecline from 'vue-cookie-accept-decline';
import { BootstrapVue, IconsPlugin } from 'bootstrap-vue'

// Import Bootstrap an BootstrapVue CSS files (order is important)
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'
import Vuikit from 'vuikit'
import VuikitIcons from '@vuikit/icons'
import Notifications from 'vue-notification'

// import '../scss/vue.scss'

// Make BootstrapVue available throughout your project
Vue.use(BootstrapVue)
// Optionally install the BootstrapVue icon components plugin
Vue.use(IconsPlugin)

/*
or for SSR:
import Notifications from 'vue-notification/dist/ssr.js'
*/

Vue.use(Notifications)
Vue.use(Vuikit)
Vue.use(VuikitIcons)
Vue.component("vue-cookie-accept-decline", VueCookieAcceptDecline);
Vue.config.productionTip = false;
require('jquery-validation')

const host = window.location.host;
const parts = host.split('.');
// const domainLength = 3; // route1.example.com => domain length = 3

const router = () => {
    let routes;
    if (parts[0] === 'www') {
        // if (parts.length === (domainLength - 1) || parts[0] === 'www') {
        routes = main;
    } else if (parts[0] === 'maps') {
        routes = maps;
    } else {
        // If you want to do something else just comment the line below
        routes = main;
    }
    return routes;
};

/* eslint-disable no-new */
new Vue({
    el: '#app',
    router: router(),
    template: '<App/>',
    components: { App }
});
