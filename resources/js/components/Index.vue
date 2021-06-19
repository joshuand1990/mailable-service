<template>
  <div class="overflow-auto absolute truncate" style="max-width: -webkit-fill-available;">
    <form id="sendmail-form" v-on:submit.prevent="submit">
    <div
        class="p-2 border-b transition duration-300 cursor-pointer hover:bg-gray-50 flex items-center max-w-full pr-14 items-start"
        v-for="(mail, index) in mails"
        :key="index">
      <div
          style="min-width: 5em"
          class="flex-initial text-xs text-center font-semibold inline-block py-1 px-1 uppercase rounded last:mr-0 mr-1"
          :class="mail.css"
          :title="mail.status">
      </div>
      <div style="min-width: 20rem"
           class="flex-initial text-sm ml-5 truncate text-gray-700" >
        <span :title="mail.name">{{ mail.email }}</span>
      </div>
      <div class="flex-initial text-sm ml-10 text-gray-700 truncate overflow-auto" >
        {{ mail.subject }}
      </div>
    </div>
    </form>
  </div>
</template>

<script>

import Layout from "./Layout";
export default {
  name: "App",
  components: {
    Layout,
  },
  data() {
    return {
      mails: [],
    }
  },
  methods: {
    async fetchNews() {
      try {
        const url = `/api/mail`
        const response = await this.$http.get(url)
        const results = response.data
        this.mails = results.map(mail => ({
          id: mail.id,
          name: mail.name,
          email: mail.email,
          subject: mail.subject,
          status: mail.status,
          channel: mail.transport,
          css: mail.css
        }))

      } catch (err) {
        if (err.response) {
          // client received an error response (5xx, 4xx)
          console.log("Server Error:", err)
        } else if (err.request) {
          // client never received a response, or request never left
          console.log("Network Error:", err)
        } else {
          console.log("Client Error:", err)
        }
      }
    },
  },
  mounted() {
    this.fetchNews()
  }
}
</script>