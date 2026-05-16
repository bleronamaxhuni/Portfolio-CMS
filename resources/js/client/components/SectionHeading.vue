<template>
  <div :class="centered ? 'text-center' : 'text-center md:text-left'">
    <p v-if="eyebrow" class="text-sm font-semibold uppercase tracking-[0.2em] text-cyan-400/90">
      {{ eyebrow }}
    </p>
    <h2 class="mt-2 text-3xl font-bold tracking-tight text-white md:text-4xl">
      {{ title }}
    </h2>
    <p v-if="subtitle" class="mt-3 max-w-2xl text-slate-400 md:mx-0 mx-auto">
      {{ subtitle }}
    </p>
  </div>
</template>

<script setup>
defineProps({
  eyebrow: { type: String, default: '' },
  title: { type: String, required: true },
  subtitle: { type: String, default: '' },
  centered: { type: Boolean, default: false },
})
</script>
