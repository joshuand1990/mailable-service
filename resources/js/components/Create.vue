<template>
   <div class="w-full">
     <form @submit="submit">
     <header class="flex flex-wrap -mx-3 mb-6">
       <div class="bg-indigo-500 w-full px-3">
        <h2 class="text-white px-3 py-3">New Message</h2>
       </div>
     </header>
    <section class="flex flex-wrap -mx-3 mb-6">
        <div class="w-full px-3">
            <input v-model="message.to"
                   class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                   placeholder="To"
                   v-focus>
        </div>
    </section>
    <section class="flex flex-wrap -mx-3 mb-6">
      <div class="w-full px-3">
      <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
             placeholder="Subject"
             @focus="focusOnSection('subject')">
      </div>
    </section>
     <section class="flex flex-wrap -mx-3 mb-6">
        <div class="w-full px-3">
          <textarea
                    class="shadow no-resize appearance-none block w-full text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500 h-48 resize-none"
                    placeholder="Body"
                    @focus="focusOnSection('body')" />
        </div>
     </section>
      <footer>
        <input type="submit"
               class="shadow bg-indigo-500 hover:bg-purple-400 focus:shadow-outline focus:outline-none text-white font-bold py-2 px-4 rounded"
               value="Send">
      </footer>
       </form>
    </div>
</template>

<script>

export default {
  name: "Create",
  data() {
    return {
      message: {
        to: '',
        cc: '',
        bcc: '',
        subject: '',
        body: '',
      },
      active: false,
      activeSection: 'to',
      ccActive: false,
      bccActive: false
    }
  },
    methods: {
      focusOnSection(section) {
        this.activeSection = section
      },
      submit() {
        console.log("Hello")
      }
  }

}
</script>

<style scoped>

</style>