<script setup>
import { ref, onUnmounted, nextTick } from "vue"
import { Head, useForm, usePage } from '@inertiajs/vue3';
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue"
import FormField from '@/Components/FormField.vue'
import Modal from "@/Components/Modal.vue"
import Notification from "@/Components/Notification.vue"
import ProfileCardAside from "@/Components/ProfileCardAside.vue"

const user = usePage().props.auth.user;

const form = useForm({
    current_password: '',
    password: '',
    password_confirmation: '',
});

const modalRef = ref();
const modalRefAcc = ref();
const success = ref(false);
const successAcc = ref(false);
const passwordInput = ref(null);
const currentPasswordInput = ref(null);

const passwordInputAcc = ref(null);

const formAcc = useForm({
    password: '',
});

function showModal() {
    modalRef.value.showModal();
}

function closeModal() {
    modalRef.value.closeModal();
    form.reset();
}

const modalClose = () => {
    success.value = false;
}

function showModalAcc () {
    modalRefAcc.value.showModal();
    nextTick(() => passwordInputAcc.value.focus());
}

function closeModalAcc () {
    modalRefAcc.value.closeModal();
    formAcc.reset();
}

const modalCloseAcc = () => {
    successAcc.value = false;
}

const submitForm = () => {
    form.put(route('password.update'), {
        preserveScroll: true,
        onSuccess: () => {
            form.reset()
            success.value = true
        },
        onError: () => {
            if (form.errors.password) {
                form.reset('password', 'password_confirmation');
                passwordInput.value.focus();
            }
            if (form.errors.current_password) {
                form.reset('current_password');
                currentPasswordInput.value.focus();
            }
        },
    });
};

const deleteUser = () => {
    formAcc.delete(route('profile.destroy'), {
        preserveScroll: true,
        onSuccess: () => {
            document.querySelectorAll(".modal-backdrop").forEach(el => el.remove());
        },
        onError: () => passwordInputAcc.value.focus(),
        onFinish: () => formAcc.reset(),
    });
};

onUnmounted(() => {
    success.value = false;
    successAcc.value = false;
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
                            <ProfileCardAside title="Account Settings"
                                description="These settings are helps you keep your account secure." :user="user">
                                <div class="nk-block">
                                    <div class="card card-bordered">
                                        <div class="card-inner-group">
                                            <div class="card-inner">
                                                <div class="between-center flex-wrap g-3">
                                                    <div class="nk-block-text">
                                                        <h6>Change Password</h6>
                                                        <p>Set a unique password to protect your account.</p>
                                                    </div>
                                                    <div class="nk-block-actions flex-shrink-sm-0">
                                                        <ul class="align-center flex-wrap flex-sm-nowrap gx-3 gy-2">
                                                            <li class="order-md-last"><a href="#"
                                                                    class="btn btn-primary" @click.prevent="showModal()">Change Password</a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-inner">
                                                <div class="between-center flex-wrap flex-md-nowrap g-3">
                                                    <div class="nk-block-text">
                                                        <h6>Delete Account</h6>
                                                        <p>Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.</p>
                                                    </div>
                                                    <div class="nk-block-actions flex-shrink-0">
                                                        <a href="#" class="btn btn-danger" @click.prevent="showModalAcc()">Delete Account</a>
                                                    </div>
                                                </div>
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

        <Modal ref="modalRefAcc" :id="`modalAccount`" title="Delete Account" @modal-close="modalCloseAcc">
            <form @submit.prevent="deleteUser">
                <div class="row gy-4">
                    <div class="col-12">
                        <FormField label="Password" label-for="cur_password"
                            :class="{ 'text-red-400': formAcc.errors.password }">
                            <div class="form-control-wrap">
                                <input id="cur_password" v-model="formAcc.password" placeholder="Enter current password" type="password" class="form-control" :class="{'border-red-400':formAcc.errors.password}" ref="passwordInputAcc">
                                <div class="text-red-400 text-sm" v-if="formAcc.errors.password">
                                    {{ formAcc.errors.password }}
                                </div>
                            </div>
                        </FormField>
                    </div>
                    <div class="col-12">
                        <ul class="align-center flex-wrap flex-sm-nowrap gx-4 gy-2">
                            <li>
                                <button type="submit" class="btn btn-lg btn-primary"
                                    :class="{ 'opacity-25': formAcc.processing }" :disabled="formAcc.processing">
                                    <template v-if="formAcc.processing">
                                        <span class="spinner-border spinner-border-sm" role="status"
                                            aria-hidden="true"></span><span>Loading...</span>
                                    </template>
                                    <template v-else>
                                        Delete Account
                                    </template>
                                </button>
                            </li>
                            <li><a href="#" class="link link-light" @click.prevent="closeModalAcc">Cancel</a></li>
                        </ul>
                    </div>
                </div>
            </form>
        </Modal>

        <Modal ref="modalRef" :id="`modalPersonal`" title="Change Password" @modal-close="modalClose">
            <form @submit.prevent="submitForm">
                <div class="row gy-4">
                    <div class="col-12">
                        <FormField label="Current Password" label-for="current_password"
                            :class="{ 'text-red-400': form.errors.current_password }">
                            <div class="form-control-wrap">
                                <input id="current_password" v-model="form.current_password" placeholder="Enter current password" type="password" class="form-control" :class="{'border-red-400':form.errors.current_password}" ref="currentPasswordInput">
                                <div class="text-red-400 text-sm" v-if="form.errors.current_password">
                                    {{ form.errors.current_password }}
                                </div>
                            </div>
                        </FormField>
                    </div>
                    <div class="col-lg-6">
                        <FormField label="Password" label-for="password" :class="{ 'text-red-400': form.errors.password }">
                            <div class="form-control-wrap">
                                <input id="password" v-model="form.password" placeholder="Enter password" type="password" class="form-control" :class="{'border-red-400':form.errors.password}" ref="passwordInput">
                                <div class="text-red-400 text-sm" v-if="form.errors.password">
                                    {{ form.errors.password }}
                                </div>
                            </div>
                        </FormField>
                    </div>
                    <div class="col-lg-6">
                        <FormField label="Password Confirmation" label-for="password_confirmation"
                            :class="{ 'text-red-400': form.errors.password_confirmation }">
                            <div class="form-control-wrap">
                                <input id="password_confirmation" v-model="form.password_confirmation" placeholder="Enter password" type="password" class="form-control" :class="{'border-red-400':form.errors.password_confirmation}">
                                <div class="text-red-400 text-sm" v-if="form.errors.password_confirmation">
                                    {{ form.errors.password_confirmation }}
                                </div>
                            </div>
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
                                        Save Changes
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
