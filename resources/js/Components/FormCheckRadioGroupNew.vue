<script setup>
import { computed } from 'vue'
import FormCheckRadioNew from '@/Components/FormCheckRadioNew.vue'
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
  modelValue: {
    type: [Array, String, Number, Boolean],
    default: null
  }
})
const emit = defineEmits(['update:modelValue'])
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
  >
    <FormCheckRadioNew
      v-for="(value, key) in options"
      :key="key"
      v-model="computedValue"
      :type="type"
      :name="name"
      :input-value="value.id"
      :label="value.name"
    />
</ul>
</template>