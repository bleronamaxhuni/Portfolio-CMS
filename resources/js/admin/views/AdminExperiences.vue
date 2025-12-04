<template>
  <div>
    <!-- Header -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-8 border-t-4 border-red-600">
      <h1 class="text-3xl font-bold text-gray-800 mb-2">Manage Experiences</h1>
      <p class="text-gray-600">Add, edit, or delete your professional experiences</p>
    </div>

    <!-- Experiences List -->
    <div class="bg-white rounded-lg shadow-md p-6">
      <div class="flex justify-between items-center mb-4">
        <h2 class="text-xl font-semibold text-gray-800">Experiences</h2>
        <button
          @click="openModal"
          class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition"
        >
          Add Experience
        </button>
      </div>
      <div v-if="experiences.length === 0" class="text-gray-600">
        No experiences found.
      </div>
      <ul v-else class="space-y-4">
        <li v-for="experience in experiences" :key="experience.id" class="border-b pb-4">
          <div class="flex justify-between items-center">
            <div>
              <h3 class="text-lg font-bold text-gray-800">
                {{ experience.title }} at {{ experience.company }}
              </h3>
              <p class="text-gray-600">
                {{ experience.start_date }} - {{ experience.end_date || "Present" }}
              </p>
              <p class="text-gray-600 mt-2">{{ experience.description }}</p>
            </div>
            <div class="space-x-2">
              <button
                @click="editExperience(experience)"
                class="px-3 py-1 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 transition"
              >
                Edit
              </button>
              <button
                @click="deleteExperience(experience.id)"
                class="px-3 py-1 bg-red-600 text-white rounded-lg hover:bg-red-700 transition"
              >
                Delete
              </button>
            </div>
          </div>
        </li>
      </ul>
    </div>

    <!-- Add/Edit Experience Modal -->
    <div
      v-if="isModalOpen"
      class="fixed inset-0 bg-black/20 backdrop-blur-md flex items-center justify-center z-50"
    >
      <form
        @submit.prevent="isEditMode ? updateExperience() : addExperience()"
        class="bg-white rounded-lg shadow-md p-6 w-96"
      >
        <h3 class="text-xl font-bold mb-4">
          {{ isEditMode ? "Edit Experience" : "Add Experience" }}
        </h3>
        <div class="mb-4">
          <label class="block text-gray-700 mb-2">Position</label>
          <input
            v-model="form.title"
            type="text"
            class="w-full px-3 py-2 border rounded-lg"
            required
          />
        </div>
        <div class="mb-4">
          <label class="block text-gray-700 mb-2">Company</label>
          <input
            v-model="form.company"
            type="text"
            class="w-full px-3 py-2 border rounded-lg"
            required
          />
        </div>
        <div class="mb-4">
          <label class="block text-gray-700 mb-2">Location</label>
          <input
            v-model="form.location"
            type="text"
            class="w-full px-3 py-2 border rounded-lg"
          />
        </div>
        <div class="mb-4">
          <label class="block text-gray-700 mb-2">Start Date</label>
          <input
            v-model="form.start_date"
            type="date"
            class="w-full px-3 py-2 border rounded-lg"
            required
          />
        </div>
        <div class="mb-4">
          <label class="block text-gray-700 mb-2">End Date</label>
          <input
            v-model="form.end_date"
            type="date"
            class="w-full px-3 py-2 border rounded-lg"
          />
        </div>
        <div class="mb-4">
          <label class="block text-gray-700 mb-2">Description</label>
          <textarea
            v-model="form.description"
            class="w-full px-3 py-2 border rounded-lg"
            required
          ></textarea>
        </div>
        <div class="flex justify-end space-x-2">
          <button
            type="button"
            @click="closeModal"
            class="px-4 py-2 bg-gray-300 text-gray-800 rounded-lg hover:bg-gray-400 transition"
          >
            Cancel
          </button>
          <button
            type="submit"
            class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition"
          >
            {{ isEditMode ? "Update" : "Add" }}
          </button>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
export default {
  name: "AdminExperiences",
  data() {
    return {
      experiences: [],
      isModalOpen: false,
      isEditMode: false,
      editingId: null,
      form: {
        title: "",
        company: "",
        location: "",
        start_date: "",
        end_date: "",
        description: "",
      },
    };
  },
  methods: {
    async fetchExperiences() {
      try {
        const res = await fetch("/admin/experiences", {
          headers: { Accept: "application/json" },
          credentials: "same-origin",
        });
        if (res.ok) {
          this.experiences = await res.json();
        } else {
          console.error("Failed to fetch experiences");
        }
      } catch (e) {
        console.error(e);
      }
    },
    openModal() {
      this.isEditMode = false;
      this.editingId = null;
      this.resetForm();
      this.isModalOpen = true;
    },
    closeModal() {
      this.isModalOpen = false;
    },
    resetForm() {
      this.form = {
        title: "",
        company: "",
        location: "",
        start_date: "",
        end_date: "",
        description: "",
      };
    },
    editExperience(exp) {
      this.isEditMode = true;
      this.editingId = exp.id;
      this.form = {
        title: exp.title || "",
        company: exp.company || "",
        location: exp.location || "",
        start_date: exp.start_date || "",
        end_date: exp.end_date || "",
        description: exp.description || "",
      };
      this.isModalOpen = true;
    },
    async addExperience() {
      try {
        const token = document
          .querySelector('meta[name="csrf-token"]')
          ?.getAttribute("content");
        const res = await fetch("/admin/experiences", {
          method: "POST",
          headers: {
            "X-CSRF-TOKEN": token,
            "Content-Type": "application/json",
            Accept: "application/json",
          },
          credentials: "same-origin",
          body: JSON.stringify(this.form),
        });
        if (res.ok) {
          const created = await res.json();
          this.experiences.unshift(created);
          this.closeModal();
        } else {
          console.error("Failed to create experience", res.status);
        }
      } catch (e) {
        console.error(e);
      }
    },
    async updateExperience() {
      if (!this.editingId) return;
      try {
        const token = document
          .querySelector('meta[name="csrf-token"]')
          ?.getAttribute("content");
        const res = await fetch(`/admin/experiences/${this.editingId}`, {
          method: "PUT",
          headers: {
            "X-CSRF-TOKEN": token,
            "Content-Type": "application/json",
            Accept: "application/json",
          },
          credentials: "same-origin",
          body: JSON.stringify(this.form),
        });
        if (res.ok) {
          const updated = await res.json();
          const idx = this.experiences.findIndex((e) => e.id === updated.id);
          if (idx !== -1) this.experiences.splice(idx, 1, updated);
          this.closeModal();
        } else {
          console.error("Failed to update experience", res.status);
        }
      } catch (e) {
        console.error(e);
      }
    },
    async deleteExperience(id) {
      const confirmed = window.confirm("Delete this experience?");
      if (!confirmed) return;
      try {
        const token = document
          .querySelector('meta[name="csrf-token"]')
          ?.getAttribute("content");
        const res = await fetch(`/admin/experiences/${id}`, {
          method: "DELETE",
          headers: { "X-CSRF-TOKEN": token, Accept: "application/json" },
          credentials: "same-origin",
        });
        if (res.ok) {
          this.experiences = this.experiences.filter((e) => e.id !== id);
        } else {
          console.error("Failed to delete experience", res.status);
        }
      } catch (e) {
        console.error(e);
      }
    },
  },
  mounted() {
    this.fetchExperiences();
  },
};
</script>

<style scoped></style>
