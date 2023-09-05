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
    },
    isColumn: Boolean,
    isSwitch: Boolean,
    disabled: Boolean,
})
const emit = defineEmits(['update:modelValue', 'modal-show'])
const computedValue = computed({
    get: () => props.modelValue,
    set: value => {
        emit('update:modelValue', value)
    }
})
const inputType = computed(() => props.type === 'radio' ? 'radio' : 'checkbox')
</script>

<template>
    <li :class="{'col-12':isColumn}" @click="emit('modal-show')">
        <div class="custom-control" :class="isSwitch ? 'custom-switch':'custom-checkbox'">
            <input v-model="computedValue" :type="inputType" :id="disabled ? '':label" :value="inputValue" class="custom-control-input" :disabled="disabled">
            <label class="custom-control-label" :for="disabled ? '':label">{{ label }}</label>
        </div>
    </li>
</template>