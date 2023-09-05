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
    cardiovascular: {
        type: Object,
        default: () => ({}),
    },
    heart_option: {
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
    blood_pressure: props.cardiovascular.blood_pressure,
    breath: props.cardiovascular.breath,
    palp: props.cardiovascular.palp,
    history: props.cardiovascular.history,
    heart_enlarged: props.cardiovascular.heart_enlarged,
    heart_sounds: props.cardiovascular.heart_sounds,
    cadiac_murmurs: props.cardiovascular.cadiac_murmurs,
    murmur_pathological: props.cardiovascular.murmur_pathological,
    murmur_irradiate: props.cardiovascular.murmur_irradiate,
    maximal_intensity: props.cardiovascular.maximal_intensity,
    abdominal_aorta_dilated: props.cardiovascular.abdominal_aorta_dilated,
    peripheral_pulses: props.cardiovascular.peripheral_pulses,
    arterial_bruits: props.cardiovascular.arterial_bruits,
    comments: props.cardiovascular.comments
})
</script>

<template>
    <AuthenticatedLayout>

        <Head title="Update cardiovascular system details" />

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
                            <CardAside title="Cardiovascular System"
                                :description="`Cardiovascular system information on ` + $page.props.appName + `.`"
                                :patient="props.patient">

                                <div class="nk-block-content">
                                    <form
                                        @submit.prevent="form.post(route('cardiovascular-system.update', props.cardiovascular.id), { preserveScroll: true })">
                                        <div class="gy-3">
                                            <div class="g-item">
                                                <div class="custom-control custom-switch">
                                                    <input type="checkbox" class="custom-control-input"
                                                        v-model="form.blood_pressure" id="blood_pressure" :true-value="1"
                                                        :false-value="0">
                                                    <label class="custom-control-label" for="blood_pressure">High Blood
                                                        pressure</label>
                                                </div>
                                            </div>
                                            <div class="g-item">
                                                <div class="custom-control custom-switch">
                                                    <input type="checkbox" class="custom-control-input" id="breath"
                                                        :true-value="1" :false-value="0" v-model="form.breath">
                                                    <label class="custom-control-label" for="breath">Shortness of
                                                        breath</label>
                                                </div>
                                            </div>
                                            <div class="g-item">
                                                <div class="custom-control custom-switch">
                                                    <input type="checkbox" class="custom-control-input" :true-value="1"
                                                        :false-value="0" v-model="form.palp" id="palp">
                                                    <label class="custom-control-label" for="palp">Palp Hatious</label>
                                                </div>
                                            </div>
                                            <div class="g-item">
                                                <div class="custom-control custom-switch">
                                                    <input type="checkbox" class="custom-control-input" id="history"
                                                        :true-value="1" :false-value="0" v-model="form.history">
                                                    <label class="custom-control-label" for="history">Previous
                                                        history</label>
                                                </div>
                                            </div>
                                            <div class="g-item">
                                                <div class="custom-control custom-switch">
                                                    <input type="checkbox" class="custom-control-input" :true-value="1"
                                                        :false-value="0" v-model="form.heart_enlarged" id="heart_enlarged">
                                                    <label class="custom-control-label" for="heart_enlarged">Is the heart
                                                        enlarged?</label>
                                                </div>
                                            </div>
                                            <div class="g-item">
                                                <div class="custom-control custom-switch">
                                                    <input type="checkbox" class="custom-control-input" :true-value="1"
                                                        :false-value="0" id="heart_sounds" v-model="form.heart_sounds">
                                                    <label class="custom-control-label" for="heart_sounds">Are the heart
                                                        sounds normal? (intensity, splitting, etc)</label>
                                                </div>
                                            </div>
                                            <div class="g-item">
                                                <div class="custom-control custom-switch">
                                                    <input type="checkbox" class="custom-control-input" :true-value="1"
                                                        :false-value="0" v-model="form.cadiac_murmurs" id="cadiac_murmurs">
                                                    <label class="custom-control-label" for="cadiac_murmurs">Are there any
                                                        cadiac murmurs?</label>
                                                </div>
                                            </div>
                                            <div class="g-item">
                                                <div class="custom-control custom-switch">
                                                    <input type="checkbox" class="custom-control-input"
                                                        id="murmur_pathological" :true-value="1" :false-value="0"
                                                        v-model="form.murmur_pathological">
                                                    <label class="custom-control-label" for="murmur_pathological">Does the
                                                        murmur seem to be pathological?</label>
                                                </div>
                                            </div>
                                            <div class="g-item">
                                                <div class="custom-control custom-switch">
                                                    <input type="checkbox" class="custom-control-input" :true-value="1"
                                                        :false-value="0" v-model="form.murmur_irradiate"
                                                        id="murmur_irradiate">
                                                    <label class="custom-control-label" for="murmur_irradiate">Does the
                                                        murmur irradiate?</label>
                                                </div>
                                            </div>
                                            <div class="g-item">
                                                <div class="custom-control custom-switch">
                                                    <input type="checkbox" class="custom-control-input" :true-value="1"
                                                        :false-value="0" id="maximal_intensity"
                                                        v-model="form.maximal_intensity">
                                                    <label class="custom-control-label" for="maximal_intensity">Where is the
                                                        maximal intensity?</label>
                                                </div>
                                            </div>
                                            <div class="g-item">
                                                <div class="custom-control custom-switch">
                                                    <input type="checkbox" class="custom-control-input" :true-value="1"
                                                        :false-value="0" v-model="form.abdominal_aorta_dilated"
                                                        id="abdominal_aorta_dilated">
                                                    <label class="custom-control-label" for="abdominal_aorta_dilated">Does
                                                        the abdominal aorta seem dilated?</label>
                                                </div>
                                            </div>
                                            <div class="g-item">
                                                <div class="custom-control custom-switch">
                                                    <input type="checkbox" class="custom-control-input"
                                                        id="peripheral_pulses" :true-value="1" :false-value="0"
                                                        v-model="form.peripheral_pulses">
                                                    <label class="custom-control-label" for="peripheral_pulses">Are the
                                                        peripheral pulses all present and Symmetrical?</label>
                                                </div>
                                            </div>
                                            <div class="g-item">
                                                <div class="custom-control custom-switch">
                                                    <input type="checkbox" class="custom-control-input" :true-value="1"
                                                        :false-value="0" v-model="form.arterial_bruits"
                                                        id="arterial_bruits">
                                                    <label class="custom-control-label" for="arterial_bruits">Are there any
                                                        arterial bruits in the cervical And femoral regions?</label>
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
