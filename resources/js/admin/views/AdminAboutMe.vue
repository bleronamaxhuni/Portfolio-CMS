<template>
  <div class="bg-white rounded-lg shadow-md p-6">
    <h2 class="text-2xl font-bold text-gray-800 mb-4">About Me</h2>
    <form @submit.prevent="updateAboutMe">
      <div class="mb-4">
        <label class="block text-gray-700 mb-2">Profile Image</label>

        <!-- Circle upload button -->
        <div
          @click="triggerFileUpload"
          class="h-32 w-32 rounded-full border-2 border-dashed border-gray-400 flex items-center justify-center cursor-pointer hover:bg-gray-100 relative"
        >
          <span v-if="!aboutMe.profile_image" class="text-gray-500 text-4xl">+</span>

          <img
            v-else
            :src="
              aboutMe.profile_image.startsWith('blob')
                ? aboutMe.profile_image
                : '/storage/' + aboutMe.profile_image
            "
            class="h-32 w-32 rounded-full object-cover"
          />
        </div>

        <input
          ref="fileInput"
          type="file"
          accept="image/*"
          class="hidden"
          @change="handleProfileImageChange"
        />
      </div>

      <div class="mb-4">
        <label class="block text-gray-700 mb-2" for="bio">Bio</label>
        <textarea
          v-model="aboutMe.bio"
          id="bio"
          class="w-full p-2 border border-gray-300 rounded-lg"
          rows="4"
        ></textarea>
      </div>
      <div class="mb-4">
        <label class="block text-gray-700 mb-2" for="resume_link">Resume Link</label>
        <input
          v-model="aboutMe.resume_link"
          id="resume_link"
          type="text"
          class="w-full p-2 border border-gray-300 rounded-lg"
        />
      </div>
      <div class="flex justify-end">
        <button
          type="submit"
          class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition"
        >
          Update
        </button>
      </div>
    </form>
  </div>
</template>

<script>
export default {
  name: "AdminAboutMe",
  data() {
    return {
      aboutMe: {
        bio: "",
        resume_link: "",
      },
    };
  },
  methods: {
    async fetchAboutMe() {
      try {
        const res = await fetch("/admin/about-me", {
          headers: { Accept: "application/json" },
          credentials: "same-origin",
        });
        if (res.ok) {
          const data = await res.json();
          if (data.length > 0) {
            this.aboutMe = data[0];
          }
        }
      } catch (e) {
        console.error("Error fetching about me:", e);
      }
    },
    async updateAboutMe() {
      try {
        const token = document
          .querySelector('meta[name="csrf-token"]')
          ?.getAttribute("content");

        const method = this.aboutMe.id ? "POST" : "POST";
        const url = this.aboutMe.id
          ? `/admin/about-me/${this.aboutMe.id}`
          : `/admin/about-me`;

        let form = new FormData();
        form.append("bio", this.aboutMe.bio);
        form.append("resume_link", this.aboutMe.resume_link ?? "");

        if (this.aboutMe.profile_image_file) {
          form.append("profile_image", this.aboutMe.profile_image_file);
        }

        if (this.aboutMe.id) {
          form.append("_method", "PUT");
        }

        const res = await fetch(url, {
          method: "POST",
          headers: {
            "X-CSRF-TOKEN": token,
            Accept: "application/json",
          },
          body: form,
        });

        const data = await res.json();
        this.aboutMe = data;

        alert("Saved successfully");
      } catch (e) {
        console.error("Error:", e);
      }
    },
    handleProfileImageChange(event) {
      const file = event.target.files[0];
      this.aboutMe.profile_image_file = file;

      this.aboutMe.profile_image = URL.createObjectURL(file);
    },
    triggerFileUpload() {
      this.$refs.fileInput.click();
    },
  },
  mounted() {
    this.fetchAboutMe();
  },
};
</script>
