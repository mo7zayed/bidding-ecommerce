<template>
  <article class="message is-success" v-if="show">
    <div class="message-header">
      <p>Success</p>
      <button class="delete" @click="$emit('hide')" aria-label="delete"></button>
    </div>
    <div class="message-body">
      {{ msg }}
    </div>
  </article>
</template>


<script>
  export default {
    name: 'success-msg',
    props: {
      msg: {
        type: String,
        default: ''
      },
      show: {
        type: Boolean,
        default: false
      }
    }
  }
</script>
