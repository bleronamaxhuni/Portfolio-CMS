<template>
  <div class="flex min-h-screen">
    <aside class="w-64 bg-red-600 text-white shadow-lg relative">
      <div class="p-6">
        <h2 class="text-2xl font-bold mb-8">Admin Panel</h2>
        <nav class="space-y-2">
          <a href="/admin" class="block px-4 py-3 rounded-lg bg-red-700 hover:bg-red-800 transition font-semibold">Dashboard</a>
          <a href="#projects" class="block px-4 py-3 rounded-lg hover:bg-red-700 transition">Projects</a>
          <a href="#skills" class="block px-4 py-3 rounded-lg hover:bg-red-700 transition">Skills</a>
          <a href="#experiences" class="block px-4 py-3 rounded-lg hover:bg-red-700 transition">Experiences</a>
          <a href="#about-me" class="block px-4 py-3 rounded-lg hover:bg-red-700 transition">About Me</a>
          <a href="#contact" class="block px-4 py-3 rounded-lg hover:bg-red-700 transition">Contact Me</a>
        </nav>
      </div>

      <div class="absolute bottom-6 left-6 right-6">
        <button @click="logout" class="w-full px-4 py-2 bg-white text-red-600 font-semibold rounded-lg hover:bg-gray-100 transition">Logout</button>
      </div>
    </aside>

    <main class="flex-1 p-8">
      <component :is="currentComponent" />
    </main>
  </div>
</template>

<script>
import AdminDashboard from './views/AdminDashboard.vue'

export default {
  components: { AdminDashboard },
  computed: {
    page() {
      return document.getElementById('admin-app')?.dataset.page || 'dashboard'
    },
    currentComponent() {
      if (this.page === 'dashboard') return 'AdminDashboard'
      return 'AdminDashboard'
    }
  },
  methods: {
    async logout() {
      try {
        const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')
        await fetch('/logout', {
          method: 'POST',
          headers: {
            'X-CSRF-TOKEN': token,
            'Content-Type': 'application/json',
            'Accept': 'application/json'
          },
          credentials: 'same-origin'
        })

        window.location.href = '/login'
      } catch (e) {
        console.error(e)
      }
    }
  }
}
</script>

<style scoped>
</style>
