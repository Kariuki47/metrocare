<script setup>
import { ref, onUnmounted } from "vue"
import { Head, Link, useForm } from "@inertiajs/vue3"
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue"
import FormField from '@/Components/FormField.vue'
import FormControl from '@/Components/FormControl.vue'
import FormCheckRadioMany from '@/Components/FormCheckRadioMany.vue'
import Modal from "@/Components/Modal.vue"
import Notification from "@/Components/Notification.vue"
import UserCardAside from "@/Components/UserCardAside.vue"

const props = defineProps({
  user: {
    type: Object,
    default: () => ({}),
  },
  roles: {
    type: Object,
    default: () => ({}),
  },
  userHasRoles: {
    type: Object,
    default: () => ({}),
  }
})

const emit = defineEmits('modal-close', 'modal-show');

const modalRef = ref();
const success = ref(false);

function showModal() {
  modalRef.value.showModal();
}

function closeModal() {
  modalRef.value.closeModal();
}

const form = useForm({
  _method: 'put',
  name: props.user.name,
  email: props.user.email,
  password: '',
  password_confirmation: '',
  roles: props.userHasRoles
})

const modalClose = () => {
  success.value = false;
}

const submitForm = () => {
  form.post(route('user.update', props.user.id), {
    preserveScroll: true,
    onSuccess: () => success.value = true
  })
}

onUnmounted(() => {
  success.value = false;
});
</script>

<template>
  <AuthenticatedLayout>

    <Head title="Update user" />

    <div class="container-fluid">
      <div class="nk-content-inner">
        <div class="nk-content-body">
          <div class="nk-block-head nk-block-head-sm">
            <div class="nk-block-between g-3">
              <div class="nk-block-head-content">
                <h3 class="nk-block-title page-title">User /
                  <strong class="text-primary small">{{ props.user.email }}</strong>
                </h3>
              </div>
              <div class="nk-block-head-content">
                <Link :href="route('user.index')" class="btn btn-outline-light bg-white d-none d-sm-inline-flex">
                <em class="icon ni ni-arrow-left"></em>
                <span>Back</span>
                </Link>
                <Link :href="route('user.index')" class="btn btn-icon btn-outline-light bg-white d-inline-flex d-sm-none">
                <em class="icon ni ni-arrow-left"></em>
                </Link>
              </div>
            </div>
          </div>
          <div class="nk-block">
            <div class="card card-bordered">
              <UserCardAside title="Personal Information"
                :description="`Basic info, like your name and address, that you use on ` + $page.props.appName + `.`"
                :user="props.user">
                <div class="nk-block">
                  <div class="nk-data data-list">
                    <div class="data-head">
                      <h6 class="overline-title">Basics</h6>
                    </div>
                    <div class="data-item" data-modal-target="modalPersonal" @click.prevent="showModal()">
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
                    <div class="data-item" data-modal-target="modalPersonal" @click.prevent="showModal()">
                      <div class="data-col">
                        <span class="data-label">Email</span>
                        <span class="data-value">{{ props.user.email }}</span>
                      </div>
                      <div class="data-col data-col-end">
                        <span class="data-more disable"><em class="icon ni ni-forward-ios"></em></span>
                      </div>
                    </div>
                    <div class="data-item" data-modal-target="modalPersonal" @click.prevent="showModal()">
                      <div class="data-col">
                        <span class="data-label">Password</span>
                        <span class="data-value">******</span>
                      </div>
                      <div class="data-col data-col-end">
                        <span class="data-more">
                          <em class="icon ni ni-forward-ios"></em>
                        </span>
                      </div>
                    </div>
                    <div class="nk-data data-list">
                      <div class="data-head">
                        <h6 class="overline-title">Role</h6>
                      </div>
                      <div class="data-item">
                        <FormField label="Roles">
                          <FormCheckRadioMany v-model="form.roles" name="roles" is-column :options="props.roles" is-switch
                            disabled @modal-show="showModal()" />
                        </FormField>
                      </div>
                    </div>
                  </div>
                </div>
              </UserCardAside>
            </div>
          </div>
        </div>
      </div>
    </div>

    <Modal ref="modalRef" :id="`modalPersonal`" title="Update Personal Information" @modal-close="modalClose">
      <form @submit.prevent="submitForm">
        <div class="row gy-4">
          <div class="col-lg-6">
            <FormField label="Name" :class="{ 'text-red-400': form.errors.name }" label-for="name">
              <FormControl v-model="form.name" id="name" type="text" placeholder="Enter Name" :error="form.errors.name">
                <div class="text-red-400 text-sm" v-if="form.errors.name">
                  {{ form.errors.name }}
                </div>
              </FormControl>
            </FormField>
          </div>
          <div class="col-lg-6">
            <FormField label="Email" label-for="email" :class="{ 'text-red-400': form.errors.email }">
              <FormControl v-model="form.email" type="text" placeholder="Enter Email" id="email"
                :error="form.errors.email">
                <div class="text-red-400 text-sm" v-if="form.errors.email">
                  {{ form.errors.email }}
                </div>
              </FormControl>
            </FormField>
          </div>
          <div class="col-lg-6">
            <FormField label="Password" label-for="password" :class="{ 'text-red-400': form.errors.password }">
              <FormControl v-model="form.password" type="password" placeholder="Enter Password" id="password"
                :error="form.errors.password">
                <div class="text-red-400 text-sm" v-if="form.errors.password">
                  {{ form.errors.password }}
                </div>
              </FormControl>
            </FormField>
          </div>
          <div class="col-lg-6">
            <FormField label="Password Confirmation" label-for="new-password"
              :class="{ 'text-red-400': form.errors.password }">
              <FormControl v-model="form.password_confirmation" type="password" placeholder="Enter Password Confirmation"
                id="new-password" :error="form.errors.password">
                <div class="text-red-400 text-sm" v-if="form.errors.password">
                  {{ form.errors.password }}
                </div>
              </FormControl>
            </FormField>
          </div>
          <div class="col-12">
            <FormField label="Roles">
              <FormCheckRadioMany v-model="form.roles" name="roles" :options="props.roles" />
            </FormField>
          </div>
          <div class="col-12">
            <Notification v-if="$page.props.flash.message && success" icon="ni-check-circle" color="alert-success"
              alert-dismissible alert-fill>
              {{ $page.props.flash.message }}
            </Notification>
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
