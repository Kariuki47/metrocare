<script setup>
defineProps({
    value: {
        type: String,
    },
});
</script>

<template>
    <label class="form-label" for="email-address">
        {{ value }}
    </label>
</template>
