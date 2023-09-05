<script setup>
import { Link } from "@inertiajs/vue3"
import simplebar from 'simplebar-vue'
import { ref, onUnmounted, onMounted } from "vue"
import { onClickOutside } from '@vueuse/core'

const props = defineProps({
    patient: {
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
                        <div v-if="props.patient.abbr_name" class="user-avatar bg-primary"><span>{{
                            props.patient.abbr_name }}</span>
                        </div>
                        <div class="user-info">
                            <span class="lead-text">{{ props.patient.name
                            }}</span>
                            <span class="sub-text">{{ props.patient.email
                            }}</span>
                        </div>

                    </div>
                </div>
                <div class="card-inner p-0">
                    <ul class="link-list-menu">
                        <li>
                            <Link :class="{ 'active': route().current('patient.edit') }"
                                :href="route('patient.edit', props.patient.id)">
                            <em class="icon ni ni-user-fill-c"></em>
                            <span>Personal Infomation</span>
                            </Link>
                        </li>
                        <li>
                            <Link :class="{ 'active': route().current('respiratory-system.edit') }"
                                :href="route('respiratory-system.edit', props.patient.id)">
                            <em class="icon ni ni-user-alt"></em>
                            <span>Respiratory System</span>
                            </Link>
                        </li>
                        <li>
                            <Link :class="{ 'active': route().current('cardiovascular-system.edit') }"
                                :href="route('cardiovascular-system.edit', props.patient.id)">
                            <em class="icon ni ni-heart"></em>
                            <span>Cardiovascular System</span>
                            </Link>
                        </li>
                        <li>
                            <Link :class="{ 'active': route().current('gastro-intestinal.edit') }"
                                :href="route('gastro-intestinal.edit', props.patient.id)">
                            <em class="icon ni ni-user-fill-c"></em>
                            <span>Gastrointenstinal System</span>
                            </Link>
                        </li>
                        <li>
                            <Link :class="{ 'active': route().current('genito-urinary-system.edit') }"
                                :href="route('genito-urinary-system.edit', props.patient.id)">
                            <em class="icon ni ni-user-fill-c"></em>
                            <span>Genital Urinary System</span>
                            </Link>
                        </li>
                        <li>
                            <Link :class="{ 'active': route().current('central-nervous-system.edit') }"
                                :href="route('central-nervous-system.edit', props.patient.id)">
                            <em class="icon ni ni-user-fill-c"></em>
                            <span>Central Nervous System</span>
                            </Link>
                        </li>
                        <li>
                            <Link :class="{ 'active': route().current('skin-teguments.edit') }"
                                :href="route('skin-teguments.edit', props.patient.id)">
                            <em class="icon ni ni-user-fill-c"></em>
                            <span>Skin And Teguments</span>
                            </Link>
                        </li>
                        <li>
                            <Link :class="{ 'active': route().current('skeletal-system.edit') }"
                                :href="route('skeletal-system.edit', props.patient.id)">
                            <em class="icon ni ni-user"></em>
                            <span>Skeletal System</span>
                            </Link>
                        </li>
                        <li>
                            <Link :class="{ 'active': route().current('sensory-organ.edit') }"
                                :href="route('sensory-organ.edit', props.patient.id)">
                            <em class="icon ni ni-user-fill-c"></em>
                            <span>Sensory Organs</span>
                            </Link>
                        </li>
                        <li>
                            <Link :class="{ 'active': route().current('past-medical-history.edit') }"
                                :href="route('past-medical-history.edit', props.patient.id)">
                            <em class="icon ni ni-history"></em>
                            <span>Past Medical History</span>
                            </Link>
                        </li>
                        <li>
                            <Link :class="{ 'active': route().current('social-history.edit') }"
                                :href="route('social-history.edit', props.patient.id)">
                            <em class="icon ni ni-history"></em>
                            <span>Social History</span>
                            </Link>
                        </li>
                        <li>
                            <Link :class="{ 'active': route().current('family-history.edit') }"
                                :href="route('family-history.edit', props.patient.id)">
                            <em class="icon ni ni-history"></em>
                            <span>Family History</span>
                            </Link>
                        </li>
                        <li>
                            <Link :class="{ 'active': route().current('general-appearance.edit') }"
                                :href="route('general-appearance.edit', props.patient.id)">
                            <em class="icon ni ni-account-setting"></em>
                            <span>General Appearance</span>
                            </Link>
                        </li>
                        <li>
                            <Link :class="{ 'active': route().current('chest-x-ray.edit') }"
                                :href="route('chest-x-ray.edit', props.patient.id)">
                            <em class="icon ni ni-activity"></em>
                            <span>Chest X-Ray</span>
                            </Link>
                        </li>
                        <li>
                            <Link :class="{ 'active': route().current('ecg.edit') }"
                                :href="route('ecg.edit', props.patient.id)">
                            <em class="icon ni ni-activity"></em>
                            <span>ECG</span>
                            </Link>
                        </li>
                        <li>
                            <Link :class="{ 'active': route().current('admin.examination.conclusion') }"
                                :href="route('admin.examination.conclusion', props.patient.id)">
                            <em class="icon ni ni-reports-alt"></em>
                            <span>Conclusions</span>
                            </Link>
                        </li>
                        <li>
                            <Link :class="{ 'active': route().current('lab.report') }"
                                :href="route('lab.report', props.patient.id)">
                            <em class="icon ni ni-reports-alt"></em>
                            <span>Lab Report</span>
                            </Link>
                        </li>
                    </ul>
                </div>
            </simplebar>
        </div>
        <div v-if="asideActive" class="toggle-overlay" data-target="userAside"></div>
    </div>
</template>
