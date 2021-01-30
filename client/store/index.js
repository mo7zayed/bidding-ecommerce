export const state = () => ({
  categories: [],
})

export const mutations = {
  SET_CATEGORIES(state, data) {
    state.categories = data
  }
}
export const getters = {
  categories(state) {
    return state.categories
  }
}

export const actions = {
  async nuxtServerInit({
    commit,
    dispatch
  }) {
    let response = await this.$axios.$get('categories')

    commit('SET_CATEGORIES', response.payload)

    if (this.$auth.loggedIn) {
      await dispatch('cart/getCart')
    }
  }
}
