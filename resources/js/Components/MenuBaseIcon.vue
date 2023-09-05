<script setup>

const props = defineProps({
  path: {
    type: String,
    required: true
  },
  w: {
    type: String,
    default: 'w-6'
  },
  h: {
    type: String,
    default: 'h-6'
  },
  size: {
    type: [String, Number],
    default: 16
  }
})

</script>

<template>
  <span>
    <em class="icon ni" :class="path"></em>
  </span>
</template>
