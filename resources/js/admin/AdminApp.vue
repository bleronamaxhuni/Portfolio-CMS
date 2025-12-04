<template>
  <div class="flex min-h-screen">
    <aside class="w-64 bg-red-700 text-white shadow-lg relative">
      <div class="p-6">
        <h2 class="text-2xl font-bold mb-8">Admin Panel</h2>
        <nav class="space-y-2">
          <a href="/admin/dashboard" :class="{ 'bg-red-800': isActive('/admin/dashboard') }" class="block px-4 py-3 rounded-lg hover:bg-red-800 transition font-semibold">Dashboard</a>
          <a href="/admin/projects" :class="{ 'bg-red-800': isActive('/admin/projects') }" class="block px-4 py-3 rounded-lg hover:bg-red-700 transition">Projects</a>
          <a href="#skills" :class="{ 'bg-red-800': isActive('#skills') }" class="block px-4 py-3 rounded-lg hover:bg-red-700 transition">Skills</a>
          <a href="#experiences" :class="{ 'bg-red-800': isActive('#experiences') }" class="block px-4 py-3 rounded-lg hover:bg-red-700 transition">Experiences</a>
          <a href="#about-me" :class="{ 'bg-red-800': isActive('#about-me') }" class="block px-4 py-3 rounded-lg hover:bg-red-700 transition">About Me</a>
          <a href="#contact" :class="{ 'bg-red-800': isActive('#contact') }" class="block px-4 py-3 rounded-lg hover:bg-red-700 transition">Contact Me</a>
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
import AdminProjects from './views/AdminProjects.vue'

export default {
  components: { AdminDashboard, AdminProjects },
  computed: {
    currentPath() {
      return window.location.pathname
    },
    currentComponent() {
      if (this.currentPath.includes('/admin/projects')) return 'AdminProjects'
      return 'AdminDashboard'
    }
  },
  methods: {
    isActive(path) {
      const currentPath = window.location.pathname
      if (path.startsWith('#')) {
        return window.location.hash === path
      }
      return currentPath.includes(path)
    },
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
