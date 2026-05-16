import { ref, onMounted, onUnmounted } from 'vue'

export function useReveal(options = {}) {
    const el = ref(null)
    const visible = ref(false)

    let observer

    onMounted(() => {
        observer = new IntersectionObserver(
            ([entry]) => {
                if (entry.isIntersecting) {
                    visible.value = true
                    observer?.disconnect()
                }
            },
            { threshold: 0.12, rootMargin: '0px 0px -40px 0px', ...options },
        )

        if (el.value) observer.observe(el.value)
    })

    onUnmounted(() => observer?.disconnect())

    return { el, visible }
}
