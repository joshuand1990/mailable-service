<template>
  <div>
    <Header />
      <main class="container flex-grow px-4 mx-auto my-12">
        <router-view/>
      </main>
    <Footer />
  </div>
</template>

<script>
import Header from "./Header.vue"
import Footer from "./Footer.vue"

export default {
  name: "Layout",
  components: {
    Header,
    Footer
  },
}
</script>

<style scoped>

</style>