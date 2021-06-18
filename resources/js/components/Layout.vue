<template>
  <div>
    <Header />
       <ul>
        <li>
          <v-link href="/">Home</v-link>
          <v-link href="/about">About</v-link>
        </li>
      </ul>
      <main class="container flex-grow px-4 mx-auto my-12">
        <slot />
      </main>
    <Footer />
  </div>
</template>

<script>
import Header from "./Header.vue"
import Footer from "./Footer.vue"
import VLink from './VLink.vue'
export default {
  name: "Layout",
  components: {
    Header,
    Footer,
    VLink
  },
}
</script>

<style scoped>

</style>