<template>
  <div>
    <div class="bg-white rounded-lg shadow-md p-6 mb-8 border-t-4 border-red-600">
      <h1 class="text-3xl font-bold text-gray-800 mb-2">Messages</h1>
      <p class="text-gray-600">Contact form submissions from your portfolio</p>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6">
      <div class="mb-4 flex flex-wrap items-center justify-between gap-3">
        <h2 class="text-xl font-semibold text-gray-800">Inbox</h2>
        <p class="text-sm text-gray-500">
          {{ unreadCount }} unread · {{ messages.total ?? 0 }} total
        </p>
      </div>

      <div v-if="loading" class="py-12 text-center text-gray-500">Loading messages...</div>

      <div v-else-if="!messages.data?.length" class="rounded-lg border border-dashed border-gray-300 py-12 text-center text-gray-500">
        No messages yet.
      </div>

      <div v-else class="overflow-x-auto">
        <table class="w-full table-auto">
          <thead>
            <tr class="text-left text-sm text-gray-600">
              <th class="px-4 py-3 border-b-2 border-gray-200">From</th>
              <th class="px-4 py-3 border-b-2 border-gray-200">Message</th>
              <th class="px-4 py-3 border-b-2 border-gray-200">Date</th>
              <th class="px-4 py-3 border-b-2 border-gray-200">Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr
              v-for="msg in messages.data"
              :key="msg.id"
              :class="[
                'border-b border-gray-100 transition',
                !msg.is_read ? 'bg-red-50/60' : 'hover:bg-gray-50',
              ]"
            >
              <td class="px-4 py-3">
                <p class="font-semibold text-gray-800">{{ msg.name }}</p>
                <p class="text-sm text-gray-500">{{ msg.email }}</p>
              </td>
              <td class="px-4 py-3 max-w-md">
                <p class="truncate text-gray-700">{{ msg.message }}</p>
              </td>
              <td class="px-4 py-3 text-sm text-gray-500 whitespace-nowrap">
                {{ formatDate(msg.created_at) }}
              </td>
              <td class="px-4 py-3 whitespace-nowrap">
                <button
                  type="button"
                  class="mr-2 px-3 py-1 text-sm bg-blue-500 text-white rounded-lg hover:bg-blue-600"
                  @click="openMessage(msg)"
                >
                  View
                </button>
                <button
                  type="button"
                  class="px-3 py-1 text-sm bg-red-500 text-white rounded-lg hover:bg-red-600"
                  @click="deleteMessage(msg.id)"
                >
                  Delete
                </button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <div v-if="messages.data?.length" class="mt-6 flex justify-center gap-4">
        <button
          type="button"
          :disabled="!messages.prev_page_url"
          class="px-4 py-2 bg-gray-300 rounded-lg hover:bg-gray-400 disabled:opacity-50 font-bold"
          @click="fetchMessages(messages.prev_page_url)"
        >
          &lt;
        </button>
        <span class="px-4 py-2 text-gray-700">Page {{ messages.current_page }} of {{ messages.last_page }}</span>
        <button
          type="button"
          :disabled="!messages.next_page_url"
          class="px-4 py-2 bg-gray-300 rounded-lg hover:bg-gray-400 disabled:opacity-50 font-bold"
          @click="fetchMessages(messages.next_page_url)"
        >
          &gt;
        </button>
      </div>
    </div>

    <div
      v-if="selected"
      class="fixed inset-0 z-50 flex items-center justify-center bg-black/30 backdrop-blur-sm p-4"
      @click.self="closeModal"
    >
      <div class="w-full max-w-lg rounded-xl bg-white p-6 shadow-xl">
        <div class="mb-4 flex items-start justify-between gap-4">
          <div>
            <h3 class="text-xl font-bold text-gray-800">{{ selected.name }}</h3>
            <a :href="`mailto:${selected.email}`" class="text-sm text-red-600 hover:underline">{{ selected.email }}</a>
          </div>
          <button type="button" class="text-2xl text-gray-400 hover:text-gray-600" @click="closeModal">&times;</button>
        </div>

        <p class="mb-2 text-xs text-gray-500">{{ formatDate(selected.created_at) }}</p>
        <p class="whitespace-pre-wrap rounded-lg bg-gray-50 p-4 text-gray-700">{{ selected.message }}</p>

        <div class="mt-6 flex flex-wrap justify-end gap-2">
          <button
            type="button"
            class="px-4 py-2 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-50"
            @click="toggleRead(selected)"
          >
            {{ selected.is_read ? 'Mark unread' : 'Mark read' }}
          </button>
          <a
            :href="`mailto:${selected.email}?subject=Re: Portfolio contact`"
            class="px-4 py-2 rounded-lg bg-red-600 text-white hover:bg-red-700"
          >
            Reply by email
          </a>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'AdminMessages',
  data() {
    return {
      loading: true,
      messages: { data: [] },
      selected: null,
    }
  },
  computed: {
    unreadCount() {
      return (this.messages.data || []).filter((m) => !m.is_read).length
    },
  },
  methods: {
    csrfToken() {
      return document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') ?? ''
    },
    formatDate(value) {
      if (!value) return ''
      return new Date(value).toLocaleString()
    },
    async fetchMessages(url = '/admin/messages') {
      this.loading = true
      try {
        const res = await fetch(url, {
          headers: { Accept: 'application/json' },
          credentials: 'same-origin',
        })
        if (res.ok) {
          this.messages = await res.json()
        }
      } catch (e) {
        console.error(e)
      } finally {
        this.loading = false
      }
    },
    async openMessage(msg) {
      try {
        const res = await fetch(`/admin/messages/${msg.id}`, {
          headers: { Accept: 'application/json' },
          credentials: 'same-origin',
        })
        if (res.ok) {
          this.selected = await res.json()
          const idx = this.messages.data.findIndex((m) => m.id === msg.id)
          if (idx !== -1) {
            this.messages.data[idx].is_read = true
          }
        }
      } catch (e) {
        console.error(e)
      }
    },
    closeModal() {
      this.selected = null
    },
    async toggleRead(msg) {
      try {
        const res = await fetch(`/admin/messages/${msg.id}`, {
          method: 'PUT',
          headers: {
            'X-CSRF-TOKEN': this.csrfToken(),
            'Content-Type': 'application/json',
            Accept: 'application/json',
          },
          credentials: 'same-origin',
          body: JSON.stringify({ is_read: !msg.is_read }),
        })
        if (res.ok) {
          const updated = await res.json()
          const idx = this.messages.data.findIndex((m) => m.id === msg.id)
          if (idx !== -1) this.messages.data[idx].is_read = updated.is_read
          if (this.selected?.id === msg.id) this.selected.is_read = updated.is_read
        }
      } catch (e) {
        console.error(e)
      }
    },
    async deleteMessage(id) {
      if (!window.confirm('Delete this message?')) return
      try {
        const res = await fetch(`/admin/messages/${id}`, {
          method: 'DELETE',
          headers: {
            'X-CSRF-TOKEN': this.csrfToken(),
            Accept: 'application/json',
          },
          credentials: 'same-origin',
        })
        if (res.ok) {
          this.messages.data = this.messages.data.filter((m) => m.id !== id)
          if (this.selected?.id === id) this.selected = null
        }
      } catch (e) {
        console.error(e)
      }
    },
  },
  mounted() {
    this.fetchMessages()
  },
}
</script>
