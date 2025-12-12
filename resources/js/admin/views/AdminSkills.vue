<template>
  <!-- Header -->
  <div class="bg-white rounded-lg shadow-md p-6 mb-8 border-t-4 border-red-600">
    <h1 class="text-3xl font-bold text-gray-800 mb-2">Manage Skills</h1>
    <p class="text-gray-600">Add, edit, or remove your skills here.</p>
  </div>

  <!-- Skills Management Section -->
  <div class="bg-white rounded-lg shadow-md p-6">
    <h2 class="text-2xl font-bold text-gray-800 mb-4">Skills List</h2>
    <table class="w-full table-auto mb-6">
      <thead>
        <tr>
          <th class="px-4 py-2 border-b-2 border-gray-200 text-left">Skill Name</th>
          <th class="px-4 py-2 border-b-2 border-gray-200 text-left">
            Proficiency Level
          </th>
          <th class="px-4 py-2 border-b-2 border-gray-200 text-left">Actions</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="skill in skills.data" :key="skill.id">
          <td class="px-4 py-2 border-b border-gray-200">{{ skill.name }}</td>
          <td class="px-4 py-2 border-b border-gray-200">
            {{ skill.proficiency_level }}
          </td>
          <td class="px-4 py-2 border-b border-gray-200">
            <button
              @click="openEditModal(skill)"
              class="px-3 py-1 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition mr-2"
            >
              Edit
            </button>
            <button
              @click="deleteSkill(skill.id)"
              class="px-3 py-1 bg-red-500 text-white rounded-lg hover:bg-red-600 transition"
            >
              Delete
            </button>
          </td>
        </tr>
      </tbody>
    </table>

    <!-- Pagination -->
    <div class="flex justify-center gap-4 mb-4">
      <button @click="fetchSkills(skills.prev_page_url)" 
              :disabled="!skills.prev_page_url"
              class="px-4 py-2 bg-gray-300 rounded-lg hover:bg-gray-400 disabled:opacity-50 font-bold">
        &lt;
      </button>
      <button @click="fetchSkills(skills.next_page_url)" 
              :disabled="!skills.next_page_url"
              class="px-4 py-2 bg-gray-300 rounded-lg hover:bg-gray-400 disabled:opacity-50 font-bold">
        &gt;
      </button>
    </div>

    <button
      @click="openModal"
      class="px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition"
    >
      Add New Skill
    </button>
  </div>

  <!-- Add Skill Modal -->
  <div
    v-if="isModalOpen"
    class="fixed inset-0 bg-black/20 backdrop-blur-md flex items-center justify-center z-50"
  >
    <div class="bg-white rounded-lg shadow-md p-6 w-96">
      <h3 class="text-xl font-bold mb-4">Add New Skill</h3>
      <form @submit.prevent="addSkill">
        <div class="mb-4">
          <label class="block text-gray-700 mb-2">Skill Name</label>
          <input
            v-model="newSkill.name"
            type="text"
            class="w-full px-3 py-2 border rounded-lg"
            required
          />
        </div>
        <div class="mb-4">
          <label class="block text-gray-700 mb-2">Proficiency Level</label>
          <select
            v-model="newSkill.proficiency_level"
            class="w-full px-3 py-2 border rounded-lg"
            required
          >
            <option value="" disabled>Select Level</option>
            <option>Beginner</option>
            <option>Intermediate</option>
            <option>Advanced</option>
          </select>
        </div>
        <div class="mb-4">
          <label class="block text-gray-700 mb-2">Icon (optional)</label>
          <input
            v-model="newSkill.icon"
            type="text"
            class="w-full px-3 py-2 border rounded-lg"
            placeholder="e.g., fab fa-js"
          />
        </div>

        <div class="flex justify-end">
          <button
            type="button"
            @click="closeModal"
            class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition mr-2"
          >
            Cancel
          </button>
          <button
            type="submit"
            class="px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition"
          >
            Add Skill
          </button>
        </div>
      </form>
    </div>
  </div>

  <!-- Edit Skill Modal -->
  <div
    v-if="isEditModalOpen"
    class="fixed inset-0 bg-black/20 backdrop-blur-md flex items-center justify-center z-50"
  >
    <div class="bg-white rounded-lg shadow-md p-6 w-96">
      <h3 class="text-xl font-bold mb-4">Edit Skill</h3>
      <form @submit.prevent="updateSkill">
        <div class="mb-4">
          <label class="block text-gray-700 mb-2">Skill Name</label>
          <input
            v-model="editSkill.name"
            type="text"
            class="w-full px-3 py-2 border rounded-lg"
            required
          />
        </div>
        <div class="mb-4">
          <label class="block text-gray-700 mb-2">Proficiency Level</label>
          <select
            v-model="editSkill.proficiency_level"
            class="w-full px-3 py-2 border rounded-lg"
            required
          >
            <option value="" disabled>Select Level</option>
            <option>Beginner</option>
            <option>Intermediate</option>
            <option>Advanced</option>
          </select>
        </div>

        <div class="flex justify-end">
          <button
            type="button"
            @click="closeEditModal"
            class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition mr-2"
          >
            Cancel
          </button>
          <button
            type="submit"
            class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition"
          >
            Update Skill
          </button>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import draggable
 from 'vuedraggable';
export default {
  name: "AdminSkills",
  data() {
    return {
      isModalOpen: false,
      isEditModalOpen: false,
      editingSkillId: null,
      skills: {
        data: [],
        current_page: 1,
        next_page_url: null,
        prev_page_url: null,
      },
      newSkill: {
        name: "",
        proficiency_level: "",
        icon: "",
      },
    };
  },
  methods: {
    async fetchSkills(url="/admin/skills") {
      try {
        const response = await fetch(url, {
          headers: {
            Accept: "application/json",
          },
          credentials: "same-origin",
        });
        if (!response.ok) {
          throw new Error("Network response was not ok");
        }
        this.skills = await response.json();
      } catch (error) {
        console.error("Error fetching skills:", error);
      }
    },
    openModal() {
      this.isModalOpen = true;
    },
    closeModal() {
      this.isModalOpen = false;
      this.resetForm();
    },
    resetForm() {
      this.newSkill = { name: "", proficiency_level: "", icon: "" };
    },
    async addSkill() {
      try {
        const token = document
          .querySelector('meta[name="csrf-token"]')
          ?.getAttribute("content");
        const response = await fetch("/admin/skills", {
          method: "POST",
          headers: {
            "X-CSRF-TOKEN": token,
            "Content-Type": "application/json",
            Accept: "application/json",
          },
          body: JSON.stringify(this.newSkill),
          credentials: "same-origin",
        });
        if (!response.ok) {
          throw new Error("Network response was not ok");
        }
        const createdSkill = await response.json();
        this.skills.data.unshift(createdSkill);
        this.closeModal();
        this.resetForm();
      } catch (error) {
        console.error("Error adding skill:", error);
      }
    },
    openEditModal(skill) {
      this.editSkill = { ...skill };
      this.isEditModalOpen = true;
    },
    closeEditModal() {
      this.isEditModalOpen = false;
      this.editingSkillId = null;
      this.resetForm();
    },
    async updateSkill() {
      try {
        const token = document
          .querySelector('meta[name="csrf-token"]')
          ?.getAttribute("content");
        const response = await fetch(`/admin/skills/${this.editSkill.id}`, {
          method: "PUT",
          headers: {
            "X-CSRF-TOKEN": token,
            "Content-Type": "application/json",
            Accept: "application/json",
          },
          body: JSON.stringify(this.editSkill),
          credentials: "same-origin",
        });
        if (!response.ok) {
          throw new Error("Network response was not ok");
        }
        const updatedSkill = await response.json();
        const index = this.skills.data.findIndex((s) => s.id === updatedSkill.id);
        if (index !== -1) {
          this.skills.data.splice(index, 1, updatedSkill);
        }
        this.closeEditModal();
      } catch (error) {
        console.error("Error updating skill:", error);
      }
    },
    async deleteSkill(skillId) {
      const confirmed = confirm("Are you sure you want to delete this skill?");
      if (!confirmed) return;

      try {
        const token = document
          .querySelector('meta[name="csrf-token"]')
          ?.getAttribute("content");
        const response = await fetch(`/admin/skills/${skillId}`, {
          method: "DELETE",
          headers: {
            "X-CSRF-TOKEN": token,
            Accept: "application/json",
          },
          credentials: "same-origin",
        });
        if (response.ok) {
          window.alert("Skill deleted successfully.");
          await this.fetchSkills();
        }
        if (!response.ok) {
          window.alert("Failed to delete skill.");
        }
      } catch (error) {
        window.alert("Error deleting skill:", error);
      }
    },
  },
  mounted() {
    this.fetchSkills();
  },
};
</script>
