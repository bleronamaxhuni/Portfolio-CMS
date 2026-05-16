<template>
  <header
    class="fixed inset-x-0 top-0 z-50 transition-all duration-300"
    :class="scrolled ? 'py-2' : 'py-4'"
  >
    <nav
      class="mx-auto flex max-w-6xl items-center justify-between rounded-2xl border px-5 py-3 transition-all duration-300"
      :class="scrolled ? 'nav-glass-scrolled shadow-lg shadow-cyan-500/5' : 'nav-glass'"
    >
      <a href="#" class="group flex items-center gap-2" @click.prevent="scrollTo('hero')">
        <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-gradient-to-br from-cyan-400 to-violet-500 text-sm font-bold text-slate-950">
          {{ initials }}
        </span>
        <span class="font-semibold tracking-tight text-white group-hover:text-cyan-300 transition-colors">
          {{ brandName }}
        </span>
      </a>

      <ul class="hidden items-center gap-1 md:flex">
        <li v-for="item in navItems" :key="item.id">
          <button
            type="button"
            class="relative rounded-lg px-4 py-2 text-sm font-medium transition-colors"
            :class="activeId === item.id ? 'text-cyan-300' : 'text-slate-300 hover:text-white'"
            @click="scrollTo(item.id)"
          >
            {{ item.label }}
            <span
              v-if="activeId === item.id"
              class="absolute inset-x-2 -bottom-0.5 h-0.5 rounded-full bg-gradient-to-r from-cyan-400 to-violet-400"
            />
          </button>
        </li>
      </ul>

      <button
        type="button"
        class="inline-flex h-10 w-10 items-center justify-center rounded-xl border border-white/10 text-slate-200 md:hidden"
        aria-label="Toggle menu"
        @click="menuOpen = !menuOpen"
      >
        <span v-if="!menuOpen" class="text-xl">☰</span>
        <span v-else class="text-xl">✕</span>
      </button>
    </nav>

    <div
      v-if="menuOpen"
      class="mx-auto mt-2 max-w-6xl overflow-hidden rounded-2xl border border-white/10 nav-glass-scrolled p-3 md:hidden"
    >
      <button
        v-for="item in navItems"
        :key="item.id"
        type="button"
        class="block w-full rounded-xl px-4 py-3 text-left text-sm font-medium transition-colors"
        :class="activeId === item.id ? 'bg-white/10 text-cyan-300' : 'text-slate-300 hover:bg-white/5 hover:text-white'"
        @click="scrollTo(item.id); menuOpen = false"
      >
        {{ item.label }}
      </button>
    </div>
  </header>
</template>

<script setup>
import { computed, onMounted, onUnmounted, ref } from 'vue'

const props = defineProps({
  activeId: { type: String, default: 'hero' },
  brandName: { type: String, default: 'Portfolio' },
})

const navItems = [
  { id: 'experiences', label: 'Experience' },
  { id: 'skills', label: 'Skills' },
  { id: 'projects', label: 'Projects' },
  { id: 'contact', label: 'Contact' },
]

const scrolled = ref(false)
const menuOpen = ref(false)

const initials = computed(() =>
  props.brandName
    .split(' ')
    .map((w) => w[0])
    .join('')
    .slice(0, 2)
    .toUpperCase(),
)

function onScroll() {
  scrolled.value = window.scrollY > 24
}

function scrollTo(id) {
  const el = document.getElementById(id)
  if (el) el.scrollIntoView({ behavior: 'smooth', block: 'start' })
}

onMounted(() => window.addEventListener('scroll', onScroll, { passive: true }))
onUnmounted(() => window.removeEventListener('scroll', onScroll))
</script>
