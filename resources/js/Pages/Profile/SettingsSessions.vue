<script setup>
import { ref } from "vue"
import { Head, useForm, usePage } from '@inertiajs/vue3';
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue"
import FormField from '@/Components/FormField.vue'
import Modal from "@/Components/Modal.vue"
import Notification from "@/Components/Notification.vue"
import ProfileCardAside from "@/Components/ProfileCardAside.vue"

const props = defineProps({
    sessions: {
        type: Object,
        default: () => ({}),
    },
})

const user = usePage().props.auth.user;

const form = useForm({
    password: '',
});

const modalRef = ref();
const passwordInput = ref(null);

function showModal() {
    modalRef.value.showModal();
}

function closeModal() {
    modalRef.value.closeModal();
    form.reset();
}

const submitForm = () => {
    form.delete(route('other-browser-sessions.destroy'), {
        preserveScroll: true,
        onSuccess: () => closeModal(),
        onError: () => passwordInput.value.focus(),
        onFinish: () => form.reset(),
    });
};

</script>

<template>
    <Head title="Profile" />

    <AuthenticatedLayout>

        <div class="container-fluid">
            <div class="nk-content-inner">
                <div class="nk-content-body">
                    <div class="nk-block">
                        <div class="card card-bordered">
                            <ProfileCardAside title="Browser Sessions"
                                description="Manage and log out your active sessions on other browsers and devices."
                                :user="user">
                                <div class="nk-block">
                                    <div class="active_sessions">
                                        <div class="table-responsive" v-if="sessions.length > 0">
                                            <div v-for="(session, i) in sessions" :key="i" class="as_list">
                                                <div class="platform_icon">
                                                    <svg v-if="session.agent.is_desktop" class="w-8 h-8 text-gray-500"
                                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                        stroke-width="1.5" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M9 17.25v1.007a3 3 0 01-.879 2.122L7.5 21h9l-.621-.621A3 3 0 0115 18.257V17.25m6-12V15a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 15V5.25m18 0A2.25 2.25 0 0018.75 3H5.25A2.25 2.25 0 003 5.25m18 0V12a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 12V5.25" />
                                                    </svg>

                                                    <svg v-else class="w-8 h-8 text-gray-500"
                                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                        stroke-width="1.5" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M10.5 1.5H8.25A2.25 2.25 0 006 3.75v16.5a2.25 2.25 0 002.25 2.25h7.5A2.25 2.25 0 0018 20.25V3.75a2.25 2.25 0 00-2.25-2.25H13.5m-3 0V3h3V1.5m-3 0h3m-3 18.75h3" />
                                                    </svg>
                                                </div>
                                                <button v-if="!session.is_current_device" title="Log Out"
                                                    class="btn btn-mat log_out_session js_session-deleter"
                                                    @click.prevent="showModal()">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                        viewBox="0 0 24 24">
                                                        <path fill="currentColor"
                                                            d="M19,6.41L17.59,5L12,10.59L6.41,5L5,6.41L10.59,12L5,17.59L6.41,19L12,13.41L17.59,19L19,17.59L13.41,12L19,6.41Z">
                                                        </path>
                                                    </svg>
                                                </button>
                                                <div class="session_info">
                                                    <h4>{{ session.agent.platform ? session.agent.platform : 'Unknown' }}
                                                    </h4>
                                                    <p>
                                                        <span><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                                viewBox="0 0 24 24">
                                                                <path fill="currentColor"
                                                                    d="M21,3H3A2,2 0 0,0 1,5V19A2,2 0 0,0 3,21H21A2,2 0 0,0 23,19V5A2,2 0 0,0 21,3M21,19H3V5H13V9H21V19Z">
                                                                </path>
                                                            </svg> {{ session.agent.browser ? session.agent.browser :
                                                                'Unknown' }}</span>
                                                        <span class="middot" style="padding: 0 5px;">·</span>
                                                        <span>
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                                viewBox="0 0 24 24" style="margin-right: 5px;">
                                                                <path fill="currentColor"
                                                                    d="M12,20A8,8 0 0,0 20,12A8,8 0 0,0 12,4A8,8 0 0,0 4,12A8,8 0 0,0 12,20M12,2A10,10 0 0,1 22,12A10,10 0 0,1 12,22C6.47,22 2,17.5 2,12A10,10 0 0,1 12,2M12.5,7V12.25L17,14.92L16.25,16.15L11,13V7H12.5Z">
                                                                </path>
                                                            </svg>
                                                            <span v-if="session.is_current_device"
                                                                class="text-green-500 font-semibold">This device</span>
                                                            <span v-else>Last active {{ session.last_active }}</span>
                                                        </span>
                                                    </p>
                                                    <p>IP Address: {{ session.ip_address }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <Notification v-show="form.recentlySuccessful" icon="ni-check-circle"
                                            color="alert-success" alert-fill>
                                            Devices have been logged out successfully.
                                        </Notification>
                                    </div>
                                </div>
                            </ProfileCardAside>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <Modal ref="modalRef" :id="`modalSession`" title="Log Out Other Browser Sessions">
            <form @submit.prevent="submitForm">
                <div class="row gy-4">
                    <div class="col-12">
                        <FormField label="Enter password to confirm" label-for="password"
                            :class="{ 'text-red-400': form.errors.password }">
                            <div class="form-control-wrap">
                                <input id="password" v-model="form.password" placeholder="Enter password" type="password"
                                    class="form-control" :class="{ 'border-red-400': form.errors.password }"
                                    ref="passwordInput">
                                <div class="text-red-400 text-sm" v-if="form.errors.password">
                                    {{ form.errors.password }}
                                </div>
                            </div>
                        </FormField>
                    </div>
                    <div class="col-12">
                        <ul class="align-center flex-wrap flex-sm-nowrap gx-4 gy-2">
                            <li>
                                <button type="submit" class="btn btn-lg btn-primary"
                                    :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                    <template v-if="form.processing">
                                        <span class="spinner-border spinner-border-sm" role="status"
                                            aria-hidden="true"></span><span>Loading...</span>
                                    </template>
                                    <template v-else>
                                        Log Out Other Browser Sessions
                                    </template>
                                </button>
                            </li>
                            <li><a href="#" class="link link-light" @click.prevent="closeModal">Cancel</a></li>
                        </ul>
                    </div>
                </div>
            </form>
        </Modal>
    </AuthenticatedLayout>
</template>
