<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

const isHidden = ref(false);

const isHiddenTwo = ref(false);

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
    terms: false,
});

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};

const togglePassword = () => {
    isHidden.value = !isHidden.value;
};

const togglePasswordTwo = () => {
    isHiddenTwo.value = !isHiddenTwo.value;
};
</script>

<template>
    <GuestLayout>

        <Head title="Register" />

        <div class="nk-block-head">
            <div class="nk-block-head-content">
                <h5 class="nk-block-title">Register</h5>
                <div class="nk-block-des">
                    <p>Create New {{ $page.props.appName }} Account</p>
                </div>
            </div>
        </div>

        <form @submit.prevent="submit">

            <div class="form-group">
                <div class="form-label-group">
                    <InputLabel for="name" value="Name" />
                </div>
                <div class="form-control-wrap">
                    <TextInput id="name" type="text" class="form-control form-control-lg"
                        placeholder="Enter your name" v-model="form.name" required autofocus autocomplete="name"/>
                </div>
                <InputError class="mt-2" :message="form.errors.name" />
            </div>

            <div class="form-group">
                <div class="form-label-group">
                    <InputLabel for="email" value="Email" />
                </div>
                <div class="form-control-wrap">
                    <TextInput id="email" type="email" class="form-control form-control-lg"
                        placeholder="Enter your email address" v-model="form.email" required />
                </div>
                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div class="form-group">
                <div class="form-label-group">
                    <InputLabel for="password" value="Password" />
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
                <div class="form-label-group">
                    <InputLabel for="password_confirmation" value="Confirm Password" />
                </div>
                <div class="form-control-wrap">
                    <a tabindex="-1" href="#" class="form-icon form-icon-right passcode-switch lg" :class="isHiddenTwo ? 'is-shown' : 'is-hidden'"
                        @click.prevent="togglePasswordTwo">
                        <em class="passcode-icon icon-show icon ni ni-eye"></em>
                        <em class="passcode-icon icon-hide icon ni ni-eye-off"></em>
                    </a>
                    <TextInput id="password_confirmation" :type="isHiddenTwo ? 'text' : 'password'" class="form-control form-control-lg" v-model="form.password_confirmation"
                        required autocomplete="new-password" placeholder="Enter your confirm password" :class="isHiddenTwo ? 'is-shown' : 'is-hidden'"/>
                </div>
                <InputError class="mt-2" :message="form.errors.password_confirmation" />
            </div>

            <div class="form-group">
                <div class="custom-control custom-control-xs custom-checkbox checked">
                    <input type="checkbox" class="custom-control-input" id="checkbox" v-model="form.terms">
                    <label class="custom-control-label" for="checkbox">I agree to {{ $page.props.appName }} 
                        <a tabindex="-1" href="#">Privacy Policy</a> &amp; 
                        <a tabindex="-1" href="#"> Terms.</a>
                    </label>
                </div>
                <InputError class="mt-2" :message="form.errors.terms" />
            </div>

            <div class="form-group">
                <PrimaryButton class="btn btn-lg btn-primary btn-block" :class="{ 'opacity-5': form.processing }"
                    :disabled="form.processing">
                    <template v-if="form.processing"><span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> <span>Loading...</span></template>
                    <template v-else>Register</template>
                </PrimaryButton>
            </div>
        </form>
        <div class="form-note-s2 pt-4"> 
            Already have an account ? 
            <Link :href="route('login')">
                Sign in
            </Link>
        </div>
    </GuestLayout>
</template>
