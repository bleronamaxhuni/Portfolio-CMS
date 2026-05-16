<template>
  <section id="experiences" class="relative px-6 py-24 md:px-12">
    <div
      ref="el"
      class="mx-auto max-w-6xl"
      :class="visible ? 'reveal-visible' : 'reveal-hidden'"
    >
      <SectionHeading
        eyebrow="Career"
        title="Experience"
        subtitle="Roles and milestones that shaped how I build products."
      />

      <div class="mt-12 space-y-6">
        <article
          v-for="(exp, index) in experiences"
          :key="exp.id"
          :class="[
            'group relative overflow-hidden rounded-2xl border p-6 backdrop-blur transition duration-300 md:p-8',
            isCurrent(exp)
              ? 'experience-card-active border-cyan-400/40 bg-gradient-to-br from-cyan-500/10 via-white/[0.05] to-violet-500/10 shadow-lg shadow-cyan-500/10 hover:-translate-y-1 hover:border-cyan-400/60 hover:shadow-cyan-500/20'
              : 'border-white/10 bg-white/[0.03] hover:-translate-y-1 hover:border-cyan-400/30 hover:bg-white/[0.06]',
          ]"
          :style="{ transitionDelay: `${index * 80}ms` }"
        >
          <div
            :class="[
              'absolute left-0 top-0 h-full w-1 bg-gradient-to-b from-cyan-400 to-violet-500 transition',
              isCurrent(exp) ? 'opacity-100' : 'opacity-0 group-hover:opacity-100',
            ]"
          />

          <div class="flex flex-wrap items-start justify-between gap-4">
            <div>
              <h3 class="text-xl font-bold text-white">{{ exp.title }}</h3>
              <p :class="['mt-1 font-medium', isCurrent(exp) ? 'text-cyan-200' : 'text-cyan-300']">
                {{ exp.company }}
              </p>
              <p v-if="exp.location" class="mt-1 text-sm text-slate-500">{{ exp.location }}</p>
            </div>
            <p
              v-if="dateRange(exp) || isCurrent(exp)"
              :class="[
                'rounded-full border px-3 py-1 text-xs font-medium',
                isCurrent(exp)
                  ? 'border-cyan-400/30 bg-cyan-500/10 text-cyan-100'
                  : 'border-white/10 bg-white/5 text-slate-300',
              ]"
            >
              <template v-if="isCurrent(exp)">
                {{ exp.start_date ? formatDate(exp.start_date) : '' }}
                <span class="text-emerald-300">— Present</span>
              </template>
              <template v-else>{{ dateRange(exp) }}</template>
            </p>
          </div>
          <p :class="['mt-4 leading-relaxed', isCurrent(exp) ? 'text-slate-300' : 'text-slate-400']">
            {{ exp.description }}
          </p>
        </article>

        <p v-if="!experiences.length" class="rounded-2xl border border-dashed border-white/10 p-10 text-center text-slate-500">
          No experiences added yet.
        </p>
      </div>
    </div>
  </section>
</template>

<script setup>
import { useReveal } from '../composables/useReveal'
import SectionHeading from './SectionHeading.vue'

defineProps({
  experiences: { type: Array, default: () => [] },
})

const { el, visible } = useReveal()

function isCurrent(exp) {
  return !exp.end_date
}

function dateRange(exp) {
  if (!exp.start_date && !exp.end_date) return ''
  const start = exp.start_date ? formatDate(exp.start_date) : ''
  const end = exp.end_date ? formatDate(exp.end_date) : 'Present'
  if (!start) return end
  return `${start} — ${end}`
}

function formatDate(value) {
  const d = new Date(value)
  if (Number.isNaN(d.getTime())) return value
  return d.toLocaleDateString(undefined, { month: 'short', year: 'numeric' })
}
</script>
