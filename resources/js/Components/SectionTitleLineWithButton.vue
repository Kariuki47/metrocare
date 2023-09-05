<script setup>
import { useSlots, computed } from 'vue'
import { Link } from '@inertiajs/vue3'

defineProps({
  icon: {
    type: String,
    default: null
  },
  title: {
    type: String,
    required: true
  },
  main: Boolean
})

const hasSlot = computed(() => useSlots().default)
</script>

<template>
  <div class="px-6">
    <h1
      class="inline-block text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight dark:text-slate-200 py-4 block sm:inline-block flex sm:float-left">
      {{ title }}
    </h1>
    <slot v-if="hasSlot" />
    <Link 
      v-else 
      :href="route('permission.index')"
      class="no-underline hover:underline text-cyan-600 dark:text-cyan-400"> &lt;&lt; Back to all permission
    </Link>
  </div>
</template>
