<template>
  <div class="flex h-full">
    <SideBar />
      <div class="flex-auto overflow-auto">
        <router-view/>
      </div>
  </div>
</template>

<script>
import Header from "./Header.vue"
import Footer from "./Footer.vue"
import SideBar from './SideBar.vue'

export default {
  name: "Layout",
  components: {
    Header,
    Footer,
    SideBar
  },
}
</script>

<style scoped>

</style>