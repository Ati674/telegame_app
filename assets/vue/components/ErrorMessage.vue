<template>
    <div class="uk-alert uk-alert-danger" role="alert">
      <slot name="message">
        {{error}}
      </slot>
    </div>
</template>

<script>
    export default {
        name: 'errorMessage',
        props: ['error'],
    }
</script>
