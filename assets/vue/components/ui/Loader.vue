<template>
  <div className="Loader" class="uk-position-center" v-if="loading">
    <div uk-spinner="ratio: 4.5"></div>
  </div>
</template>

<script>
export default {
  name: "Loader",
  data() {
    return {
      loading: true
    }
  },
  created(){
    setTimeout(() => {
      this.loading = false;
    },5000);
  },
}
</script>

<style scoped>

</style>
