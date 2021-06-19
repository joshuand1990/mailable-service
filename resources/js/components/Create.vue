<template>
   <div class="w-full">
     <form v-on:submit.prevent="onSubmit">
     <header class="flex flex-wrap -mx-3 mb-6">
       <div class="bg-indigo-500 w-full px-3">
        <h2 class="text-white px-3 py-3">New Message</h2>
       </div>
     </header>
    <section class="flex flex-wrap -mx-3 mb-6">
        <div class="w-full px-3">
            <input type="email"
                   class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                   placeholder="To"
                   v-model.trim="$v.to.$model"
                   v-focus required />
            <div v-if="!$v.to.required" class="text-red-300">The email field is required.</div>
            <div v-if="!$v.to.email" class="text-red-300">This has to be an email.</div>

        </div>
    </section>
    <section class="flex flex-wrap -mx-3 mb-6">
        <div class="w-full px-3">
            <input type="text"
                   class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                   placeholder="Name"
                   v-model.trim="$v.name.$model"
                   v-focus required />
            <div v-if="!$v.name.required" class="text-red-300">The Name field is required.</div>
        </div>
    </section>
    <section class="flex flex-wrap -mx-3 mb-6">
      <div class="w-full px-3">
      <input v-model.trim="$v.subject.$model"
          class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
             placeholder="Subject"
             @focus="focusOnSection('subject')" required>
        <div v-if="!$v.subject.required" class="text-red-300">The subject field is required.</div>
      </div>
    </section>
     <section class="flex flex-wrap -mx-3 mb-6">
        <div class="w-full px-3">
          <textarea v-model.trim="$v.body.$model"
                    class="shadow no-resize appearance-none block w-full text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500 h-48 resize-none"
                    placeholder="Body"
                    @focus="focusOnSection('body')" required />
            <div v-if="!$v.subject.required" class="text-red-300">The body field is required.</div>
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

import { required, email } from 'vuelidate/lib/validators'


export default {
  name: "Create",
  validations :{
      name: {required},
      to: {required, email},
      body: {required},
      subject: {required}
  },
  data() {
    return {
      name: '',
      to: '',
      subject: '',
      body: '',
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
      onSubmit() {
        const message = {
          name: this.name,
          email: this.to,
          subject: this.subject,
          body: this.body
        }
        this.$v.$touch();
        if (this.$v.$pending || this.$v.$error) return;

        this.$http.post('/api/mail', message)
      }
  }

}
</script>

<style scoped>

</style>