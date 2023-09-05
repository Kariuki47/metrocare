<script setup>
import { Head, Link, useForm } from "@inertiajs/vue3"
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue"
import FormField from '@/Components/FormField.vue'
import FormControl from '@/Components/FormControl.vue'
import FormControlMenu from '@/Components/FormControlMenu.vue'
import FormCheckRadioGroup from '@/Components/FormCheckRadioGroup.vue'

const props = defineProps({
  menu: {
    type: Object,
    default: () => ({}),
  },
  item_options: {
    type: Object,
    default: () => ({}),
  },
})

const form = useForm({
  name: '',
  uri: '',
  icon: '',
  description: '',
  enabled: true,
  parent_id: '',
  weight: ''
})

</script>

<template>
  <AuthenticatedLayout>

    <Head title="Create menu item" />

    <div class="container-fluid">
      <div class="nk-content-inner">
        <div class="nk-content-body">
          <div class="components-preview wide-md mx-auto">
            <div class="nk-block-head nk-block-head-lg wide-sm">
              <div class="nk-block-head-content">
                <div class="nk-block-head-sub">
                  <Link class="back-to" :href="route('menu.item.index', menu.id)">
                  <em class="icon ni ni-arrow-left"></em>
                  <span>Menu Item</span>
                  </Link>
                </div>
                <h2 class="nk-block-title fw-normal">Add new menu item</h2>
              </div>
            </div>
            <div class="nk-block nk-block-lg">
              <div class="card card-bordered">
                <div class="card-inner">
                  <form @submit.prevent="form.post(route('menu.item.store', menu.id))">
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
                        <FormField label="Link" label-for="link" :class="{ 'text-red-400': form.errors.uri }">
                          <FormControl v-model="form.uri" type="text" placeholder="Enter Link" :error="form.errors.name"
                            id="link">
                            <div class="item-list">
                              You can also enter an internal path such as <em>/home</em> or an external URL such as
                              <em>http://example.com</em>.
                              Add prefix <em>&lt;admin&gt;</em> to link for admin page. Enter <em>&lt;nolink&gt;</em> to
                              display link text
                              only.
                            </div>
                            <div class="text-red-400 text-sm" v-if="form.errors.uri">
                              {{ form.errors.uri }}
                            </div>
                          </FormControl>
                        </FormField>
                      </div>
                      <div class="col-12">
                        <FormField label="Icon" :class="{ 'text-red-400': form.errors.icon }"
                          label-for="icon">
                          <FormControl v-model="form.icon" type="text" placeholder="Enter Icon"
                            id="icon" :error="form.errors.icon">
                            <div class="text-red-400 text-sm" v-if="form.errors.icon">
                              {{ form.errors.icon }}
                            </div>
                          </FormControl>
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
                        <FormCheckRadioGroup v-model="form.enabled" name="enabled" :options="{ enabled: 'Enabled' }" />
                      </div>
                      <div class="col-12">
                        <FormField label="Parent Item" :class="{ 'text-red-400': form.errors.parent_id }">
                          <FormControlMenu v-model="form.parent_id" type="select" placeholder="--ROOT--"
                            :error="form.errors.parent_id" :options="item_options">
                            <div class="text-red-400 text-sm" v-if="form.errors.parent_id">
                              {{ form.errors.parent_id }}
                            </div>
                            <div>
                              The maximum depth for a link and all its children is fixed. Some menu links may not be
                              available as parents
                              if selecting them would exceed this limit.
                            </div>
                          </FormControlMenu>
                        </FormField>
                      </div>
                      <div class="col-12">
                        <FormField label="Weight" :class="{ 'text-red-400': form.errors.weight }" label-for="weight">
                          <FormControl v-model="form.weight" type="text" placeholder="Enter Weight"
                            :error="form.errors.weight" id="weight">
                            <div class="text-red-400 text-sm" v-if="form.errors.weight">
                              {{ form.errors.weight }}
                            </div>
                          </FormControl>
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
                              Add Menu Item
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
