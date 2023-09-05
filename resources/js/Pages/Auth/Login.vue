<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

const isHidden = ref(false);

defineProps({
    canResetPassword: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};

const togglePassword = () => {
    isHidden.value = !isHidden.value;
};
</script>

<template>
    <GuestLayout>

        <Head title="Log in" />

        <div v-if="status" class="alert alert-fill alert-success alert-icon">
            <em class="icon ni ni-check-circle"></em> 
            {{ status }}
        </div>

        <div class="nk-block-head">
            <div class="nk-block-head-content">
                <h5 class="nk-block-title">Sign-In</h5>
                <div class="nk-block-des">
                    <p>Access the {{ $page.props.appName }} panel using your email and password.</p>
                </div>
            </div>
        </div>

        <form @submit.prevent="submit" class="form-validate is-alter">
            <div class="form-group">
                <div class="form-label-group">
                    <InputLabel for="email" value="Email or Username" />
                </div>
                <div class="form-control-wrap">
                    <TextInput id="email" type="email" class="form-control form-control-lg"
                        placeholder="Enter your email address or username" v-model="form.email" required />
                </div>
                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div class="form-group">
                <div class="form-label-group">
                    <InputLabel for="password" value="Password" />
                    <Link v-if="canResetPassword" :href="route('password.request')" class="link link-primary link-sm">
                    Forgot Password?
                    </Link>
                </div>
                <div class="form-control-wrap">
                    <a tabindex="-1" href="#" class="form-icon form-icon-right passcode-switch lg" :class="isHidden ? 'is-shown' : 'is-hidden'" data-target="password"
                        @click.prevent="togglePassword">
                        <em class="passcode-icon icon-show icon ni ni-eye"></em>
                        <em class="passcode-icon icon-hide icon ni ni-eye-off"></em>
                    </a>
                    <TextInput id="password" :type="isHidden ? 'text' : 'password'" class="form-control form-control-lg" v-model="form.password"
                        required autocomplete="new-password" placeholder="Enter your password" :class="isHidden ? 'is-shown' : 'is-hidden'"/>
                </div>
                <InputError class="mt-2" :message="form.errors.password" />
            </div>

            <div class="form-group">
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" v-model="form.remember" name="remember" id="remember">
                    <label class="custom-control-label" for="remember">Remember me</label>
                </div>
            </div>

            <div class="form-group">
                <PrimaryButton class="btn btn-lg btn-primary btn-block" :class="{ 'opacity-5': form.processing }"
                    :disabled="form.processing">
                    <template v-if="form.processing"><span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> <span>Loading...</span></template>
                    <template v-else>Sign in</template>
                </PrimaryButton>
            </div>
        </form>
        <div class="form-note-s2 pt-4"> New on our platform?
            <Link :href="route('register')">
            Create an account
            </Link>
        </div>
    </GuestLayout>
</template>
