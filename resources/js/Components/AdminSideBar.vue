<script setup>
import { Link, usePage } from '@inertiajs/vue3';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import simplebar from 'simplebar-vue';
import { ref, reactive, computed } from 'vue';
import { useElementHover, onClickOutside } from '@vueuse/core';
import AsideMenuList from '@/Components/AsideMenuList.vue';

let menu = reactive({})
menu = computed(() => usePage().props.navigation.menu)

const props = defineProps({
        active: Boolean,
})

const emit = defineEmits(['toggle-side', 'close-sidebar', 'menu-click']);

const isCompact = ref(false);

const elementRef = ref();

const myHoverableElement = ref()
const isHovered = useElementHover(myHoverableElement)

const toggleSidebar = () => {
        isCompact.value = !isCompact.value;
};

const menuClick = (event, item) => {
        emit('menu-click', event, item)
}

const toggleSide = event => {
        emit('toggle-side', event)
}

const closeSidebar = event => {
        emit('close-sidebar', event)
}

onClickOutside(elementRef, closeSidebar)

</script>

<template>
        <div class="nk-sidebar nk-sidebar-fixed is-dark"
                :class="[(isCompact ? 'is-compact' : ''), (isHovered && isCompact ? 'has-hover' : ''), (active ? 'nk-sidebar-active' : '')]"
                data-content="sidebarMenu" ref="elementRef">

                <div class="nk-sidebar-element nk-sidebar-head">
                        <div class="nk-menu-trigger">
                                <a href="#" class="nk-nav-toggle nk-quick-nav-icon d-xl-none" data-target="sidebarMenu"
                                        @click.prevent="toggleSide">
                                        <em class="icon ni ni-arrow-left"></em>
                                </a>
                                <a href="#" class="nk-nav-compact nk-quick-nav-icon d-none d-xl-inline-flex"
                                        :class="isCompact ? 'compact-active' : ''" data-target="sidebarMenu"
                                        @click.prevent="toggleSidebar">
                                        <em class="icon ni ni-menu"></em>
                                </a>
                        </div>
                        <div class="nk-sidebar-brand">
                                <Link href="/" class="logo-link nk-sidebar-logo">
                                <ApplicationLogo class="logo-light logo-img" src="/assets/images/logo.png"
                                        srcset="/assets/images/logo2x.png 2x" alt="logo" />
                                <ApplicationLogo class="logo-dark logo-img" src="/assets/images/logo-dark.png"
                                        srcset="/assets/images/logo-dark2x.png 2x" alt="logo-dark" />
                                </Link>
                        </div>
                </div>

                <div class="nk-sidebar-element nk-sidebar-body" ref="myHoverableElement">
                        <div class="nk-sidebar-content">
                                <simplebar class="nk-sidebar-menu">
                                        <AsideMenuList :menu="menu" @menu-click="menuClick" />
                                </simplebar>
                        </div>
                </div>
        </div>
        <div v-if="active" class="nk-sidebar-overlay" data-target="sidebarMenu"></div>
</template>
