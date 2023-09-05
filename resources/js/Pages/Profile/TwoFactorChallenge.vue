<script setup>
import { ref, computed, watch, reactive, nextTick } from 'vue';
import { router, useForm, usePage, Head } from '@inertiajs/vue3';
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue"
import ProfileCardAside from "@/Components/ProfileCardAside.vue"
import DangerButton from '@/Components/DangerButton.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import Notification from "@/Components/Notification.vue"
import Modal from "@/Components/Modal.vue"
import FormField from '@/Components/FormField.vue'

const user = usePage().props.auth.user;

const props = defineProps({
  confirmsTwoFactorAuthentication: Boolean,
});


const enabling = ref(false);
const confirming = ref(false);
const disabling = ref(false);
const qrCode = ref(null);
const setupKey = ref(null);
const recoveryCodes = ref([]);
const isCopy = ref(false);
const modalRef = ref();
const isAction = ref(false);

const confirmationForm = useForm({
  code: '',
});

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

const startConfirmingPassword = (value) => {

  axios.get(route('password.confirmation')).then(response => {
    if (response.data.confirmed) {
      
      nextAction(value);

    } else {
      isAction.value = value;

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
    nextTick().then(() => action);

  }).catch(error => {
    form.processing = false;
    form.error = error.response.data.errors.password[0];
    passwordInput.value.focus();
  });
};

const action = () => {
  switch (isAction.value) {
    case 'disable':
      disableTwoFactorAuthentication();
      break;
    case 'confirm':
      confirmTwoFactorAuthentication();
      break;
    case 'enable':
      enableTwoFactorAuthentication();
      break;
    case 'regenerate':
      regenerateRecoveryCodes();
      break;
    case 'showCodes':
      showRecoveryCodes();
      break;
    default:
      console.log(isAction.value);
  }
}

const nextAction = (value) => {
  
  switch (value) {
    case 'disable':
      disableTwoFactorAuthentication();
      break;
    case 'confirm':
      confirmTwoFactorAuthentication();
      break;
    case 'enable':
      enableTwoFactorAuthentication();
      break;
    case 'regenerate':
      regenerateRecoveryCodes();
      break;
    case 'showCodes':
      showRecoveryCodes();
      break;
    default:
      console.log(value);
  }
}

const twoFactorEnabled = computed(
  () => !enabling.value && usePage().props.auth.user?.two_factor_enabled,
);

watch(twoFactorEnabled, () => {
  if (!twoFactorEnabled.value) {
    confirmationForm.reset();
    confirmationForm.clearErrors();
  }
});

const enableTwoFactorAuthentication = () => {
  enabling.value = true;

  router.post(route('two-factor.enable'), {}, {
    preserveScroll: true,
    onSuccess: () => Promise.all([
      showQrCode(),
      showSetupKey(),
      showRecoveryCodes(),
    ]),
    onFinish: () => {
      enabling.value = false;
      confirming.value = props.confirmsTwoFactorAuthentication;
    },
  });
};

const showQrCode = () => {
  return axios.get(route('two-factor.qr-code')).then(response => {
    qrCode.value = response.data.svg;
  });
};

const showSetupKey = () => {
  return axios.get(route('two-factor.secret-key')).then(response => {
    setupKey.value = response.data.secretKey;
  });
}

const showRecoveryCodes = () => {
  return axios.get(route('two-factor.recovery-codes')).then(response => {
    recoveryCodes.value = response.data;
  });
};

const confirmTwoFactorAuthentication = () => {
  confirmationForm.post(route('two-factor.confirm'), {
    errorBag: "confirmTwoFactorAuthentication",
    preserveScroll: true,
    preserveState: true,
    onSuccess: () => {
      confirming.value = false;
      qrCode.value = null;
      setupKey.value = null;
    },
  });
};

const regenerateRecoveryCodes = () => {
  axios
    .post(route('two-factor.recovery-codes'))
    .then(() => showRecoveryCodes());
};

const disableTwoFactorAuthentication = () => {
  disabling.value = true;

  router.delete(route('two-factor.disable'), {
    preserveScroll: true,
    onSuccess: () => {
      disabling.value = false;
      confirming.value = false;
    },
  });
};


const copy = () => {

  try {
    navigator.clipboard.writeText(setupKey.value)
    isCopy.value = true;
    setTimeout(() => isCopy.value = false, 2000);

  } catch (err) {
    isCopy.value = false;
  }

}
</script>

<template>
  <AuthenticatedLayout>

    <Head title="Two-factor Confirmation" />

    <div class="container-fluid">
      <div class="nk-content-inner">
        <div class="nk-content-body">
          <div class="nk-block">
            <div class="card card-bordered">
              <ProfileCardAside title="Two Factor Authentication"
                description="Add additional security to your account using two factor authentication." :user="user">
                <div class="nk-block">
                  <div v-if="twoFactorEnabled && !confirming" class="card card-bordered">
                    <div class="card-inner">
                      <div class="between-center flex-wrap flex-md-nowrap g-3">
                        <div class="nk-block-text">
                          <h6>2 Factor Auth &nbsp; <span class="badge bg-success ms-0">Enabled</span></h6>
                          <p>When two factor authentication is enabled, you will be prompted for a secure, random token
                            during authentication. You may retrieve this token from your phone's Google Authenticator
                            application.
                          </p>
                        </div>
                        <div class="nk-block-actions">
                          <span @click="startConfirmingPassword('disable')">
                            <DangerButton v-if="!confirming" class="btn btn-danger" :class="{ 'opacity-25': disabling }"
                              :disabled="disabling">
                              <template v-if="disabling">
                                <span class="spinner-border spinner-border-sm" role="status"
                                  aria-hidden="true"></span><span>Loading...</span>
                              </template>
                              <template v-else>
                                Disable
                              </template>
                            </DangerButton>
                          </span>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div v-else-if="twoFactorEnabled && confirming">
                    <div class="row mb-3">
                      <div class="col-12">
                        <div class="d-flex">
                          <div class="pe-5 mr-4">
                            <h6>1. Configuring your authenticator</h6>
                            <p class="medium mb-2">You need to download Google Authenticator app for <a target="_blank"
                                href="https://play.google.com/store/apps/details?id=com.google.android.apps.authenticator2&amp;hl=en">Android</a>
                              or <a target="_blank"
                                href="https://itunes.apple.com/eg/app/google-authenticator/id388497605?mt=8">IOS</a>
                            </p>
                            <p class="medium mb-0">In your app, add a new account by scanning the QR code or enter the
                              setup key.</p>
                            <div v-if="setupKey" class="code-block b-0 px-0" :class="{ 'clipboard-success': isCopy }">
                              <h6 class="overline-title title">SETUP KEY</h6>
                              <button type="button" class="btn btn-sm clipboard-init" title="Copy to clipboard">
                                <span v-if="isCopy" class="clipboard-text text-success">Copied</span>
                                <span v-else class="clipboard-text" @click="copy">Copy</span>
                              </button>
                              <div class="bg-light p-2 round-sm" v-html="setupKey"></div>
                            </div>
                          </div>
                          <div v-if="qrCode" class="border p-1 round-lg w-200px bg-white bg-dark" v-html="qrCode">
                          </div>
                        </div>
                      </div>
                      <div class="col-sm-8">
                        <div class="form-group">
                          <InputLabel for="code" value="2. Enter the 6-digit code shown on your app" />
                          <div class="form-control-wrap">
                            <TextInput id="code" v-model="confirmationForm.code" type="text" name="code"
                              placeholder="Check your app" class="form-control" inputmode="numeric" autofocus
                              autocomplete="one-time-code" @keyup.enter="confirmTwoFactorAuthentication" />
                          </div>
                        </div>
                        <div class="form-group">
                          <Notification v-if="confirmationForm.errors.code" icon="ni-cross-circle" color="alert-danger"
                            alert-dismissible alert-fill>
                            {{ confirmationForm.errors.code }}
                          </Notification>
                        </div>
                        <ul class="align-center flex-wrap flex-sm-nowrap gx-4 gy-2">
                          <li>
                            <span @click="startConfirmingPassword('confirm')">
                              <PrimaryButton type="button" class="btn btn-primary"
                                :class="{ 'opacity-25': confirmationForm.processing }"
                                :disabled="confirmationForm.processing">
                                <template v-if="confirmationForm.processing">
                                  <span class="spinner-border spinner-border-sm" role="status"
                                    aria-hidden="true"></span><span>Loading...</span>
                                </template>
                                <template v-else>
                                  Confirm
                                </template>
                              </PrimaryButton>
                            </span>
                          </li>
                          <li>
                            <span @click="startConfirmingPassword('disable')">
                              <SecondaryButton class="btn btn-light" :class="{ 'opacity-25': disabling }"
                                :disabled="disabling">
                                <template v-if="disabling">
                                  <span class="spinner-border spinner-border-sm" role="status"
                                    aria-hidden="true"></span><span>Loading...</span>
                                </template>
                                <template v-else>
                                  Cancel
                                </template>
                              </SecondaryButton>
                            </span>
                          </li>
                        </ul>
                      </div>
                    </div>
                  </div>
                  <div v-else class="card card-bordered">
                    <div class="card-inner">
                      <div class="between-center flex-wrap flex-md-nowrap g-3">
                        <div class="nk-block-text">
                          <h6 v-if="twoFactorEnabled && !confirming">2 Factor Auth &nbsp; <span
                              class="badge bg-success ms-0">Enabled</span></h6>
                          <h6 v-else>2 Factor Auth &nbsp; <span class="badge bg-info ms-0">Disabled</span></h6>
                          <p>When two factor authentication is enabled, you will be prompted for a secure, random token
                            during authentication. You may retrieve this token from your phone's Google Authenticator
                            application.
                          </p>
                        </div>
                        <div v-if="!twoFactorEnabled" class="nk-block-actions">
                          <span @click="startConfirmingPassword('enable')">
                            <PrimaryButton type="button" class="btn btn-primary" :class="{ 'opacity-25': enabling }"
                              :disabled="enabling">
                              <template v-if="enabling">
                                <span class="spinner-border spinner-border-sm" role="status"
                                  aria-hidden="true"></span><span>Loading...</span>
                              </template>
                              <template v-else>
                                Enable
                              </template>
                            </PrimaryButton>
                          </span>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div v-if="twoFactorEnabled">
                    <div v-if="recoveryCodes.length > 0 && !confirming">
                      <div class="mt-4 max-w-xl text-sm text-gray-600">
                        <p class="font-semibold">
                          Store these recovery codes in a secure password manager. They can be used to recover access to
                          your account if your two factor authentication device is lost.
                        </p>
                      </div>

                      <div class="grid max-w-xl mt-4 px-4 py-4 font-mono text-sm bg-gray-100 rounded-lg">
                        <div v-for="code in recoveryCodes" :key="code">
                          {{ code }}
                        </div>
                      </div>
                    </div>
                  </div>

                  <div v-if="twoFactorEnabled" class="mt-3">
                    <div>
                      <span @click="startConfirmingPassword('regenerate')">
                        <SecondaryButton v-if="recoveryCodes.length > 0 && !confirming" class="btn btn-primary">
                          Regenerate Recovery Codes
                        </SecondaryButton>
                      </span>

                      <span @click="startConfirmingPassword('showCodes')">
                        <SecondaryButton v-if="recoveryCodes.length === 0 && !confirming" class="btn btn-primary">
                          Show Recovery Codes
                        </SecondaryButton>
                      </span>
                    </div>
                  </div>
                </div>
              </ProfileCardAside>
            </div>
          </div>
        </div>
      </div>
    </div>

    <Modal ref="modalRef" :id="`modalPassword`" title="Confirm Password" @modal-close="modalClose">
      <form @submit.prevent="confirmPassword">
        <p>For your security, please confirm your password to continue.</p>
        <div class="row gy-4">
          <div class="col-12">
            <FormField label="Password" label-for="password">
              <div class="form-control-wrap">
                <input id="password" v-model="form.password" placeholder="Enter current password" type="password"
                  class="form-control" ref="passwordInput">
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
                    Confirm
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
