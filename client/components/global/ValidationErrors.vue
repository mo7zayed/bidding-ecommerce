<template>
  <article class="message is-danger" v-if="formatted_errors.length && view">
    <div class="message-header">
      <p>Errors !!</p>
      <button class="delete" @click="view = false" aria-label="delete"></button>
    </div>
    <div class="message-body">
      <ul>
        <li v-for="(e, index) in formatted_errors" :key="'v_error_' + index">
          {{ e }}
        </li>
      </ul>
    </div>
  </article>
</template>


<script>
  export default {
    props: {
      errors: {
        required: true,
        type: Object,
        default: []
      }
    },
    watch: {
      errors() {
        this.formatted_errors = [];
        this.view = true;

        for (const error in this.errors) {
          if (this.errors.hasOwnProperty(error)) {
            this.formatted_errors.push(this.errors[error].join(", "))
          }
        }
      }
    },
    data() {
      return {
        formatted_errors: [],
        view: true,
      }
    }
  }
</script>
