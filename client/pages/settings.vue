<template>
  <div class="section">
    <div class="container is-fluid">
      <div class="columns is-centered">
        <div class="column is-6">
          <h1 class="title is-4">Bidding Configurations</h1>

          <ValidationErrors :errors="errors" />

          <form @submit.prevent="submit()">
            <div class="field">
              <label class="label">Max bid</label>
              <div class="control">
                <input class="input" v-model="form.max_bid" type="number" placeholder="Default is unlimited">
                <p>Putting (0) as a max bid means "Unlimited"</p>
              </div>
            </div>

            <div class="field">
              <p class="control">
                <button class="button is-info is-small">
                  Update Configurations
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
          max_bid: ''
        },
        errors: {}
      }
    },
    components: {
      ValidationErrors
    },
    created () {
      this.form.max_bid = this.$auth.user.max_bid
    },
    methods: {
      async submit() {
        try {
          await this.$axios.$post(`auth/me/update/configurations`, this.form)
        } catch (err) {
          this.errors = err.response.data.errors;
        }
      },
    },
  }
</script>
