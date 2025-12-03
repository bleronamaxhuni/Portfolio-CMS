<template>
  <div>
    <!-- Header -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-8 border-t-4 border-red-600">
      <h1 class="text-3xl font-bold text-gray-800 mb-2">Projects</h1>
      <p class="text-gray-600">Manage your portfolio projects</p>
    </div>

    <!-- Projects Table -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
      <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
        <h2 class="text-xl font-bold text-gray-800">All Projects</h2>
        <button @click="openModal" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition font-semibold">+ Add Project</button>
      </div>
      <table class="w-full">
        <thead class="bg-gray-50">
          <tr>
            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Title</th>
            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Description</th>
            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Category</th>
            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Status</th>
            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Actions</th>
          </tr>
        </thead>
          <tbody>
              <tr v-if="projects.length === 0" class="text-center">
                <td colspan="5" class="px-6 py-8 text-gray-500">No projects found.</td>
              </tr>
            <tr v-for="project in projects" :key="project.id" class="border-b border-gray-200 hover:bg-gray-50">
              <td class="px-6 py-4 text-gray-800">{{ project.title }}</td>
              <td class="px-6 py-4 text-gray-600">{{ project.description }}</td>
              <td class="px-6 py-4 text-gray-600">{{ project.category }}</td>
              <td class="px-6 py-4">
                <span v-if="project.status === 'completed'" class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs font-semibold">Completed</span>
                <span v-else-if="project.status === 'ongoing'" class="px-2 py-1 bg-blue-100 text-blue-800 rounded-full text-xs font-semibold">Ongoing</span>
                <span v-else-if="project.status === 'paused'" class="px-2 py-1 bg-red-100 text-red-800 rounded-full text-xs font-semibold">Paused</span>
              </td>
              <td class="px-6 py-4">
                <a :href="project.repository_link" target="_blank" v-if="project.repository_link" class="text-sm text-blue-600 mr-3">Repo</a>
                <a :href="project.link" target="_blank" v-if="project.link" class="text-sm text-green-600 mr-3">Live</a>
                <button @click="openEditModal(project)" class="px-3 py-1 bg-blue-500 text-white rounded hover:bg-blue-600 mr-2">Edit</button>
                <button @click="deleteProject(project.id)" class="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-700">Delete</button>
              </td>
            </tr>
          </tbody>
      </table>
    </div>

    <!-- Add Project Modal -->
    <div v-if="isModalOpen" class="fixed inset-0 bg-black/20 backdrop-blur-md flex items-center justify-center z-50">
      <div class="bg-white rounded-lg shadow-lg p-8 w-full max-w-2xl max-h-[90vh] overflow-y-auto">
        <div class="flex justify-between items-center mb-6">
          <h2 class="text-2xl font-bold text-gray-800">Add New Project</h2>
          <button @click="closeModal" class="text-gray-500 hover:text-gray-700 text-2xl">&times;</button>
        </div>

        <form @submit.prevent="submitProject" class="space-y-4">
          <!-- Title -->
          <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">Title</label>
            <input v-model="form.title" type="text" placeholder="Project title" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-600" required>
          </div>

          <!-- Description -->
          <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">Description</label>
            <textarea v-model="form.description" placeholder="Project description" rows="4" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-600" required></textarea>
          </div>

          <!-- Category -->
          <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">Category</label>
            <input v-model="form.category" type="text" placeholder="e.g., Web, Mobile, Desktop" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-600" required>
          </div>

          <!-- Repository Link -->
          <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">Repository Link</label>
            <input v-model="form.repository_link" type="url" placeholder="https://github.com/..." class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-600">
          </div>

          <!-- Project Link -->
          <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">Project Link</label>
            <input v-model="form.link" type="url" placeholder="https://example.com" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-600">
          </div>

          <!-- Status -->
          <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">Status</label>
            <select v-model="form.status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-600" required>
              <option value="">Select Status</option>
              <option value="completed">Completed</option>
              <option value="ongoing">Ongoing</option>
              <option value="paused">Paused</option>
            </select>
          </div>

          <!-- Form Actions -->
          <div class="flex gap-4 justify-end pt-4">
            <button @click="closeModal" type="button" class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition font-semibold">Cancel</button>
            <button type="submit" class="px-6 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition font-semibold">Create Project</button>
          </div>
        </form>
      </div>
    </div>

    <!-- Edit Project Modal -->
     <div v-if="isEditModalOpen" class="fixed inset-0 bg-black/20 backdrop-blur-md flex items-center justify-center z-50">
      <div class="bg-white rounded-lg shadow-lg p-8 w-full max-w-2xl max-h-[90vh] overflow-y-auto">
        <div class="flex justify-between items-center mb-6">
          <h2 class="text-2xl font-bold text-gray-800">Edit Project</h2>
          <button @click="closeEditModal" class="text-gray-500 hover:text-gray-700 text-2xl">&times;</button>
        </div>

        <form @submit.prevent="submitEditProject" class="space-y-4">
          <!-- Title -->
          <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">Title</label>
            <input v-model="form.title" type="text" placeholder="Project title" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-600" required>
          </div>

          <!-- Description -->
          <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">Description</label>
            <textarea v-model="form.description" placeholder="Project description" rows="4" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-600" required></textarea>
          </div>

          <!-- Category -->
          <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">Category</label>
            <input v-model="form.category" type="text" placeholder="e.g., Web, Mobile, Desktop" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-600" required>
          </div>

          <!-- Repository Link -->
          <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">Repository Link</label>
            <input v-model="form.repository_link" type="url" placeholder="https://github.com/..." class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-600">
          </div>

          <!-- Project Link -->
          <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">Project Link</label>
            <input v-model="form.link" type="url" placeholder="https://example.com" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-600">
          </div>

          <!-- Status -->
          <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">Status</label>
            <select v-model="form.status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-600" required>
              <option value="">Select Status</option>
              <option value="completed">Completed</option>
              <option value="ongoing">Ongoing</option>
              <option value="paused">Paused</option>
            </select>
          </div>

          <!-- Form Actions -->
          <div class="flex gap-4 justify-end pt-4">
            <button @click="closeEditModal" type="button" class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition font-semibold">Cancel</button>
            <button type="submit" class="px-6 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition font-semibold">Save Changes</button>
          </div>
        </form>
      </div>
     </div>

  </div>
</template>

<script>
export default {
  name: 'AdminProjects',
  data() {
    return {
      isModalOpen: false,
      isEditModalOpen: false,
      editingProjectId: null,
      projects: [],
      form: {
        title: '',
        description: '',
        category: '',
        repository_link: '',
        link: '',
        status: ''
      }
    }
  },
  methods: {
    async fetchProjects() {
      try {
        const res = await fetch('/admin/projects', {
          method: 'GET',
          headers: { 'Accept': 'application/json' },
          credentials: 'same-origin'
        })
        if (res.ok) {
          this.projects = await res.json()
        } else {
          console.error('Failed to fetch projects')
        }
      } catch (e) {
        console.error(e)
      }
    },
    openModal() {
      this.isModalOpen = true
    },
    closeModal() {
      this.isModalOpen = false
      this.resetForm()
    },
    resetForm() {
      this.form = {
        title: '',
        description: '',
        category: '',
        repository_link: '',
        link: '',
        status: ''
      }
    },
    async submitProject() {
      try {
        const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')
        const response = await fetch('/admin/projects', {
          method: 'POST',
          headers: {
            'X-CSRF-TOKEN': token,
            'Content-Type': 'application/json',
            'Accept': 'application/json'
          },
          credentials: 'same-origin',
          body: JSON.stringify(this.form)
        })

        if (response.ok) {
          this.closeModal()
          await this.fetchProjects()
        } else {
          console.error('Failed to create project')
        }
      } catch (e) {
        console.error(e)
      }
    },

    openEditModal(project) {
      this.editingProjectId = project.id
      this.form = {
        title: project.title || '',
        description: project.description || '',
        category: project.category || '',
        repository_link: project.repository_link || '',
        link: project.link || '',
        status: project.status || ''
      }
      this.isEditModalOpen = true
    },

    closeEditModal() {
      this.isEditModalOpen = false
      this.editingProjectId = null
      this.resetForm()
    },

    async submitEditProject() {
      if (!this.editingProjectId) return
      try {
        const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')
        const response = await fetch(`/admin/projects/${this.editingProjectId}`, {
          method: 'PUT',
          headers: {
            'X-CSRF-TOKEN': token,
            'Content-Type': 'application/json',
            'Accept': 'application/json'
          },
          credentials: 'same-origin',
          body: JSON.stringify(this.form)
        })

        if (response.ok) {
          this.closeEditModal()
          await this.fetchProjects()
        } else {
          console.error('Failed to update project')
        }
      } catch (e) {
        console.error(e)
      }
    },

    async deleteProject(id) {
      const confirmed = window.confirm('Are you sure you want to delete this project? This action cannot be undone.')
      if (!confirmed) return

      try {
        const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')
        const res = await fetch(`/admin/projects/${id}`, {
          method: 'DELETE',
          headers: {
            'X-CSRF-TOKEN': token,
            'Accept': 'application/json'
          },
          credentials: 'same-origin'
        })
        
        if (res.ok) {
          window.alert('Project deleted successfully.')
          await this.fetchProjects()
        } else {
          console.error('Failed to delete project', res.status)
          window.alert('Failed to delete project.')
        }
      } catch (e) {
        console.error(e)
        window.alert('An error occurred while deleting the project.')
      }
    }
  },
  mounted() {
    this.fetchProjects()
  }
}
</script>

<style scoped>
</style>
