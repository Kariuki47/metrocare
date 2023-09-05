<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

const isHidden = ref(false);

const isHiddenTwo = ref(false);

const props = defineProps({
    email: {
        type: String,
        required: true,
    },
    token: {
        type: String,
        required: true,
    },
});

const form = useForm({
    token: props.token,
    email: props.email,
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post(route('password.store'), {
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
        <Head title="Reset Password" />

        <div class="nk-block-head">
            <div class="nk-block-head-content">
                <h5 class="nk-block-title">Reset Password</h5>
                <div class="nk-block-des">
                    <p>Enter your new password to reset your password.</p>
                </div>
            </div>
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
                <PrimaryButton class="btn btn-lg btn-primary btn-block" :class="{ 'opacity-5': form.processing }"
                    :disabled="form.processing">
                    <template v-if="form.processing"><span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> <span>Loading...</span></template>
                    <template v-else>Reset Password</template>
                </PrimaryButton>
            </div>
        </form>
    </GuestLayout>
</template>
