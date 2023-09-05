<script setup>
import { Head, Link, useForm } from "@inertiajs/vue3"
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue"
import FormField from '@/Components/FormField.vue'
import FormControl from '@/Components/FormControl.vue'

const props = defineProps({
    roles: {
        type: Object,
        default: () => ({}),
    },
    item_options: {
        type: Object,
        default: [
            { name: 'Male', value: 'male' },
            { name: 'Female', value: 'female' },
            { name: 'Other', value: 'other' },
        ],
    },
    county_options: {
        type: Object,
        default: () => ({}),
    },
    can: {
        type: Object,
        default: () => ({}),
    },
})

const form = useForm({
    name: '',
    sex: '',
    id_no: '',
    dob: '',
    email: '',
    county: '',
    phone: '',
    physician: '',
    physician_tel: ''
})

</script>

<template>
    <AuthenticatedLayout>

        <Head title="Add Patient Details" />

        <div class="container-fluid">
            <div class="nk-content-inner">
                <div class="nk-content-body">
                    <div class="components-preview wide-md mx-auto">
                        <div class="nk-block-head nk-block-head-lg wide-sm">
                            <div class="nk-block-head-content">
                                <div class="nk-block-head-sub">
                                    <Link class="back-to" :href="route('patient.index')">
                                    <em class="icon ni ni-arrow-left"></em>
                                    <span>Patients</span>
                                    </Link>
                                </div>
                                <h2 class="nk-block-title fw-normal">Add new patient</h2>
                            </div>
                        </div>
                        <div class="nk-block nk-block-lg">
                            <div class="card card-bordered">
                                <div class="card-inner">
                                    <form @submit.prevent="form.post(route('patient.store'))">
                                        <div class="row g-4">
                                            <div class="col-lg-6">
                                                <FormField label="Name" :class="{ 'text-red-400': form.errors.name }"
                                                    label-for="name">
                                                    <FormControl v-model="form.name" id="name" type="text"
                                                        placeholder="Enter Name" :error="form.errors.name">
                                                        <div class="text-red-400 text-sm" v-if="form.errors.name">
                                                            {{ form.errors.name }}
                                                        </div>
                                                    </FormControl>
                                                </FormField>
                                            </div>
                                            <div class="col-lg-6">
                                                <FormField label="Sex" :class="{ 'text-red-400': form.errors.sex }">
                                                    <FormControl v-model="form.sex" type="select"
                                                        placeholder="-- Select sex --" :error="form.errors.sex"
                                                        :options="item_options">
                                                        <div class="text-red-400 text-sm" v-if="form.errors.sex">
                                                            {{ form.errors.sex }}
                                                        </div>
                                                    </FormControl>
                                                </FormField>
                                            </div>
                                            <div class="col-lg-6">
                                                <FormField label="ID / Passport No."
                                                    :class="{ 'text-red-400': form.errors.id_no }" label-for="id-no">
                                                    <FormControl v-model="form.id_no" type="text" id="id-no"
                                                        placeholder="Enter ID / Passport No" :error="form.errors.id_no">
                                                        <div class="text-red-400 text-sm" v-if="form.errors.id_no">
                                                            {{ form.errors.id_no }}
                                                        </div>
                                                    </FormControl>
                                                </FormField>
                                            </div>
                                            <div class="col-lg-6">
                                                <FormField label="D.O.B (dd/mm/yr)" label-for="dob"
                                                    :class="{ 'text-red-400': form.errors.dob }">
                                                    <FormControl v-model="form.dob" type="text" id="dob"
                                                        placeholder="Enter date of birth" :error="form.errors.dob">
                                                        <div class="text-red-400 text-sm" v-if="form.errors.dob">
                                                            {{ form.errors.dob }}
                                                        </div>
                                                    </FormControl>
                                                </FormField>
                                            </div>
                                            <div class="col-lg-12">
                                                <FormField label="Email" label-for="email"
                                                    :class="{ 'text-red-400': form.errors.email }">
                                                    <FormControl v-model="form.email" type="text" placeholder="Enter Email"
                                                        id="email" :error="form.errors.email">
                                                        <div class="text-red-400 text-sm" v-if="form.errors.email">
                                                            {{ form.errors.email }}
                                                        </div>
                                                    </FormControl>
                                                </FormField>
                                            </div>
                                            <div class="col-lg-6">
                                                <FormField label="Resident County"
                                                    :class="{ 'text-red-400': form.errors.county }">
                                                    <FormControl v-model="form.county" type="select"
                                                        placeholder="-- Select County --" :error="form.errors.county"
                                                        :options="county_options">
                                                        <div class="text-red-400 text-sm" v-if="form.errors.county">
                                                            {{ form.errors.county }}
                                                        </div>
                                                    </FormControl>
                                                </FormField>
                                            </div>
                                            <div class="col-lg-6">
                                                <FormField label="Cellphone" label-for="phone"
                                                    :class="{ 'text-red-400': form.errors.phone }">
                                                    <FormControl v-model="form.phone" type="text" id="phone"
                                                        placeholder="Enter cellphone" :error="form.errors.phone">
                                                        <div class="text-red-400 text-sm" v-if="form.errors.phone">
                                                            {{ form.errors.phone }}
                                                        </div>
                                                    </FormControl>
                                                </FormField>
                                            </div>
                                            <div class="col-lg-6">
                                                <FormField label="Personal Physician if any" label-for="physician"
                                                    :class="{ 'text-red-400': form.errors.physician }">
                                                    <FormControl v-model="form.physician" type="text" id="physician"
                                                        placeholder="Enter Personal Physician"
                                                        :error="form.errors.physician">
                                                        <div class="text-red-400 text-sm" v-if="form.errors.physician">
                                                            {{ form.errors.physician }}
                                                        </div>
                                                    </FormControl>
                                                </FormField>
                                            </div>
                                            <div class="col-lg-6">
                                                <FormField label="Physician Tel" label-for="physician_tel"
                                                    :class="{ 'text-red-400': form.errors.physician_tel }">
                                                    <FormControl v-model="form.physician_tel" type="text" id="physician_tel"
                                                        placeholder="Enter Physician Tel"
                                                        :error="form.errors.physician_tel">
                                                        <div class="text-red-400 text-sm" v-if="form.errors.physician_tel">
                                                            {{ form.errors.physician_tel }}
                                                        </div>
                                                    </FormControl>
                                                </FormField>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <button type="submit" class="btn btn-lg btn-primary" :class="{ 'opacity-25' : form.processing}" :disabled="form.processing">
                                                        <template v-if="form.processing">
                                                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span>Loading...</span>
                                                        </template>
                                                        <template v-else>
                                                            Add Patient
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
