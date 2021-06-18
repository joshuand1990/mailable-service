<template>
    <div class="h-full w-60 hidden lg:flex mf:flex">
        <div class="flex-auto">
          <div class="header p-4">
            <router-link to="/create"
                       :class="`flex text-sm hover:border-indigo-400 hover:text-indigo-400 border-2 rounded-md border-indigo-500
        items-center text-indigo-500 px-4 py-2 focus:outline-none w-full`"
            >
              <i class='bx bx-plus mr-4'></i>
              Compose
            </router-link>

          </div>
          <div class="mt-3 flex-auto">
              <router-link to="/">
                <ItemSidebar active icon="inbox">
                Inbox
                </ItemSidebar>
              </router-link>
          </div>
        </div>
    </div>
</template>

<script>
import ButtonApp from './ButtonApp.vue'
import ItemSidebar from './ItemSidebar.vue'

export default {
    name: 'SideBar',
    components: {
        ButtonApp,
        ItemSidebar
    },

    mounted() {
        /* console.log(this.$router.currentRoute.fullPath) */
    },
}
</script>