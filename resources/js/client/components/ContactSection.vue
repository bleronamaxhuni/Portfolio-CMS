<template>
  <section id="contact" class="relative px-6 pb-28 pt-8 md:px-12">
    <div
      ref="el"
      class="mx-auto max-w-3xl"
      :class="visible ? 'reveal-visible' : 'reveal-hidden'"
    >
      <SectionHeading
        eyebrow="Let's talk"
        title="Contact"
        subtitle="Have a project in mind? Send a message and I'll get back to you."
        centered
      />

      <form
        class="mt-10 space-y-4 rounded-3xl border border-white/10 bg-white/[0.03] p-6 backdrop-blur md:p-8"
        @submit.prevent="submit"
      >
        <div
          v-if="feedback.message"
          class="rounded-xl px-4 py-3 text-sm"
          :class="feedback.type === 'success' ? 'bg-emerald-500/15 text-emerald-300' : 'bg-red-500/15 text-red-300'"
        >
          {{ feedback.message }}
        </div>

        <div class="grid gap-4 md:grid-cols-2">
          <label class="block">
            <span class="mb-2 block text-sm font-medium text-slate-300">Name</span>
            <input
              v-model="form.name"
              type="text"
              required
              placeholder="Your name"
              class="w-full rounded-xl border border-white/10 bg-slate-950/50 px-4 py-3 text-white outline-none transition placeholder:text-slate-600 focus:border-cyan-400/50 focus:ring-2 focus:ring-cyan-400/20"
              :disabled="sending"
            />
          </label>
          <label class="block">
            <span class="mb-2 block text-sm font-medium text-slate-300">Email</span>
            <input
              v-model="form.email"
              type="email"
              required
              placeholder="you@example.com"
              class="w-full rounded-xl border border-white/10 bg-slate-950/50 px-4 py-3 text-white outline-none transition placeholder:text-slate-600 focus:border-cyan-400/50 focus:ring-2 focus:ring-cyan-400/20"
              :disabled="sending"
            />
          </label>
        </div>

        <label class="block">
          <span class="mb-2 block text-sm font-medium text-slate-300">Message</span>
          <textarea
            v-model="form.message"
            rows="5"
            required
            placeholder="Tell me about your project..."
            class="w-full resize-none rounded-xl border border-white/10 bg-slate-950/50 px-4 py-3 text-white outline-none transition placeholder:text-slate-600 focus:border-cyan-400/50 focus:ring-2 focus:ring-cyan-400/20"
            :disabled="sending"
          />
        </label>

        <button
          type="submit"
          class="relative w-full overflow-hidden rounded-xl bg-gradient-to-r from-cyan-500 to-violet-500 py-4 font-semibold text-slate-950 transition hover:scale-[1.01] disabled:cursor-not-allowed disabled:opacity-60"
          :disabled="sending"
        >
          <span v-if="!sending">Send message</span>
          <span v-else class="inline-flex items-center justify-center gap-2">
            <span class="h-4 w-4 animate-spin rounded-full border-2 border-slate-900/30 border-t-slate-900" />
            Sending...
          </span>
        </button>
      </form>
    </div>
  </section>
</template>

<script setup>
import { reactive, ref } from 'vue'
import axios from 'axios'
import { useReveal } from '../composables/useReveal'
import SectionHeading from './SectionHeading.vue'

const { el, visible } = useReveal()

const form = reactive({
  name: '',
  email: '',
  message: '',
})

const sending = ref(false)
const feedback = reactive({ type: '', message: '' })

async function submit() {
  sending.value = true
  feedback.type = ''
  feedback.message = ''

  try {
    const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')

    const { data } = await axios.post('/contact', { ...form }, {
      headers: {
        Accept: 'application/json',
        ...(token ? { 'X-CSRF-TOKEN': token } : {}),
      },
    })

    feedback.type = 'success'
    feedback.message = data.message ?? 'Message sent successfully.'
    form.name = ''
    form.email = ''
    form.message = ''
  } catch (err) {
    feedback.type = 'error'
    const data = err.response?.data
    feedback.message =
      data?.message ??
      data?.errors?.name?.[0] ??
      data?.errors?.email?.[0] ??
      data?.errors?.message?.[0] ??
      'Unable to send your message. Please try again.'
  } finally {
    sending.value = false
  }
}
</script>
