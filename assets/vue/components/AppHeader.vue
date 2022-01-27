<template>
  <vk-card class="col-lg-12 mb-2" id="header-card">
    <div slot="media-top">
        <img src="../../images/image0.png" alt="binance_coin"/>
    </div>
    <h1 class="uk-text-large uk-text-bold">
        Le nouveau jeu concept telegram en vogue !
    </h1>
    <p class="uk-position-bottom-center pb-4">Scroll down<br>
      <vk-icon icon="arrow-down"></vk-icon>
    </p>
  </vk-card>
</template>

<script>
export default {
  name: "AppHeader"
}
</script>

<style scoped>
#header-card {
    position: relative;
    overflow: hidden;
    height: 100vh;
    background: rgb(17,172,164);
    background: linear-gradient(90deg, rgba(17,172,164,1) 2%, rgba(23,30,164,1) 98%);
}
#header-card h1 {
    display: block;
    padding-top: 5vh;
    padding-right: 992px;
    color: #ffff!important;
    font-size: 30px;
    position: relative;
    z-index: 2;
}
#header-card img {
    position: absolute;
    z-index: 0;
    top: 0;
    left: 25%;
}

@media screen and (max-width: 640px) {
    #header-card {
        position: relative;
        overflow: hidden;
        height: auto;
    }
    #header-card h1 {
        padding-top: 0;
    }
}

</style>
