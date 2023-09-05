<script setup>
import { Head, Link, useForm } from "@inertiajs/vue3"
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue"
import FormField from '@/Components/FormField.vue'
import FormControl from '@/Components/FormControl.vue'
import Notification from "@/Components/Notification.vue"
import CardAside from "@/Components/CardAside.vue"
import PrimaryButton from '@/Components/PrimaryButton.vue'

const props = defineProps({
    patient: {
        type: Object,
        default: () => ({}),
    },
    genito_urinary: {
        type: Object,
        default: () => ({}),
    },
    options: {
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
    history: props.genito_urinary.history,
    genitals_male: props.genito_urinary.genitals_male,
    gynaecomastia: props.genito_urinary.gynaecomastia,
    genital_sores: props.genito_urinary.genital_sores,
    genitals_female: props.genito_urinary.genitals_female,
    breast: props.genito_urinary.breast,
    menstrual: props.genito_urinary.menstrual,
    comments: props.genito_urinary.comments
})
</script>

<template>
    <AuthenticatedLayout>

        <Head title="Update genital urinary system details" />

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
                            <CardAside title="Genito Urinary System"
                                :description="`Genito Urinary system information on ` + $page.props.appName + `.`"
                                :patient="props.patient">

                                <div class="nk-block-content">
                                    <form
                                        @submit.prevent="form.post(route('genito-urinary-system.update', props.genito_urinary.id), { preserveScroll: true })">
                                        <div class="gy-3">
                                            <div class="g-item">
                                                <div class="custom-control custom-switch">
                                                    <input type="checkbox" class="custom-control-input"
                                                        v-model="form.history" id="history" :true-value="1"
                                                        :false-value="0">
                                                    <label class="custom-control-label" for="history">Previous
                                                        history?</label>
                                                </div>
                                            </div>
                                            <div class="g-item">
                                                <div class="custom-control custom-switch">
                                                    <input type="checkbox" class="custom-control-input" id="genital_sores"
                                                        :true-value="1" :false-value="0" v-model="form.genital_sores">
                                                    <label class="custom-control-label" for="genital_sores">Genital sores
                                                    </label>
                                                </div>
                                            </div>
                                            <h6 class="pt-3">Male:</h6>
                                            <div class="g-item">
                                                <div class="custom-control custom-switch">
                                                    <input type="checkbox" class="custom-control-input" :true-value="1"
                                                        :false-value="0" v-model="form.genitals_male" id="genitals_male">
                                                    <label class="custom-control-label" for="genitals_male">Are there any
                                                        signs of disease of the genital organs (testis, epididymes,
                                                        prostate)?</label>
                                                </div>
                                            </div>
                                            <div class="g-item">
                                                <div class="custom-control custom-switch">
                                                    <input type="checkbox" class="custom-control-input" id="gynaecomastia"
                                                        :true-value="1" :false-value="0" v-model="form.gynaecomastia">
                                                    <label class="custom-control-label" for="gynaecomastia">Is there
                                                        gynaecomastia?</label>
                                                </div>
                                            </div>
                                            <h6 class="pt-3">Female</h6>
                                            <div class="g-item">
                                                <div class="custom-control custom-switch">
                                                    <input type="checkbox" class="custom-control-input" :true-value="1"
                                                        :false-value="0" v-model="form.genitals_female"
                                                        id="genitals_female">
                                                    <label class="custom-control-label" for="genitals_female">Are there any
                                                        signs of disease of the genital organs?</label>
                                                </div>
                                            </div>
                                            <div class="g-item">
                                                <div class="custom-control custom-switch">
                                                    <input type="checkbox" class="custom-control-input" :true-value="1"
                                                        :false-value="0" id="abnormalities_hernial_orifices"
                                                        v-model="form.abnormalities_hernial_orifices">
                                                    <label class="custom-control-label"
                                                        for="abnormalities_hernial_orifices">Are there any abnormalities of
                                                        the hernial orifices?</label>
                                                </div>
                                            </div>
                                            <div class="g-item">
                                                <div class="custom-control custom-switch">
                                                    <input type="checkbox" class="custom-control-input" :true-value="1"
                                                        :false-value="0" v-model="form.breast" id="breast">
                                                    <label class="custom-control-label" for="breast">Are there any
                                                        abnormalities of the breast?</label>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <FormField label="Last normal menstrual period?" label-for="menstrual"
                                                    :class="{ 'text-red-400': form.errors.menstrual }">
                                                    <FormControl v-model="form.menstrual" type="text" id="menstrual"
                                                        placeholder="Menstrual period" :error="form.errors.menstrual">
                                                        <div class="text-red-400 text-sm" v-if="form.errors.menstrual">
                                                            {{ form.errors.menstrual }}
                                                        </div>
                                                    </FormControl>
                                                </FormField>
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
