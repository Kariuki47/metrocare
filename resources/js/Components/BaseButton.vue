<script setup>
import { computed } from 'vue'
import { Link } from '@inertiajs/vue3'
import { getButtonColor } from '@/colors.js'
import BaseIcon from '@/Components/BaseIcon.vue'

const props = defineProps({
  label: {
    type: [String, Number],
    default: null
  },
  icon: {
    type: String,
    default: null
  },
  href: {
    type: String,
    default: null
  },
  target: {
    type: String,
    default: null
  },
  routeName: {
    type: String,
    default: null
  },
  type: {
    type: String,
    default: null
  },
  color: {
    type: String,
    default: 'white'
  },
  as: {
    type: String,
    default: null
  },
  small: Boolean,
  right: Boolean,
  outline: Boolean,
  active: Boolean,
  disabled: Boolean,
  roundedFull: Boolean
})

const is = computed(() => {
  if (props.as) {
    return props.as
  }

  if (props.routeName) {
    return Link
  }

  if (props.href) {
    return 'a'
  }

  return 'button'
})

const computedType = computed(() => {
  if (is.value === 'button') {
    return props.type ?? 'button'
  }

  return null
})

const componentClass = computed(() => {
  const base = [
    'inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150',
    //'cursor-pointer',
    //'justify-center',
    //'items-center',
    //'whitespace-nowrap',
    //'focus:outline-none',
    //'transition-colors',
    //'focus:ring',
    //'duration-150',
    //'border',
    //props.roundedFull ? 'rounded-full' : 'rounded',
    //props.active ? 'ring ring-black dark:ring-white' : 'ring-blue-700',
    //getButtonColor(props.color, props.outline, !props.disabled)
  ]

  if (props.right) {
    base.push(
      'sm:float-right sm:my-4',
    )
  } /*else {
    base.push(
      'py-2',
      props.roundedFull ? 'px-6' : 'px-3'
    )
  }*/


  if (props.disabled) {
    base.push('cursor-not-allowed', props.outline ? 'opacity-50' : 'opacity-70')
  }

  return base
})
</script>

<template>
  <component
    :is="is"
    :href="routeName ? routeName : href"
    :type="computedType"
    :target="target"
    :disabled="disabled"
  >
    <BaseIcon
      v-if="icon"
      :path="icon"
    />
    <span
      v-if="label"
    >{{ label }}</span>
  </component>
</template>
