<script setup>
import { Head, Link, useForm } from "@inertiajs/vue3"
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue"
import FormField from '@/Components/FormField.vue'
import FormControl from '@/Components/FormControl.vue'
import Notification from "@/Components/Notification.vue"
import CardAside from "@/Components/CardAside.vue"
import PrimaryButton from '@/Components/PrimaryButton.vue'
import FormCheckRadioGroupNew from '@/Components/FormCheckRadioGroupNew.vue'

const props = defineProps({
    patient: {
        type: Object,
        default: () => ({}),
    },
    treatment_option: {
        type: Object,
        default: [
            { name: 'With treatment', id: 1 },
            { name: 'Without treatment', id: 0 },
        ],
    },
    blood_pressure: {
        type: Object,
        default: () => ({}),
    },
    id: {
        type: Number,
        default: null,
    },
})

const form = useForm({
    _method: 'put',
    systolic: props.blood_pressure.systolic,
    diastolic: props.blood_pressure.diastolic,
    treatment: props.blood_pressure.treatment,
    pulse_rate: props.blood_pressure.pulse_rate,
    systoles: props.blood_pressure.systoles,
    comments: props.blood_pressure.comments
})
</script>

<template>
    <AuthenticatedLayout>

        <Head title="Update blood pressure details" />

        <div class="container-fluid">
            <div class="nk-content-inner">
                <div class="nk-content-body">
                    <div class="nk-block-head nk-block-head-sm">
                        <div class="nk-block-between g-3">
                            <div class="nk-block-head-content">
                                <h3 class="nk-block-title page-title">Patient /
                                    <strong class="text-primary small">{{ props.patient.email }}</strong>
                                </h3>
                            </div>
                            <div class="nk-block-head-content">
                                <Link :href="route('patient.index')"
                                    class="btn btn-outline-light bg-white d-none d-sm-inline-flex">
                                <em class="icon ni ni-arrow-left"></em>
                                <span>Back</span>
                                </Link>
                                <Link :href="route('patient.index')"
                                    class="btn btn-icon btn-outline-light bg-white d-inline-flex d-sm-none">
                                <em class="icon ni ni-arrow-left"></em>
                                </Link>
                            </div>
                        </div>
                    </div>
                    <div class="nk-block">
                        <div class="card card-bordered">
                            <CardAside title="Blood pressure"
                                :description="`Blood pressure information on ` + $page.props.appName + `.`"
                                :patient="props.patient">

                                <div class="nk-block-content">
                                    <form
                                        @submit.prevent="form.post(route('blood-pressure.update', props.blood_pressure.id), { preserveScroll: true })">
                                        <div class="gy-3 row">
                                            <div class="col-lg-3">
                                                <FormField label="Systolic" label-for="systolic"
                                                    :class="{ 'text-red-400': form.errors.systolic }">
                                                    <FormControl v-model="form.systolic" id="systolic" type="text"
                                                        placeholder="Enter Systolic" :error="form.errors.systolic">
                                                        <div class="text-red-400 text-sm" v-if="form.errors.systolic">
                                                            {{ form.errors.systolic }}
                                                        </div>
                                                    </FormControl>
                                                </FormField>
                                            </div>
                                            <div class="col-lg-3">
                                                <FormField label="Diastolic" label-for="diastolic"
                                                    :class="{ 'text-red-400': form.errors.diastolic }">
                                                    <FormControl v-model="form.diastolic" type="text" id="diastolic"
                                                        placeholder="Diastolic" :error="form.errors.diastolic">
                                                        <div class="text-red-400 text-sm" v-if="form.errors.diastolic">
                                                            {{ form.errors.diastolic }}
                                                        </div>
                                                    </FormControl>
                                                </FormField>
                                            </div>
                                            <div class="col-lg-6">
                                                <FormField label="Treatment" wrap-body>
                                                    <FormCheckRadioGroupNew v-model="form.treatment" type="radio"
                                                        name="treatment" :options="treatment_option" />
                                                </FormField>
                                            </div>
                                            <div class="col-lg-6">
                                                <FormField label="Pulse Rate" label-for="pulse_rate"
                                                    :class="{ 'text-red-400': form.errors.pulse_rate }">
                                                    <FormControl v-model="form.pulse_rate" id="pulse_rate" type="text"
                                                        placeholder="Enter pulse rate" :error="form.errors.pulse_rate">
                                                        <div class="text-red-400 text-sm" v-if="form.errors.pulse_rate">
                                                            {{ form.errors.pulse_rate }}
                                                        </div>
                                                    </FormControl>
                                                </FormField>
                                            </div>
                                            <div class="col-lg-6">
                                                <FormField label="Extra systoles" label-for="systoles"
                                                    :class="{ 'text-red-400': form.errors.systoles }">
                                                    <FormControl v-model="form.systoles" id="systoles" type="text"
                                                        placeholder="Enter extra systoles" :error="form.errors.systoles">
                                                        <div class="text-red-400 text-sm" v-if="form.errors.systoles">
                                                            {{ form.errors.systoles }}
                                                        </div>
                                                    </FormControl>
                                                </FormField>
                                            </div>
                                            <div class="col-12">
                                                <Notification v-if="$page.props.flash.message" icon="ni-check-circle"
                                                    color="alert-success" alert-dismissible alert-fill>
                                                    {{ $page.props.flash.message }}
                                                </Notification>
                                            </div>
                                            <div class="col-12">
                                                <PrimaryButton class="btn btn-lg btn-primary"
                                                    :class="{ 'opacity-5': form.processing }" :disabled="form.processing">
                                                    <template v-if="form.processing"><span
                                                            class="spinner-border spinner-border-sm" role="status"
                                                            aria-hidden="true"></span> <span>Loading...</span></template>
                                                    <template v-else>Update Patient</template>
                                                </PrimaryButton>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </CardAside>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
