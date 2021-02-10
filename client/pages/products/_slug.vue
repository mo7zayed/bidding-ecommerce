<template>
  <div class="container">
    <div class="section">
      <div class="container is-fluid">
        <div class="columns">
          <div class="column is-half">
            <img src="http://via.placeholder.com/620x620" alt="Product name">
          </div>
          <div class="column is-half">
            <section class="section">
              <h1 class="title is-4">
                {{ product.name }}
              </h1>
              <p>
                {{ product.description }}
              </p>

              <hr>

              <span class="tag is-rounded is-medium is-dark" v-if="!product.in_stock">
                Out Of Stock
              </span>

              <span class="tag is-rounded is-medium">
                {{ product.price }}
              </span>
            </section>


            <section v-if="$auth.loggedIn" class="section">
              <ValidationErrors :errors="errors" />

              <success-msg
                :msg="'Bid successfully updated'"
                :show="showSuccessMsg"
                @hide="showSuccessMsg=false"
              ></success-msg>

              <h3 class="title is-3">Bidding</h3>

              <template v-if="bid_end_time">
                <h5>Bidding will end at: {{ bid_end_time }}</h5>

                <no-ssr>
                  <vac :end-time="new Date(bid_end_time).getTime() + 1*60*60*1000">
                    <span
                      slot="process"
                      slot-scope="{ timeObj }">{{ `Lefttime: ${timeObj.m}:${timeObj.s}` }}</span>
                    <span slot="finish">Bidding is ended now!</span>
                  </vac>
                </no-ssr>
                <br>
              </template>

              <div class="field has-addons">
                <div class="control">
                  <div class="is-fullwidth">
                    <input class="input" type="number" v-model="bid_value">
                  </div>
                </div>
                <div class="control">
                  <button type="button" @click="bid()" class="button is-info">
                    Bid now
                  </button>
                </div>
              </div>
            </section>

            <section v-if="$auth.loggedIn" class="section">
              <ProductVariation v-for="(variations, type) in product.variations" :key="type" :type="type" :variations="variations" v-model="form.variation" />

              <div class="field has-addons" v-if="form.variation">
                <div class="control">
                  <div class="is-fullwidth">
                    <input class="input" type="number" v-model="form.quantity">
                    <p class="help-text">Max: {{ form.variation.stock_count }}</p>
                  </div>
                </div>
                <div class="control">
                  <button type="button" @click="add()" class="button is-info">
                    Add To Cart
                  </button>
                </div>
              </div>
            </section>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  import ProductVariation from '@/components/products/ProductVariation'

  import ValidationErrors from '@/components/global/ValidationErrors'
  import SuccessMsg from '@/components/global/SuccessMsg'

  import vueAwesomeCountdown from 'vue-awesome-countdown'

  import {
    mapActions
  } from 'vuex'

  export default {
    data() {
      return {
        product: {},
        errors: {},
        bid_value: 0,
        bid_end_time: null,
        showSuccessMsg: false,
        form: {
          variation: '',
          quantity: 1,
        },
      }
    },
    watch: {
      'form.variation'() {
        this.form.quantity = 1
      },
      'form.quantity'() {
        if (!this.form.variation) {
          this.form.quantity = 1
          return
        }

        if (!this.form.variation.in_stock) {
          this.form.quantity = 1
          return
        }

        if (this.form.quantity > this.form.variation.stock_count) {
          this.form.quantity = this.form.variation.stock_count
        }
      }
    },
    components: {
      ProductVariation,
      ValidationErrors,
      SuccessMsg,
      vueAwesomeCountdown
    },
    methods: {
      ...mapActions({
        store: 'cart/store',
      }),
      add() {
        this.store([{
          id: this.form.variation.id,
          quantity: this.form.quantity,
        }])
      },
      async bid() {
        try {
          const response = await this.$axios.$post(`bid/${this.$route.params.slug}`, {
            product_id: this.product.id,
            bid_value: this.bid_value,
          })

          this.showSuccessMsg = true
          this.errors = {}
          this.product = response.payload
          this.bid_value = ((response.payload.last_bid[0] || {}).bid_value || 0) + 1
          this.bid_end_time = (response.payload.first_bid[0] || {}).created_at || null
        } catch (err) {
          this.showSuccessMsg = false
          this.errors = err.response.data.errors
        }
      }
    },
    async asyncData({params, app}) {
      let response = await app.$axios.$get(`products/${params.slug}`)

      return {
        product: response.payload,
        bid_value: ((response.payload.last_bid[0] || {}).bid_value || 0) + 1,
        bid_end_time: (response.payload.first_bid[0] || {}).created_at || null
      }
    },
  }
</script>
