<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, useForm, Link } from '@inertiajs/vue3';

defineProps({
    status: {
        type: String,
    },
});

const form = useForm({
    email: '',
});

const submit = () => {
    form.post(route('password.email'));
};
</script>

<template>
    <GuestLayout>

        <Head title="Forgot Password" />

        <div class="nk-block-head">
            <div class="nk-block-head-content">
                <h5 class="nk-block-title">Reset password</h5>
                <div class="nk-block-des">
                    <p>If you forgot your password, well, then we’ll email you instructions to reset your password.</p>
                </div>
            </div>
        </div>

        <div v-if="status" class="alert alert-fill alert-success alert-icon">
            <em class="icon ni ni-check-circle"></em>
            {{ status }}
        </div>

        <form @submit.prevent="submit">

            <div class="form-group">
                <div class="form-label-group">
                    <InputLabel for="email" value="Email" />
                </div>
                <div class="form-control-wrap">
                    <TextInput id="email" type="email" class="form-control form-control-lg"
                        placeholder="Enter your email address" v-model="form.email" required autofocus
                        autocomplete="username" />
                </div>
                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div class="form-group">
                <PrimaryButton class="btn btn-lg btn-primary btn-block" :class="{ 'opacity-5': form.processing }"
                    :disabled="form.processing">
                    <template v-if="form.processing"><span class="spinner-border spinner-border-sm" role="status"
                            aria-hidden="true"></span> <span>Loading...</span></template>
                    <template v-else>Send Reset Link</template>
                </PrimaryButton>
            </div>
        </form>

        <div class="form-note-s2 pt-5">
            <Link :href="route('login')">
            <strong>Return to login</strong>
            </Link>
        </div>
    </GuestLayout></template>
