<script setup>
import { computed } from 'vue'
const props = defineProps({
    name: {
        type: String,
        required: true
    },
    type: {
        type: String,
        default: 'checkbox',
        validator: value => ['checkbox', 'radio', 'switch'].includes(value)
    },
    label: {
        type: String,
        default: null
    },
    modelValue: {
        type: [Array, String, Number, Boolean],
        default: null
    },
    inputValue: {
        type: [String, Number, Boolean],
        required: true
    }
})
const emit = defineEmits(['update:modelValue'])
const computedValue = computed({
    get: () => props.modelValue,
    set: value => {
        emit('update:modelValue', value)
    }
})
const inputType = computed(() => props.type === 'radio' ? 'radio' : 'checkbox')
</script>

<template>
    <li>
        <div class="custom-control custom-checkbox">
            <input v-model="computedValue" :type="inputType" :id="label" :value="inputValue" class="custom-control-input">
            <label class="custom-control-label" :for="label">{{ label }}</label>
        </div>
    </li>
</template>