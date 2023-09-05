<script setup>
import { computed } from 'vue'
import FormCheckRadios from '@/Components/FormCheckRadios.vue'
const props = defineProps({
  options: {
    type: Object,
    default: () => {}
  },
  name: {
    type: String,
    required: true
  },
  type: {
    type: String,
    default: 'checkbox',
    validator: value => ['checkbox', 'radio', 'switch'].includes(value)
  },
  componentClass: {
    type: String,
    default: null
  },
  isColumn: Boolean,
  isSwitch: Boolean,
  disabled: Boolean,
  modelValue: {
    type: [Array, String, Number, Boolean],
    default: null
  }
})
const emit = defineEmits(['update:modelValue', 'modal-show'])
const computedValue = computed({
  get: () => props.modelValue,
  set: value => {
    emit('update:modelValue', value)
  }
})
</script>

<template>
  <ul
    class="custom-control-group g-3 align-center"
    :class="{'row':isColumn}"
  >
    <FormCheckRadios
      v-for="(value, key) in options"
      :key="key"
      v-model="computedValue"
      :type="type"
      :name="name"
      :input-value="key"
      :label="value"
      :is-column="isColumn"
      :is-switch="isSwitch"
      :disabled="disabled"
      @modal-show="emit('modal-show')"
    />
</ul>
</template>