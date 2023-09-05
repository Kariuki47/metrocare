<script setup>
import { ref, reactive, nextTick, onMounted } from 'vue';
import Modal from "@/Components/Modal.vue"
import FormField from '@/Components/FormField.vue'

const emit = defineEmits(['confirmed']);

defineProps({
    title: {
        type: String,
        default: 'Confirm Password',
    },
    content: {
        type: String,
        default: 'For your security, please confirm your password to continue.',
    },
    button: {
        type: String,
        default: 'Confirm',
    },
});

const modalRef = ref();
const confirmingPassword = ref(false);
const incModal = ref(0);

const form = reactive({
    password: '',
    error: '',
    processing: false,
});

const passwordInput = ref(null);

const showModal = () => {
    modalRef.value.showModal();
}

const closeModal = () => {
    modalRef.value.closeModal();
}

const modalClose = () => {
    form.password = '';
    form.error = '';
}

const startConfirmingPassword = () => {

    axios.get(route('password.confirmation')).then(response => {
        if (response.data.confirmed) {
            emit('confirmed');

        } else {
            confirmingPassword.value = true;
            showModal()

            setTimeout(() => passwordInput.value.focus(), 250);
        }
    });
};

const confirmPassword = () => {
    form.processing = true;

    axios.post(route('password.confirm'), {
        password: form.password,
    }).then(() => {
        form.processing = false;

        closeModal();
        nextTick().then(() => emit('confirmed'));

    }).catch(error => {
        form.processing = false;
        form.error = error.response.data.errors.password[0];
        passwordInput.value.focus();
    });
};

onMounted(() => {
  incModal.value = incModal.value + 1;
});

</script>

<template>
    <span @click="startConfirmingPassword">
        <slot />
    </span>

    <Modal ref="modalRef" :id="`modalPassword`" title="Confirm Password" @modal-close="modalClose">
        <form @submit.prevent="confirmPassword">
            <p>For your security, please confirm your password to continue.</p>
            <div class="row gy-4">
                <div class="col-12">
                    <FormField label="Password" label-for="password">
                        <div class="form-control-wrap">
                            <input id="password" v-model="form.password" placeholder="Enter current password"
                                type="password" class="form-control" ref="passwordInput">
                            <div class="text-red-400 text-sm" v-if="form.error">
                                {{ form.error }}
                            </div>
                        </div>
                    </FormField>
                </div>
                <div class="col-12">
                    <ul class="align-center flex-wrap flex-sm-nowrap gx-4 gy-2">
                        <li>
                            <button type="submit" class="btn btn-lg btn-primary" :class="{ 'opacity-25': form.processing }"
                                :disabled="form.processing">
                                <template v-if="form.processing">
                                    <span class="spinner-border spinner-border-sm" role="status"
                                        aria-hidden="true"></span><span>Loading...</span>
                                </template>
                                <template v-else>
                                    {{ button }}
                                </template>
                            </button>
                        </li>
                        <li><a href="#" class="link link-light" @click.prevent="closeModal">Cancel</a></li>
                    </ul>
                </div>
            </div>
        </form>
    </Modal>
</template>
