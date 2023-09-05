<script setup>
import { Link } from "@inertiajs/vue3"
import simplebar from 'simplebar-vue'
import { ref, onUnmounted, onMounted } from "vue"
import { onClickOutside } from '@vueuse/core'

const props = defineProps({
    user: {
        type: Object,
        default: () => ({}),
    },
    title: {
        type: String,
        default: null,
    },
    description: {
        type: String,
        default: null,
    },
})


const asideActive = ref(false);
const elementRef = ref();

function close() {
    asideActive.value = false;
    document.body.classList.remove('toggle-shown');
}

onClickOutside(elementRef, close)

const toggleAsideBar = () => {
    asideActive.value = !asideActive.value;
    document.body.classList.add('toggle-shown')
};

const onWidthChange = () => {

    if (window.innerWidth >= 992) {
        asideActive.value = false;
        document.body.classList.remove('toggle-shown');
    }
}

onUnmounted(() => {
    document.body.classList.remove('toggle-shown');
    window.removeEventListener('resize', onWidthChange);
});

onMounted(() => {
    window.addEventListener('resize', onWidthChange);
})
</script>

<template>
    <div class="card-aside-wrap">
        <div class="card-inner card-inner-lg">
            <div class="nk-block-head nk-block-head-lg">
                <div class="nk-block-between">
                    <div class="nk-block-head-content">
                        <h4 class="nk-block-title">{{ title }}</h4>
                        <div class="nk-block-des">
                            <p> {{ description }} </p>
                        </div>
                    </div>
                    <div class="nk-block-head-content align-self-start d-lg-none">
                        <a href="#" class="toggle btn btn-icon btn-trigger mt-n1" :class="{ 'active': asideActive }"
                            data-target="userAside" @click.prevent="toggleAsideBar"><em
                                class="icon ni ni-menu-alt-r"></em></a>
                    </div>
                </div>
            </div>
            <slot />
        </div>
        <div class="card-aside card-aside-left user-aside toggle-slide toggle-slide-left toggle-break-lg toggle-screen-lg"
            :class="{ 'content-active': asideActive }" ref="elementRef">
            <simplebar class="card-inner-group">
                <div class="card-inner">
                    <div class="user-card">
                        <div v-if="props.user.abbr_name" class="user-avatar bg-primary"><span>{{
                            props.user.abbr_name }}</span>
                        </div>
                        <div class="user-info">
                            <span class="lead-text">{{ props.user.name
                            }}</span>
                            <span class="sub-text">{{ props.user.email
                            }}</span>
                        </div>

                    </div>
                </div>
                <div class="card-inner p-0">
                    <ul class="link-list-menu">
                        <li>
                            <Link :class="{ 'active': route().current('profile.edit') }" :href="route('profile.edit')">
                            <em class="icon ni ni-user-fill-c"></em>
                            <span>Personal Infomation</span>
                            </Link>
                        </li>
                        <li>
                            <Link :class="{ 'active': route().current('account.settings.edit') }"
                                :href="route('account.settings.edit')">
                            <em class="icon ni ni-lock-alt-fill"></em>
                            <span>Account Settings</span>
                            </Link>
                        </li>
                        <li>
                            <Link :class="{ 'active': route().current('settings.sessions') }"
                                :href="route('settings.sessions')">
                            <em class="icon ni ni-activity"></em>
                            <span>Sessions</span>
                            </Link>
                        </li>
                        <li>
                            <Link :class="{ 'active': route().current('settings.two-factor') }"
                                :href="route('settings.two-factor')">
                            <em class="icon ni ni-scan"></em>
                            <span>Two-Factor Authentication</span>
                            </Link>
                        </li>
                    </ul>
                </div>
            </simplebar>
        </div>
        <div v-if="asideActive" class="toggle-overlay" data-target="userAside"></div>
    </div>
</template>
