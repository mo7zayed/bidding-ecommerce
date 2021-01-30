<template>
  <div class="section">
    <div class="container is-fluid">
      <div class="columns is-centered">
        <div class="column is-6">
          <h1 class="title is-4">Login</h1>

          <ValidationErrors :errors="errors" />

          <form @submit.prevent="submit()">
            <div class="field">
              <label class="label">Email (mohamed.zayed@app.com)</label>
              <div class="control">
                <input class="input" v-model="form.email" type="email" placeholder="e.g. mohamed.zayed@app.com">
              </div>
            </div>

            <div class="field">
              <label class="label">Password (123456)</label>
              <div class="control">
                <input class="input" v-model="form.password" type="password">
              </div>
            </div>

            <div class="field">
              <p class="control">
                <button class="button is-info is-medium">
                  Sign in
                </button>
              </p>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  import ValidationErrors from '@/components/global/ValidationErrors'

  export default {
    data() {
      return {
        form: {
          email: '',
          password: '',
        },
        errors: {}
      }
    },
    components: {
      ValidationErrors
    },
    methods: {
      async submit() {
        try {
          await this.$auth.loginWith('local', {
            data: this.form
          })
        } catch (err) {
          this.errors = err.response.data.errors;
        }
      },
    },
  }
</script>
