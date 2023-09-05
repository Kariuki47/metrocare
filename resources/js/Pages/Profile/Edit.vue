<script setup>
import { ref, onUnmounted } from "vue"
import { Head, useForm } from '@inertiajs/vue3';
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue"
import FormField from '@/Components/FormField.vue'
import FormControl from '@/Components/FormControl.vue'
import Modal from "@/Components/Modal.vue"
import Notification from "@/Components/Notification.vue"
import ProfileCardAside from "@/Components/ProfileCardAside.vue"

const props = defineProps({
    user: {
        type: Object,
        default: () => ({}),
    },
    status: {
        type: String,
    },
});

const form = useForm({
    name: props.user.name,
});

const modalRef = ref();
const success = ref(false);

function showModal() {
    modalRef.value.showModal();
}

function closeModal() {
    modalRef.value.closeModal();
}

const modalClose = () => {
    success.value = false;
}

const submitForm = () => {

    form.patch(route('profile.update'), {
        preserveScroll: true,
        onSuccess: () => success.value = true
    })
}

onUnmounted(() => {
    success.value = false;
});

</script>

<template>
    <Head title="Profile" />

    <AuthenticatedLayout>

        <div class="container-fluid">
            <div class="nk-content-inner">
                <div class="nk-content-body">
                    <div class="nk-block">
                        <div class="card card-bordered">
                            <ProfileCardAside title="Personal Information"
                                :description="`Basic info, like your name and address, that you use on ` + $page.props.appName + `.`"
                                :user="props.user">
                                <div class="nk-block">
                                    <div class="nk-data data-list">
                                        <div class="data-head">
                                            <h6 class="overline-title">Basics</h6>
                                        </div>
                                        <div class="data-item" data-modal-target="modalPersonal"
                                            @click.prevent="showModal()">
                                            <div class="data-col">
                                                <span class="data-label">Name</span>
                                                <span class="data-value">{{ props.user.name }}</span>
                                            </div>
                                            <div class="data-col data-col-end">
                                                <span class="data-more">
                                                    <em class="icon ni ni-forward-ios"></em>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="data-item" data-modal-target="modalPersonal">
                                            <div class="data-col">
                                                <span class="data-label">Email</span>
                                                <span class="data-value">{{ props.user.email }}</span>
                                            </div>
                                            <div class="data-col data-col-end">
                                                <span class="data-more disable"><em class="icon ni ni-lock-alt"></em></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </ProfileCardAside>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <Modal ref="modalRef" :id="`modalPersonal`" title="Update Personal Information" @modal-close="modalClose">
            <form @submit.prevent="submitForm">
                <div class="row gy-4">
                    <div class="col-12">
                        <FormField label="Name" :class="{ 'text-red-400': form.errors.name }" label-for="name">
                            <FormControl v-model="form.name" id="name" type="text" placeholder="Enter Name"
                                :error="form.errors.name">
                                <div class="text-red-400 text-sm" v-if="form.errors.name">
                                    {{ form.errors.name }}
                                </div>
                            </FormControl>
                        </FormField>
                    </div>
                    <div class="col-12">
                        <Notification v-if="$page.props.flash.message && success" icon="ni-check-circle"
                            color="alert-success" alert-dismissible alert-fill>
                            {{ $page.props.flash.message }}
                        </Notification>
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
                                        Update Profile
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
