<template>
      <div class="toggle hidden md:flex w-full md:w-auto text-right text-bold mt-5 md:mt-0 border-t-2 border-blue-900 md:border-none">
          <router-link to="/"
                       class="block md:inline-block text-blue-900 hover:text-blue-500 px-3 py-3 border-b-2 border-blue-900 md:border-none"
          >App</router-link>
          <router-link to="/about"
                       class="block md:inline-block text-blue-900 hover:text-blue-500 px-3 py-3 border-b-2 border-blue-900 md:border-none"
          >About</router-link>
      </div>
</template>

<script>
export default {
  name: "Header"
}
</script>

<style scoped>

</style>