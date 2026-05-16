<template>
  <section id="skills" class="relative px-6 py-24 md:px-12">
    <div
      ref="el"
      class="mx-auto max-w-6xl"
      :class="visible ? 'reveal-visible' : 'reveal-hidden'"
    >
      <SectionHeading
        eyebrow="Toolkit"
        title="Skills"
        subtitle="Technologies I use to ship reliable, polished products."
      />

      <div class="mt-12 grid gap-4 sm:grid-cols-2">
        <div
          v-for="(skill, index) in skills"
          :key="skill.id"
          class="group rounded-2xl border border-white/10 bg-white/[0.03] p-5 backdrop-blur transition hover:border-violet-400/30 hover:bg-white/[0.06]"
          :style="{ transitionDelay: `${index * 60}ms` }"
          @mouseenter="hoveredId = skill.id"
          @mouseleave="hoveredId = null"
        >
          <div class="mb-3 flex items-center justify-between gap-3">
            <span class="font-semibold text-white">{{ skill.name }}</span>
            <span class="text-xs font-medium text-slate-400">
              {{ skill.proficiency_level || 'Proficient' }}
            </span>
          </div>
          <div class="h-2 overflow-hidden rounded-full bg-slate-800">
            <div
              class="h-full rounded-full bg-gradient-to-r from-cyan-400 to-violet-500 transition-all duration-1000 ease-out"
              :style="{ width: barWidth(skill) }"
            />
          </div>
        </div>

        <p
          v-if="!skills.length"
          class="col-span-full rounded-2xl border border-dashed border-white/10 p-10 text-center text-slate-500"
        >
          No skills added yet.
        </p>
      </div>

      <div v-if="skills.length" class="mt-10 flex flex-wrap justify-center gap-3">
        <span
          v-for="skill in skills"
          :key="`chip-${skill.id}`"
          class="rounded-full border border-white/10 bg-white/5 px-4 py-2 text-sm text-slate-300 transition hover:-translate-y-0.5 hover:border-cyan-400/30 hover:text-white"
        >
          {{ skill.name }}
        </span>
      </div>
    </div>
  </section>
</template>

<script setup>
import { ref, watch } from 'vue'
import { useReveal } from '../composables/useReveal'
import { proficiencyPercent } from '../utils/proficiency'
import SectionHeading from './SectionHeading.vue'

defineProps({
  skills: { type: Array, default: () => [] },
})

const { el, visible } = useReveal()
const hoveredId = ref(null)
const barsAnimated = ref(false)

watch(visible, (isVisible) => {
  if (isVisible) barsAnimated.value = true
})

function barWidth(skill) {
  const percent = proficiencyPercent(skill.proficiency_level)
  const hoverBoost = hoveredId.value === skill.id ? 8 : 0
  const target = Math.min(percent + hoverBoost, 100)
  return `${barsAnimated.value ? target : 0}%`
}
</script>
