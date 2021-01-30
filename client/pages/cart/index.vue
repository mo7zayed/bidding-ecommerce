<template>
  <div class="section">
    <div class="container is-fluid">
      <div class="columns is-centered">
        <div class="column is-three-quarters">
          <h1 class="title is-4">Your cart</h1>

          <article class="message" v-if="products.length">
            <CartOverview />
          </article>

          <a v-if="!is_empty" href="#" class="button is-fullwidth is-info is-medium">
            Checkout
          </a>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  import CartOverview from '@/components/cart/CartOverview'
  import {
    mapGetters
  } from 'vuex'

  export default {
    components: {
      CartOverview
    },
    computed: {
      ...mapGetters({
        is_empty: 'cart/is_empty',
        products: 'cart/products',
      })
    }
  }
</script>
