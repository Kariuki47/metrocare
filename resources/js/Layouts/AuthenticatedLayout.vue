<script setup>
import { ref, onMounted, onUnmounted } from 'vue';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import { Link } from '@inertiajs/vue3';
import AdminSideBar from '@/Components/AdminSideBar.vue'
import { initFlowbite } from 'flowbite'

const sidebarActive = ref(false);

function close () {
    sidebarActive.value = false;
    document.body.classList.remove('nav-shown');
}

const emit = defineEmits(['toggle-side', 'close-sidebar']);

const toggleSidebar = () => {
    sidebarActive.value = !sidebarActive.value;
    if(sidebarActive.value){
        document.body.classList.add('nav-shown');
    }else{
        document.body.classList.remove('nav-shown');
    }
};

// initialize components based on data attribute selectors
onMounted(() => {
    initFlowbite();
    document.body.classList.add('nk-body', 'bg-lighter', 'npc-general', 'has-sidebar', 'no-touch', 'nk-nio-theme');
})

onUnmounted(() => {
    document.body.classList.remove('nk-body', 'bg-lighter', 'npc-general', 'has-sidebar', 'no-touch', 'nk-nio-theme', 'nav-shown');
})

</script>

<template>
    <div class="nk-main ">
            <AdminSideBar :active="sidebarActive" @toggle-side="toggleSidebar" @close-sidebar="close()"/>
        
        <div class="nk-wrap">
            <div class="nk-header nk-header-fixed is-dark">
                <div class="container-fluid">
                    <div class="nk-header-wrap">
                        <div class="nk-menu-trigger d-xl-none ms-n1">
                            <a href="#" class="nk-nav-toggle nk-quick-nav-icon" data-target="sidebarMenu" @click.prevent="toggleSidebar" :class="sidebarActive ? 'toggle-active' : ''">
                                <em class="icon ni ni-menu"></em>
                            </a>
                        </div>
                        <div class="nk-header-brand d-xl-none" style="line-height: 0;">
                            <Link href="/" class="logo-link">
                                <ApplicationLogo class="logo-light logo-img" src="/assets/images/logo.png"
                                        srcset="/assets/images/logo2x.png 2x" alt="logo" />
                                <ApplicationLogo class="logo-dark logo-img" src="/assets/images/logo-dark.png"
                                        srcset="/assets/images/logo-dark2x.png 2x" alt="logo-dark" />
                            </Link>
                        </div>
                        <div class="nk-header-tools">
                            <ul class="nk-quick-nav">
                                <li class="dropdown user-dropdown">
                                    <a href="#" class="dropdown-toggle" data-dropdown-toggle="dropdown"
                                        data-dropdown-placement="bottom-end" aria-expanded="false" @click.prevent>
                                        <div class="user-toggle">
                                            <div class="user-avatar sm"><em class="icon ni ni-user-alt"></em></div>
                                            <div class="user-info d-none d-md-block">
                                                <div class="user-status">{{ $page.props.auth.user.role_name
                                                }}</div>
                                                <div class="user-name dropdown-indicator">{{
                                                    $page.props.auth.user.name }}
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-md dropdown-menu-end dropdown-menu-s1"
                                        id="dropdown">
                                        <div class="dropdown-inner user-card-wrap bg-lighter d-none d-md-block">
                                            <div class="user-card">
                                                <div v-if="$page.props.auth.user.abbr_name" class="user-avatar"><span>{{ $page.props.auth.user.abbr_name }}</span>
                                                </div>
                                                <div class="user-info"><span class="lead-text">{{ $page.props.auth.user.name
                                                }}</span><span class="sub-text">{{ $page.props.auth.user.email }}</span></div>
                                            </div>
                                        </div>
                                        <div class="dropdown-inner">
                                            <ul class="link-list">
                                                <li>
                                                    <Link :href="route('profile.edit')">
                                                    <em class="icon ni ni-user-alt"></em>
                                                    <span>View Profile</span>
                                                    </Link>
                                                </li>
                                                <li>
                                                    <Link :href="route('settings.sessions')">
                                                        <em class="icon ni ni-activity-alt"></em>
                                                        <span>Login Activity</span>
                                                    </Link>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="dropdown-inner">
                                            <ul class="link-list">
                                                <li>
                                                    <DropdownLink :href="route('logout')" method="post" as="button" class="btn w-100">
                                                        <em class="icon ni ni-signout"></em>
                                                        <span>Sign out</span>
                                                    </DropdownLink>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="nk-content">
                <slot />
            </div>
            <div class="nk-footer">
                <div class="container-fluid">
                    <div class="nk-footer-wrap">
                        <div class="nk-footer-copyright"> © {{ new Date().getFullYear() }} {{ $page.props.appName }}.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
