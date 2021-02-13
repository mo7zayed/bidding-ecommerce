<template>
  <section v-if="$auth.loggedIn" class="section">
    <ValidationErrors :errors="errors" />

    <success-msg
      :msg="'Bid successfully updated'"
      :show="showSuccessMsg"
      @hide="showSuccessMsg = false"
    ></success-msg>

    <template v-if="endTime && isBiddingTimePassed">
      <h3 class="title is-3">Bidding</h3>

      <h5>Bidding will end at: {{ new Date(endTime) }}</h5>

      <h5>Your last bid: {{ user_last_bid }}</h5>

      <no-ssr>
        <vac :end-time="endTime">
          <span slot="process" slot-scope="{ timeObj }">{{
            `Lefttime: ${timeObj.m}:${timeObj.s}`
          }}</span>
          <span slot="finish">Bidding is ended now!</span>
        </vac>
      </no-ssr>
      <br />
    </template>

    <div class="field has-addons" v-if="isBiddingTimePassed">
      <div class="control">
        <div class="is-fullwidth">
          <input class="input" type="number" v-model="bid_value" />
        </div>
      </div>
      <div class="control">
        <button type="button" @click="bid()" class="button is-info">
          Bid now
        </button>
      </div>
    </div>

    <div class="field" v-if="isBiddingTimePassed">
      <label class="checkbox">
        <input type="checkbox" v-model="toggle_auto_bidding" @input="toggleAutoBidding">
        Enable auto bidding
      </label>
    </div>
  </section>
</template>

<script>
import ValidationErrors from '@/components/global/ValidationErrors'
import SuccessMsg from '@/components/global/SuccessMsg'
import vueAwesomeCountdown from 'vue-awesome-countdown'

export default {
  props: {
    product: Object,
  },
  components: {
    ValidationErrors,
    SuccessMsg,
    vueAwesomeCountdown
  },
  data () {
    return {
      errors: {},
      bid_value: 0,
      user_last_bid: 0,
      bid_end_time: null,
      showSuccessMsg: false,
      toggle_auto_bidding: false
    }
  },
  computed: {
    endTime () {
      if (!this.bid_end_time) {
        return null
      }

      return new Date(this.bid_end_time).getTime() + 1 * 60 * 60 * 1000
    },
    isBiddingTimePassed () {
      if (!this.endTime) {
        return true
      }

      return new Date().getTime() < this.endTime
    }
  },
  created () {
    this.getUserLastBid()
    this.bid_value = this.getLastBidValue(this.product) + 1,
    this.bid_end_time = this.getFirstBidCreationTime(this.product)
    this.toggle_auto_bidding = this.product.is_auto_bidding_enabled
  },
  methods: {
    async toggleAutoBidding () {
      await this.$axios.$post(`enable-auto-bidding`, {
        product_id: this.product.id
      })
    },
    async getUserLastBid () {
      const response = await this.$axios.$post(`user-last-bid`, {
        product_id: this.product.id
      })

      this.user_last_bid = response.payload.user_last_bid
    },
    async bid() {
      try {
        const response = await this.$axios.$post(`bid/${this.$route.params.slug}`, {
          product_id: this.product.id,
          bid_value: this.bid_value,
        })

        this.showSuccessMsg = true
        this.errors = {}
        this.bid_value = this.getLastBidValue(response.payload) + 1
        this.bid_end_time = this.getFirstBidCreationTime(response.payload)

        this.getUserLastBid()
      } catch (err) {
        this.showSuccessMsg = false
        this.errors = err.response.data.errors
      }
    },
    getLastBidValue (product) {
      const last_bid = 'last_bid' in product && product.last_bid.length ? product.last_bid[0] : null;

      if (last_bid) {
        return last_bid.bid_value
      }

      return 0
    },
    getFirstBidCreationTime (product) {
      const first_bid = 'first_bid' in product && product.first_bid.length ? product.first_bid[0] : null;

      if (first_bid) {
        return first_bid.created_at
      }

      return null
    }
  }
}
</script>