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
    medical_history: {
        type: Object,
        default: () => ({}),
    },
    options: {
        type: Object,
        default: [
            { name: 'Diabetes', id: 1 },
            { name: 'Hypertension', id: 2 },
            { name: 'Asthma', id: 3 },
            { name: 'Cancer', id: 4 },
            { name: 'HIV', id: 5 },
        ],
    },
    other_options: {
        type: Object,
        default: [
            { name: 'Yes', id: 1 },
            { name: 'No', id: 0 },
        ],
    },
    id: {
        type: Number,
        default: null,
    },
})

const form = useForm({
    _method: 'put',
    admission: props.medical_history.admission,
    chronic_illness: props.medical_history.chronic_illness,
    medical_treatment: props.medical_history.medical_treatment,
    medical_treatment_which: props.medical_history.medical_treatment_which,
    medical_treatment_when: props.medical_history.medical_treatment_when,
    blood_transfusion: props.medical_history.blood_transfusion
})
</script>

<template>
    <AuthenticatedLayout>

        <Head title="Update past medical history details" />

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
                            <CardAside title="Past medical history"
                                :description="`Past medical history information on ` + $page.props.appName + `.`"
                                :patient="props.patient">

                                <div class="nk-block-content">
                                    <form
                                        @submit.prevent="form.post(route('past-medical-history.update', props.medical_history.id), { preserveScroll: true })">
                                        <div class="gy-3">
                                            <div class="col-12">
                                                <FormField label="Prior hospital admission" label-for="admission"
                                                    :class="{ 'text-red-400': form.errors.admission }">
                                                    <FormControl v-model="form.admission" type="input" id="admission"
                                                        placeholder="Prior hospital admission"
                                                        :error="form.errors.admission">
                                                        <div class="text-red-400 text-sm" v-if="form.errors.admission">
                                                            {{ form.errors.admission }}
                                                        </div>
                                                    </FormControl>
                                                </FormField>
                                            </div>
                                            <div class="col-12 pb-4">
                                                <FormField label="Any chronic illness-" wrap-body>
                                                    <FormCheckRadioGroupNew v-model="form.chronic_illness" name="chronic_illness"
                                                        :options="options" />
                                                </FormField>
                                            </div>
                                            <div class="g-item">
                                                <div class="custom-control custom-switch">
                                                    <input type="checkbox" class="custom-control-input"
                                                        v-model="form.medical_treatment" id="medical_treatment"
                                                        :true-value="1" :false-value="0">
                                                    <label class="custom-control-label" for="medical_treatment">Is the
                                                        examinee currently under medical treatment</label>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <FormField label="If yes specify" label-for="medical_treatment_which"
                                                        :class="{ 'text-red-400': form.errors.medical_treatment_which }">
                                                        <FormControl v-model="form.medical_treatment_which" type="input"
                                                            id="medical_treatment_which" placeholder="If yes specify"
                                                            :error="form.errors.medical_treatment_which">
                                                            <div class="text-red-400 text-sm"
                                                                v-if="form.errors.medical_treatment_which">
                                                                {{ form.errors.medical_treatment_which }}
                                                            </div>
                                                        </FormControl>
                                                    </FormField>
                                                </div>
                                                <div class="col-lg-6">
                                                    <FormField label="Since when" label-for="medical_treatment_when"
                                                        :class="{ 'text-red-400': form.errors.medical_treatment_when }">
                                                        <FormControl v-model="form.medical_treatment_when" type="input"
                                                            id="medical_treatment_when" placeholder="Since when"
                                                            :error="form.errors.medical_treatment_when">
                                                            <div class="text-red-400 text-sm"
                                                                v-if="form.errors.medical_treatment_when">
                                                                {{ form.errors.medical_treatment_when }}
                                                            </div>
                                                        </FormControl>
                                                    </FormField>
                                                </div>
                                            </div>
                                            <div class="g-item">
                                                <div class="custom-control custom-switch">
                                                    <input type="checkbox" class="custom-control-input"
                                                        id="blood_transfusion" :true-value="1" :false-value="0"
                                                        v-model="form.blood_transfusion">
                                                    <label class="custom-control-label" for="blood_transfusion">Have you
                                                        ever received blood transfusion?
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <FormField label="Comments" label-for="comments"
                                                    :class="{ 'text-red-400': form.errors.comments }">
                                                    <FormControl v-model="form.comments" type="textarea" id="comments"
                                                        placeholder="Doctor comments" :error="form.errors.comments">
                                                        <div class="text-red-400 text-sm" v-if="form.errors.comments">
                                                            {{ form.errors.comments }}
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
