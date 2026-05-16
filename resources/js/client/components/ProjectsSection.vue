<template>
  <section id="projects" class="relative px-6 py-24 md:px-12">
    <div
      ref="el"
      class="mx-auto max-w-6xl"
      :class="visible ? 'reveal-visible' : 'reveal-hidden'"
    >
      <SectionHeading
        eyebrow="Work"
        title="Projects"
        subtitle="Selected builds — from concept to deployment."
      />

      <div class="mt-12 grid gap-6 md:grid-cols-2 lg:grid-cols-3">
        <article
          v-for="(project, index) in projects"
          :key="project.id"
          class="project-card group flex flex-col rounded-2xl border border-white/10 bg-white/[0.03] p-6 backdrop-blur transition duration-300 hover:-translate-y-1 hover:border-cyan-400/25"
          :style="{ transitionDelay: `${index * 70}ms` }"
        >
          <div class="mb-4 flex items-start justify-between gap-2">
            <h3 class="text-lg font-bold text-white group-hover:text-cyan-300 transition-colors">
              {{ project.title }}
            </h3>
            <span
              v-if="project.status"
              class="shrink-0 rounded-full px-2.5 py-0.5 text-[10px] font-semibold uppercase tracking-wide"
              :class="statusClass(project.status)"
            >
              {{ project.status }}
            </span>
          </div>

          <p v-if="project.category" class="mb-2 text-xs font-medium uppercase tracking-wider text-violet-300/80">
            {{ project.category }}
          </p>

          <p class="flex-1 text-sm leading-relaxed text-slate-400">
            {{ project.description }}
          </p>

          <div v-if="project.repository_link || project.link" class="mt-5 flex flex-wrap gap-3">
            <a
              v-if="project.repository_link"
              :href="project.repository_link"
              target="_blank"
              rel="noopener noreferrer"
              class="text-sm font-medium text-cyan-300 hover:text-cyan-200 transition"
            >
              GitHub →
            </a>
            <a
              v-if="project.link"
              :href="project.link"
              target="_blank"
              rel="noopener noreferrer"
              class="text-sm font-medium text-violet-300 hover:text-violet-200 transition"
            >
              Live demo →
            </a>
          </div>
        </article>

        <p
          v-if="!projects.length"
          class="col-span-full rounded-2xl border border-dashed border-white/10 p-10 text-center text-slate-500"
        >
          No projects added yet.
        </p>
      </div>
    </div>
  </section>
</template>

<script setup>
import { useReveal } from '../composables/useReveal'
import SectionHeading from './SectionHeading.vue'

defineProps({
  projects: { type: Array, default: () => [] },
})

const { el, visible } = useReveal()

function statusClass(status) {
  const map = {
    completed: 'bg-emerald-500/15 text-emerald-300',
    ongoing: 'bg-cyan-500/15 text-cyan-300',
    paused: 'bg-amber-500/15 text-amber-300',
  }
  return map[status] ?? 'bg-slate-500/15 text-slate-300'
}
</script>
