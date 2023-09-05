<script setup>
import { Head, Link, useForm } from "@inertiajs/vue3"
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue"
import FormField from '@/Components/FormField.vue'
import FormControl from '@/Components/FormControl.vue'
import Notification from "@/Components/Notification.vue"

const props = defineProps({
  menu: {
    type: Object,
    default: () => ({}),
  },
})

const form = useForm({
  _method: 'put',
  name: props.menu.name,
  description: props.menu.description,
})
</script>

<template>
  <AuthenticatedLayout>

    <Head title="Update menu" />

    <div class="container-fluid">
      <div class="nk-content-inner">
        <div class="nk-content-body">
          <div class="components-preview wide-md mx-auto">
            <div class="nk-block-head nk-block-head-lg wide-sm">
              <div class="nk-block-head-content">
                <div class="nk-block-head-sub">
                  <Link class="back-to" :href="route('menu.index')">
                  <em class="icon ni ni-arrow-left"></em>
                  <span>Menu</span>
                  </Link>
                </div>
                <h2 class="nk-block-title fw-normal">Update menu</h2>
              </div>
            </div>
            <div class="nk-block nk-block-lg">
              <div class="card card-bordered">
                <div class="card-inner">
                  <form @submit.prevent="form.post(route('menu.update', props.menu.id))">
                    <div class="row g-4">
                      <div class="col-12">
                        <FormField label="Name" :class="{ 'text-red-400': form.errors.name }" label-for="name">
                          <FormControl v-model="form.name" type="text" placeholder="Enter Name" id="name"
                            :error="form.errors.name">
                            <div class="text-red-400 text-sm" v-if="form.errors.name">
                              {{ form.errors.name }}
                            </div>
                          </FormControl>
                        </FormField>
                      </div>
                      <div class="col-12">
                        <FormField label="Machine Name">
                          <div>{{ props.menu.machine_name }}</div>
                        </FormField>
                      </div>
                      <div class="col-12">
                        <FormField label="Description" :class="{ 'text-red-400': form.errors.description }"
                          label-for="description">
                          <FormControl v-model="form.description" type="text" placeholder="Enter Description"
                            id="description" :error="form.errors.description">
                            <div class="text-red-400 text-sm" v-if="form.errors.description">
                              {{ form.errors.description }}
                            </div>
                          </FormControl>
                        </FormField>
                      </div>
                      <div class="col-12">
                        <Notification v-if="$page.props.flash.message" icon="ni-check-circle" color="alert-success"
                          alert-dismissible alert-fill>
                          {{ $page.props.flash.message }}
                        </Notification>
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
                              Update Menu
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
