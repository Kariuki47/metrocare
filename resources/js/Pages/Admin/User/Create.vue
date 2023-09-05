<script setup>
import { Head, Link, useForm } from "@inertiajs/vue3"
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue"
import FormField from '@/Components/FormField.vue'
import FormControl from '@/Components/FormControl.vue'
import FormCheckRadioMany from '@/Components/FormCheckRadioMany.vue'

const props = defineProps({
  roles: {
    type: Object,
    default: () => ({}),
  }
})

const form = useForm({
  name: '',
  email: '',
  password: '',
  password_confirmation: '',
  roles: []
})
</script>

<template>
  <AuthenticatedLayout>

    <Head title="Add user" />

    <div class="container-fluid">
      <div class="nk-content-inner">
        <div class="nk-content-body">
          <div class="components-preview wide-md mx-auto">
            <div class="nk-block-head nk-block-head-lg wide-sm">
              <div class="nk-block-head-content">
                <div class="nk-block-head-sub">
                  <Link class="back-to" :href="route('user.index')">
                  <em class="icon ni ni-arrow-left"></em>
                  <span>Users</span>
                  </Link>
                </div>
                <h2 class="nk-block-title fw-normal">Add new user</h2>
              </div>
            </div>
            <div class="nk-block nk-block-lg">
              <div class="card card-bordered">
                <div class="card-inner">
                  <form @submit.prevent="form.post(route('user.store'))">
                    <div class="row g-4">
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
                        <FormField label="Email" :class="{ 'text-red-400': form.errors.email }" label-for="email">
                          <FormControl v-model="form.email" id="email" type="text" placeholder="Enter Email"
                            :error="form.errors.email">
                            <div class="text-red-400 text-sm" v-if="form.errors.email">
                              {{ form.errors.email }}
                            </div>
                          </FormControl>
                        </FormField>
                      </div>
                      <div class="col-12">
                        <FormField label="Password" :class="{ 'text-red-400': form.errors.password }"
                          label-for="password">
                          <FormControl v-model="form.password" id="password" type="password" placeholder="Enter Password"
                            :error="form.errors.password">
                            <div class="text-red-400 text-sm" v-if="form.errors.password">
                              {{ form.errors.password }}
                            </div>
                          </FormControl>
                        </FormField>
                      </div>
                      <div class="col-12">
                        <FormField label="Password Confirmation" :class="{ 'text-red-400': form.errors.password }"
                          label-for="password-confirm">
                          <FormControl v-model="form.password_confirmation" id="password-confirm" type="password"
                            placeholder="Enter Password Confirmation" :error="form.errors.password">
                            <div class="text-red-400 text-sm" v-if="form.errors.password">
                              {{ form.errors.password }}
                            </div>
                          </FormControl>
                        </FormField>
                      </div>
                      <div class="col-12">
                        <FormField label="Roles" wrap-body>
                          <FormCheckRadioMany v-model="form.roles" name="roles" :options="props.roles" />
                        </FormField>
                      </div>
                      <div class="col-12">
                        <div class="form-group">
                          <button type="submit" class="btn btn-lg btn-primary" :class="{ 'opacity-25': form.processing }"
                            :disabled="form.processing">
                            <template v-if="form.processing">
                              <span class="spinner-border spinner-border-sm" role="status"
                                aria-hidden="true"></span><span>Loading...</span>
                            </template>
                            <template v-else>
                              Add User
                            </template>
                          </button>
                        </div>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
