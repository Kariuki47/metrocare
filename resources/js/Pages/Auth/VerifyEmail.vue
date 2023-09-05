<script setup>
import { computed } from 'vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const props = defineProps({
    status: {
        type: String,
    },
});

const form = useForm({});

const submit = () => {
    form.post(route('verification.send'));
};

const verificationLinkSent = computed(() => props.status === 'verification-link-sent');
</script>

<template>
    <GuestLayout>

        <Head title="Email Verification" />

        <div class="nk-block-head">
            <div class="nk-block-head-content">
                <h5 class="nk-block-title">Email Verification</h5>
                <div class="nk-block-des">
                    <p>Thanks for signing up! Before getting started, could you verify your email address by clicking on the
                        link we just emailed to you? If you didn't receive the email, we will gladly send you another.</p>
                </div>
            </div>
        </div>

        <div v-if="verificationLinkSent" class="alert alert-success">
            A new verification link has been sent to the email address you provided during registration.
        </div>

        <form @submit.prevent="submit">
            <div class="mt-4 flex items-center justify-between">
                <PrimaryButton class="btn btn-lg btn-primary btn-block" :class="{ 'opacity-5': form.processing }"
                    :disabled="form.processing">
                    <template v-if="form.processing"><span class="spinner-border spinner-border-sm" role="status"
                            aria-hidden="true"></span> <span>Loading...</span></template>
                    <template v-else>Resend Verification Email</template>
                </PrimaryButton>

            </div>
        </form>
        <div class="form-note-s2 pt-4">
            <Link :href="route('logout')" method="post" as="button" style="color:#798bff">
            Log Out</Link>
        </div>
    </GuestLayout>
</template>
