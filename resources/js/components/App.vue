<template>
      <table class="table-fixed">
        <caption>Emails</caption>
        <thead>
            <tr>
                <th class="border w-1/4">Name</th>
                <th class="border w-1/2">Subject</th>
                <th class="border w-1/4">Status</th>
                <th class="border w-1/4">Channel</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="(mail, index) in mails" :key="index" >
                <td class="border px-1 py-1">{{ mail.email  }}</td>
                <td class="border px-1 py-1">{{ mail.subject }}</td>
                <td class="border px-1 py-1" v-bind:class="mail.css">{{ mail.status }}</td>
                <td class="border px-1 py-1">{{ mail.channel }}</td>
            </tr>
        </tbody>
    </table>
</template>

<script>

import axios from "axios"
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
        const response = await axios.get(url)
        const results = response.data
        this.mails = results.map(mail => ({
          id: mail.id,
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