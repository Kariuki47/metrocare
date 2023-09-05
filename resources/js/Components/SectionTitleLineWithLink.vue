<script setup>
import { useSlots, computed } from 'vue'

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
  <div class="px-6 py-4">
    <slot v-if="hasSlot" />
  </div>
</template>
