<script setup>
import { containerMaxW } from '@/config.js'
</script>

<template>
    <section class="py-12">
        <div  :class="containerMaxW">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <slot />
            </div>
        </div>
    </section>
</template>