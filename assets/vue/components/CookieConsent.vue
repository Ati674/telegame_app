<template>
  <vue-cookie-accept-decline
      :ref="'VueCookie'"
      :elementId="'VueCookie'"
      :debug="false"
      :position="'bottom-left'"
      :type="'floating'"
      :disableDecline="false"
      :transitionName="'slideFromBottom'"
      :showPostponeButton="false"
      @status="cookieStatus"
      @clicked-accept="cookieClickedAccept"
      @clicked-decline="cookieClickedDecline">

    <!-- Optional -->
    <div slot="postponeContent">
      &times;
    </div>

    <!-- Optional -->
    <div slot="message">
      Ce site utilise des cookies pour améliorer votre expérience de navigation. <a href="#">En savoir plus sur la politique de confidentialité</a>
    </div>

    <!-- Optional -->
    <div slot="declineContent">
      Je décline
    </div>

    <!-- Optional -->
    <div slot="acceptContent">
      J'accepte
    </div>
  </vue-cookie-accept-decline>
</template>

<script>
export default {
  name: "VueCookie",
  data () {
    return {
      status: null
    }
  },
  methods: {
    cookieStatus (status) {
      this.status = status
    },
    cookieClickedAccept () {
      this.status = 'accept'
    },
    cookieClickedDecline () {
      this.status = 'decline'
    },
    cookieRemovedCookie () {
      this.status = null
      this.$refs.VueCookie.init()
    },

    removeCookie () {
      this.$refs.VueCookie.removeCookie()
    }
  },
  computed: {
    statusText () {
      return this.status || 'Aucun cookie'
    }
  }
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
@import "~vue-cookie-accept-decline/dist/vue-cookie-accept-decline.css";
</style>
