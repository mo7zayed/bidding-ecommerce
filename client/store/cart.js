export const state = () => ({
  products: [],
  is_empty: false,
  subtotal: '',
  total: '',
  changed: false,
})

export const mutations = {
  SET_PRODUCTS(state, data) {
    state.products = data
  },
  SET_IS_EMPTY(state, is_empty) {
    state.is_empty = is_empty
  },
  SET_SUBTOTAL(state, subtotal) {
    state.subtotal = subtotal
  },
  SET_TOTAL(state, total) {
    state.total = total
  },
  SET_CHANGED(state, changed) {
    state.changed = changed
  },
}

export const getters = {
  products(state) {
    return state.products
  },
  is_empty(state) {
    return state.is_empty
  },
  subtotal(state) {
    return state.subtotal
  },
  total(state) {
    return state.total
  },
  changed(state) {
    return state.changed
  },
  count(state) {
    return state.products.length
  },
}

export const actions = {
  async getCart({
    commit
  }) {
    let response = await this.$axios.$get('cart')

    commit('SET_PRODUCTS', response.payload.products)

    commit('SET_IS_EMPTY', response.payload.meta.is_empty)

    commit('SET_SUBTOTAL', response.payload.meta.subtotal)

    commit('SET_TOTAL', response.payload.meta.total)

    commit('SET_CHANGED', response.payload.meta.changed)

    return response.payload
  },
  async destroy({
    dispatch
  }, productId) {
    await this.$axios.$delete(`cart/${productId}`)

    dispatch('getCart')
  },
  async update({
    dispatch
  }, {
    productId,
    quantity
  }) {
    await this.$axios.$patch(`cart/${productId}`, {
      quantity: quantity
    })

    dispatch('getCart')
  },
  async store({
    dispatch
  }, products) {
    await this.$axios.$post('cart', {
      products: products,
    })

    dispatch('getCart')
  },
}