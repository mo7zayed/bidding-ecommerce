<template>
  <tr>
    <td width="120">
      <img src="https://via.placeholder.com/60x60" :alt="product.id">
    </td>
    <td>
      {{ product.product.name }} ({{ product.name }}) / {{ product.type }}
    </td>
    <td width="160">
      <div class="field">
        <div class="control">
          <div class="select is-fullwidth">
            <select v-model="quantity">
              <option v-if="product.quantity == 0" value="0">0</option>
              <option v-for="x in product.stock_count" :key="x * 2" :value="x">
                {{ x }}
              </option>
            </select>
          </div>
        </div>
      </div>
    </td>
    <td>
      {{ product.total }}
    </td>
    <td>
      <button @click="destroy(product.id)" class="button is-danger">
        Delete
      </button>
    </td>
  </tr>
</template>

<script>
  import {
    mapActions
  } from 'vuex'
  export default {
    props: {
      product: {
        required: true,
        type: Object,
      },
    },
    data() {
      return {
        quantity: this.product.quantity,
      }
    },
    watch: {
      quantity() {
        this.update({
          productId: this.product.id,
          quantity: this.quantity,
        })
      }
    },
    methods: {
      ...mapActions({
        destroy: 'cart/destroy',
        update: 'cart/update',
      })
    }
  }
</script>
