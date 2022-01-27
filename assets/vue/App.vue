<template>
  <div id="app">
    <VueCookie></VueCookie>
    <back-to-top text="Top" visibleoffset="500"></back-to-top>
    <router-view></router-view>
  </div>
</template>
<script>
import VueCookie from './components/CookieConsent';
import BackToTop from 'vue-backtotop';

export default {
  name: 'App',
  components: {
    VueCookie,
    BackToTop
  }
}
</script>

<style>
.vue-back-to-top{
  bottom: 95px !important;
  right: 10px !important;
}
.vue-back-to-top .default{
  background-color: #1A1F34 !important;
  width: 100px !important;
  border: 1px solid #ffffff;
}
#app {
    font-family: Avenir, Helvetica, Arial, sans-serif;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
    text-align: center;
    color: #2c3e50;
}
</style>
