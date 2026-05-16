<template>
  <div class="portfolio-page min-h-screen bg-[#0b0f19] text-slate-200 antialiased">
    <PortfolioNavbar :active-id="activeId" :brand-name="displayName" />

    <div v-if="loading" class="flex min-h-screen items-center justify-center">
      <div class="flex flex-col items-center gap-4">
        <div class="h-12 w-12 animate-spin rounded-full border-2 border-cyan-400/30 border-t-cyan-400" />
        <p class="text-sm text-slate-400">Loading portfolio...</p>
      </div>
    </div>

    <div v-else-if="error" class="flex min-h-screen items-center justify-center px-6">
      <div class="max-w-md rounded-2xl border border-red-500/30 bg-red-500/10 p-8 text-center">
        <p class="text-red-300">{{ error }}</p>
        <button
          type="button"
          class="mt-4 rounded-lg bg-white/10 px-4 py-2 text-sm font-medium hover:bg-white/15"
          @click="loadPortfolio"
        >
          Retry
        </button>
      </div>
    </div>

    <template v-else>
      <HeroSection
        :about="about"
        :display-name="displayName"
        @scroll-to="scrollToSection"
      />
      <ExperiencesSection :experiences="experiences" />
      <SkillsSection :skills="skills" />
      <ProjectsSection :projects="projects" />
      <ContactSection />

      <footer class="border-t border-white/5 py-8 text-center text-sm text-slate-500">
        © {{ year }} {{ displayName }}. Built with Laravel & Vue.
      </footer>

      <button
        v-show="showBackToTop"
        type="button"
        class="fixed bottom-6 right-6 z-40 flex h-11 w-11 items-center justify-center rounded-full border border-white/10 bg-slate-900/90 text-white shadow-lg backdrop-blur transition hover:-translate-y-0.5 hover:border-cyan-400/40"
        aria-label="Back to top"
        @click="scrollToSection('hero')"
      >
        ↑
      </button>
    </template>
  </div>
</template>

<script setup>
import { computed, onMounted, onUnmounted, ref } from 'vue'
import axios from 'axios'
import PortfolioNavbar from './components/PortfolioNavbar.vue'
import HeroSection from './components/HeroSection.vue'
import ExperiencesSection from './components/ExperiencesSection.vue'
import SkillsSection from './components/SkillsSection.vue'
import ProjectsSection from './components/ProjectsSection.vue'
import ContactSection from './components/ContactSection.vue'
import { useScrollSpy } from './composables/useScrollSpy'

const props = defineProps({
  appName: { type: String, default: 'Portfolio' },
})

const loading = ref(true)
const error = ref('')
const about = ref(null)
const experiences = ref([])
const skills = ref([])
const projects = ref([])

const sectionIds = ['hero', 'experiences', 'skills', 'projects', 'contact']
const { activeId } = useScrollSpy(sectionIds)

const displayName = computed(() => {
  if (about.value?.name) return about.value.name
  return props.appName !== 'Laravel' ? props.appName : 'Blerona'
})

const year = new Date().getFullYear()
const showBackToTop = ref(false)

async function loadPortfolio() {
  loading.value = true
  error.value = ''

  try {
    const { data } = await axios.get('/api/portfolio')
    about.value = data.about
    experiences.value = data.experiences ?? []
    skills.value = data.skills ?? []
    projects.value = data.projects ?? []
  } catch {
    error.value = 'Could not load portfolio data. Please refresh the page.'
  } finally {
    loading.value = false
  }
}

function scrollToSection(id) {
  const el = document.getElementById(id)
  if (el) el.scrollIntoView({ behavior: 'smooth', block: 'start' })
}

function onScroll() {
  showBackToTop.value = window.scrollY > 480
}

onMounted(() => {
  loadPortfolio()
  window.addEventListener('scroll', onScroll, { passive: true })
  onScroll()

  if (window.location.hash) {
    const id = window.location.hash.replace('#', '')
    setTimeout(() => scrollToSection(id), 400)
  }
})

onUnmounted(() => window.removeEventListener('scroll', onScroll))
</script>
