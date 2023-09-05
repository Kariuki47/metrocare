<script setup>
import { onMounted, onUnmounted } from 'vue';

onMounted(() => {
    document.body.classList.add('nk-body', 'bg-lighter', 'npc-general', 'pg-auth', 'no-touch', 'nk-nio-theme');
})
onUnmounted(() => {
    document.body.classList.remove('nk-body', 'bg-lighter', 'npc-general', 'pg-auth', 'no-touch', 'nk-nio-theme');
})

</script>

<template>
    <div class="nk-main ">

        <div class="nk-wrap nk-wrap-nosidebar">
            <div class="nk-content ">
                <slot />
            </div>
        </div>
    </div>
</template>
