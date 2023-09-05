<script setup>
import { ref, computed, useSlots } from 'vue'
import { mdiClose } from '@mdi/js'
import { colorsBgLight, colorsOutline } from '@/colors.js'

const props = defineProps({
  icon: {
    type: String,
    default: null
  },
  outline: Boolean,
})
</script>

<template>
  <div class="mb-2 px-6 text-green-400 font-bold">
    <slot />
  </div>
</template>
