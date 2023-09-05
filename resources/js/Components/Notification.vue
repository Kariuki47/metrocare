<script setup>
import { ref, onUnmounted } from 'vue';

const isShow = ref(true);

const props = defineProps({
  icon: {
    type: String,
    default: null
  },
  color: {
    type: String,
    default: null
  },
  outline: Boolean,
  alertDismissible: Boolean,
  alertFill: Boolean,
})

const close = () => {
  isShow.value = false;
}
</script>

<template>
  <div v-if="isShow" :class="['alert', {'alert-fill': alertFill}, color, {'alert-icon':icon}, {'alert-dismissible':alertDismissible}]">
    <em v-if="icon" :class="['icon ni', icon]"></em>
    <slot />
    <button v-if="alertDismissible" class="close" data-bs-dismiss="alert" @click="close"></button>
  </div>
</template>
