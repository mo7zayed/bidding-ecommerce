<template>
  <div class="card">
    <div class="card-image">
      <figure class="image is-4by3">
        <nuxt-link :to="{ name: 'products-slug', params: { slug: product.slug } }">
          <img src="https://bulma.io/images/placeholders/1280x960.png" alt="Placeholder image">
        </nuxt-link>
      </figure>
    </div>
    <div class="card-content">
      <div class="media">
        <div class="media-content">
          <nuxt-link class="title is-5" :to="{ name: 'products-slug', params: { slug: product.slug } }">
            {{ product.name }}
          </nuxt-link>
        </div>
      </div>

      <div class="content">
        {{ product.description }}
        <hr>
        <div class="columns">
          <div class="column">
            <span class="tag is-rounded">
              Price: {{ product.price }}
            </span>
            <span class="tag is-rounded is-dark" v-if="!product.in_stock">
              Out Of Stock
            </span>
            <span class="tag is-rounded">
              {{ product.created_at }}
            </span>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  export default {
    props: {
      product: {
        type: Object,
        required: true,
      },
    }
  }
</script>
