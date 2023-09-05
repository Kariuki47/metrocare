<script setup>

const props = defineProps({
    label: {
        type: String,
        default: null
    },
})
</script>

<template>
    <div class="nk-block">
        <div class="text-center x-muted">
            <img class="mb-3" src="/assets/images/no_results.png" style="width: 15%;display:inline-block;">
            <h6 class="text-dark title mb-3">No {{ label }} to show</h6>
        </div>
    </div>
</template>