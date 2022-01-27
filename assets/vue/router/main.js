import Vue from 'vue';
import vueRouter from 'vue-router';
import Home from '../views/main/Home';
import Router from "vue-router";

Vue.use(vueRouter);

export default new Router({
    mode: 'history',
    routes: [
        { path: '/',name: 'Home',component: Home},
    ],
});

