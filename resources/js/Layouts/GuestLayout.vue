<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Link } from '@inertiajs/vue3';
import { ref, onMounted, onUnmounted } from 'vue';
import { onClickOutside } from '@vueuse/core'

const isActive= ref(false);

const elementRef = ref();

function close () {
    isActive.value = false;
}

onClickOutside(elementRef, close)

const toggleOverlay = () => {
    isActive.value = !isActive.value;
};

const onWidthChange = () => {
    
    if(window.innerWidth >= 992){
        isActive.value = false;
    }
}

onMounted(() => {
    window.addEventListener('resize', onWidthChange);
    document.body.classList.add('nk-body', 'bg-lighter', 'npc-general', 'pg-auth', 'no-touch', 'nk-nio-theme');
})
onUnmounted(() => {
    window.removeEventListener('resize', onWidthChange);
    document.body.classList.remove('nk-body', 'bg-lighter', 'npc-general', 'pg-auth', 'no-touch', 'nk-nio-theme');
})

</script>

<template>
    <div class="nk-main ">

        <div class="nk-wrap nk-wrap-nosidebar">
            <div class="nk-content ">
                <div class="nk-split nk-split-page nk-split-lg">
                    <div class="nk-split-content nk-block-area nk-block-area-column nk-auth-container bg-white">
                        <div class="absolute-top-right d-lg-none p-3 p-sm-5">
                            <a href="#" class="toggle btn-white btn btn-icon btn-light" data-target="athPromo" @click.prevent="toggleOverlay">
                                <em class="icon ni ni-info"></em>
                            </a>
                        </div>
                        <div class="nk-block nk-block-middle nk-auth-body">
                            <div class="brand-logo pb-5">
                                <Link href="/" class="logo-link">
                                <ApplicationLogo class="logo-light logo-img logo-img-lg" src="/assets/images/logo.png" srcset="/assets/images/logo2x.png 2x" alt="logo"/>
                                <ApplicationLogo class="logo-dark logo-img logo-img-lg" src="/assets/images/logo-dark.png" srcset="/assets/images/logo-dark2x.png 2x" alt="logo-dark"/>
                                </Link>
                            </div>

                            <div>
                                <slot />
                            </div>

                        </div>
                        <div class="nk-block nk-auth-footer">
                            <div class="mt-3">
                                <p>© {{ new Date().getFullYear() }} {{ $page.props.appName }}. All Rights Reserved.</p>
                            </div>
                        </div>
                    </div>
                    <div class="nk-split-content nk-split-stretch bg-lighter d-flex toggle-break-lg toggle-slide toggle-slide-right" :class="isActive ? 'content-active' : ''"
                        data-toggle-body="true" data-content="athPromo" data-toggle-screen="lg" data-toggle-overlay="true" ref="elementRef">
                        <div class="w-100 w-max-550px p-3 p-sm-5 m-auto">
                            <div class="nk-feature nk-feature-center">
                                <div class="nk-feature-img"><img class="round" src="/assets/images/slides/promo-a.png"
                                        srcset="/assets/images/slides/promo-a2x.png 2x" alt=""></div>
                                <div class="nk-feature-content py-4 p-sm-5">
                                    <h4>{{ $page.props.appName }}</h4>
                                    <p>Even if you don’t have sufficient statistics or ratings, we’ve got your back! You will still be able to get plenty of orders any time.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div v-if="isActive" class="toggle-overlay" data-target="athPromo"></div>
                </div>
            </div>
        </div>
    </div>
</template>
