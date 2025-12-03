<template>
  <div>
    <!-- Header -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-8 border-t-4 border-red-600">
      <h1 class="text-3xl font-bold text-gray-800 mb-2">Welcome to Admin Dashboard</h1>
      <p class="text-gray-600">Manage your portfolio content from here</p>
    </div>

    <!-- Dashboard Stats -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
      <!-- Projects Card -->
      <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-red-600 hover:shadow-lg transition">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-gray-600 text-sm">Projects</p>
            <p class="text-3xl font-bold text-red-600">0</p>
          </div>
          <svg class="w-12 h-12 text-red-200" fill="currentColor" viewBox="0 0 20 20">
            <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4z"></path>
            <path fill-rule="evenodd" d="M3 10a1 1 0 011-1h12a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6z" clip-rule="evenodd"></path>
          </svg>
        </div>
      </div>

      <!-- Skills Card -->
      <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-red-600 hover:shadow-lg transition">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-gray-600 text-sm">Skills</p>
            <p class="text-3xl font-bold text-red-600">0</p>
          </div>
          <svg class="w-12 h-12 text-red-200" fill="currentColor" viewBox="0 0 20 20">
            <path d="M13 7H7v6h6V7z"></path>
            <path fill-rule="evenodd" d="M7 2a1 1 0 012 0v1h2V2a1 1 0 112 0v1h2V2a1 1 0 112 0v1a2 2 0 012 2v2h1a1 1 0 110 2h-1v2h1a1 1 0 110 2h-1v2a2 2 0 01-2 2v1a1 1 0 11-2 0v-1h-2v1a1 1 0 11-2 0v-1a2 2 0 01-2-2v-2H3a1 1 0 110-2h1V9H3a1 1 0 110-2h1V5a2 2 0 012-2V2z" clip-rule="evenodd"></path>
          </svg>
        </div>
      </div>

      <!-- Experiences Card -->
      <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-red-600 hover:shadow-lg transition">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-gray-600 text-sm">Experiences</p>
            <p class="text-3xl font-bold text-red-600">0</p>
          </div>
          <svg class="w-12 h-12 text-red-200" fill="currentColor" viewBox="0 0 20 20">
            <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
          </svg>
        </div>
      </div>

      <!-- Messages Card -->
      <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-red-600 hover:shadow-lg transition">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-gray-600 text-sm">Messages</p>
            <p class="text-3xl font-bold text-red-600">0</p>
          </div>
          <svg class="w-12 h-12 text-red-200" fill="currentColor" viewBox="0 0 20 20">
            <path d="M2 5a2 2 0 012-2h12a2 2 0 012 2v10a2 2 0 01-2 2H4a2 2 0 01-2-2V5z"></path>
            <path d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z"></path>
          </svg>
        </div>
      </div>
    </div>

    <!-- Quick Actions -->
    <div class="bg-white rounded-lg shadow-md p-6 border-t-4 border-red-600">
      <h2 class="text-xl font-bold text-gray-800 mb-4">Quick Actions</h2>
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        <button class="px-4 py-3 bg-red-600 text-white rounded-lg hover:bg-red-700 transition font-semibold">+ Add Project</button>
        <button class="px-4 py-3 bg-red-600 text-white rounded-lg hover:bg-red-700 transition font-semibold">+ Add Skill</button>
        <button class="px-4 py-3 bg-red-600 text-white rounded-lg hover:bg-red-700 transition font-semibold">+ Add Experience</button>
        <button class="px-4 py-3 bg-red-600 text-white rounded-lg hover:bg-red-700 transition font-semibold">+ Update About Me</button>
        <button class="px-4 py-3 bg-red-600 text-white rounded-lg hover:bg-red-700 transition font-semibold">View Messages</button>
        <button class="px-4 py-3 bg-red-600 text-white rounded-lg hover:bg-red-700 transition font-semibold">Settings</button>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'AdminDashboard'
}
</script>

<style scoped>
</style>
