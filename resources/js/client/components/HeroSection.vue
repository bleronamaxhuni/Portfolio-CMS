<template>
  <section id="hero" class="relative flex min-h-screen items-center overflow-hidden px-6 pb-20 pt-28 md:px-12">
    <div class="pointer-events-none absolute inset-0 mesh-bg" aria-hidden="true" />
    <div class="mesh-blob mesh-blob-1 pointer-events-none" aria-hidden="true" />
    <div class="mesh-blob mesh-blob-2 pointer-events-none" aria-hidden="true" />
    <div class="pointer-events-none absolute -right-16 bottom-16 h-80 w-80 rounded-full bg-violet-500/20 blur-3xl" aria-hidden="true" />

    <div
      ref="el"
      class="relative z-10 mx-auto grid w-full max-w-6xl items-center gap-14 md:grid-cols-2"
      :class="visible ? 'reveal-visible' : 'reveal-hidden'"
    >
      <div>
        <p class="mb-4 inline-flex items-center gap-2 rounded-full border border-cyan-400/30 bg-cyan-400/10 px-4 py-1.5 text-sm text-cyan-200">
          <span class="relative flex h-2 w-2">
            <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-cyan-400 opacity-75" />
            <span class="relative inline-flex h-2 w-2 rounded-full bg-cyan-400" />
          </span>
          Available for opportunities
        </p>

        <h2 class="flex flex-wrap items-center gap-2 text-xl font-medium text-slate-300 md:text-2xl">
          Hi, I'm
          <span class="gradient-text font-semibold">{{ displayName }}</span>
          <span class="animate-wave inline-block">👋</span>
        </h2>

        <h1 class="mt-4 text-4xl font-extrabold leading-tight tracking-tight text-white md:text-6xl">
          <span class="block">I build</span>
          <span class="gradient-text mt-1 block min-h-[1.2em] transition-all duration-500">{{ currentRole }}</span>
          <span class="mt-1 block text-slate-300">experiences on the web</span>
        </h1>

        <p class="mt-6 max-w-lg text-lg leading-relaxed text-slate-400">
          {{ about?.bio || defaultBio }}
        </p>

        <div class="mt-8 flex flex-wrap gap-4">
          <button
            type="button"
            class="group relative overflow-hidden rounded-xl bg-gradient-to-r from-cyan-500 to-violet-500 px-8 py-3 font-semibold text-slate-950 shadow-lg shadow-cyan-500/25 transition hover:scale-[1.02] hover:shadow-cyan-500/40"
            @click="$emit('scroll-to', 'contact')"
          >
            <span class="relative z-10">Get in touch</span>
            <span class="absolute inset-0 -translate-x-full bg-white/25 transition duration-500 group-hover:translate-x-full" />
          </button>

          <a
            v-if="about?.resume_link"
            :href="about.resume_link"
            target="_blank"
            rel="noopener noreferrer"
            class="rounded-xl border border-white/15 bg-white/5 px-8 py-3 font-semibold text-white backdrop-blur transition hover:border-white/30 hover:bg-white/10"
          >
            Download resume
          </a>
        </div>
      </div>

      <div class="relative flex justify-center">
        <div
          ref="profileRef"
          class="profile-frame group"
          :style="tiltStyle"
          @mousemove="onTilt"
          @mouseleave="resetTilt"
        >
          <div class="profile-radiant-aura" aria-hidden="true" />
          <div class="profile-radiant-ring" aria-hidden="true" />
          <div class="profile-image-shell">
            <div class="profile-image-wrap">
              <img
                v-if="profileSrc"
                :src="profileSrc"
                alt="Profile"
                class="profile-image"
              />
              <div v-else class="profile-image-placeholder" />
              <div class="profile-color-fade" aria-hidden="true" />
              <div class="profile-vignette" aria-hidden="true" />
              <div class="profile-shine" aria-hidden="true" />
            </div>
          </div>
        </div>

        <span
          v-for="(chip, index) in floatingChips"
          :key="chip"
          class="absolute rounded-full border border-white/10 bg-slate-900/85 px-3 py-1.5 text-xs font-medium text-slate-200 shadow-lg backdrop-blur"
          :class="chipPositions[index]"
        >
          {{ chip }}
        </span>
      </div>
    </div>
  </section>
</template>

<script setup>
import { computed, onMounted, onUnmounted, ref } from 'vue'
import { useReveal } from '../composables/useReveal'
import { resolveProfileImage } from '../utils/profileImage'

const props = defineProps({
  about: { type: Object, default: null },
  displayName: { type: String, default: 'Blerona' },
})

defineEmits(['scroll-to'])

const defaultBio =
  'I develop user-friendly interfaces with a focus on usability, performance, and polished interactions.'

const roles = ['Full-Stack', 'Frontend', 'Backend', 'Creative']
const currentRole = ref(roles[0])
let roleTimer = null
let roleIndex = 0

const { el, visible } = useReveal()

const profileSrc = computed(() => resolveProfileImage(props.about))

const floatingChips = ['Vue 3', 'Laravel', 'Tailwind', 'SQL', 'PHP']
const chipPositions = [
  '-left-2 top-6 animate-float-slow',
  '-right-4 top-20 animate-float',
  'bottom-8 left-4 animate-float-slow',
  'bottom-8 right-4 animate-float-slow',
]

const profileRef = ref(null)
const tiltX = ref(0)
const tiltY = ref(0)

const tiltStyle = computed(() => ({
  transform: `perspective(900px) rotateX(${tiltX.value}deg) rotateY(${tiltY.value}deg)`,
}))

function onTilt(event) {
  const rect = event.currentTarget.getBoundingClientRect()
  const x = (event.clientX - rect.left) / rect.width - 0.5
  const y = (event.clientY - rect.top) / rect.height - 0.5
  tiltY.value = x * 10
  tiltX.value = -y * 10
}

function resetTilt() {
  tiltX.value = 0
  tiltY.value = 0
}

onMounted(() => {
  roleTimer = window.setInterval(() => {
    roleIndex = (roleIndex + 1) % roles.length
    currentRole.value = roles[roleIndex]
  }, 2800)
})

onUnmounted(() => {
  if (roleTimer) window.clearInterval(roleTimer)
})
</script>
