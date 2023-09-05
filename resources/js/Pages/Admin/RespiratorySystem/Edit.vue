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
    respiratory_system: {
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
    history: props.respiratory_system.history,
    pneumonia: props.respiratory_system.pneumonia,
    bronchial_asthma: props.respiratory_system.bronchial_asthma,
    tb: props.respiratory_system.tb,
    chest_expansion: props.respiratory_system.chest_expansion,
    abnormal_dullness: props.respiratory_system.abnormal_dullness,
    abnormal_auscultatory: props.respiratory_system.abnormal_auscultatory,
    voice: props.respiratory_system.voice,
    goitre: props.respiratory_system.goitre,
    comments: props.respiratory_system.comments
})

</script>

<template>
    <AuthenticatedLayout>

        <Head title="Update respiratory system details" />

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
                            <CardAside title="Respiratory System"
                                :description="`Respiratory information on ` + $page.props.appName + `.`"
                                :patient="props.patient">

                                <div class="nk-block-content">
                                    <form
                                        @submit.prevent="form.post(route('respiratory-system.update', props.patient.id), { preserveScroll: true })">
                                        <div class="gy-3">
                                            <div class="g-item">
                                                <div class="custom-control custom-switch">
                                                    <input type="checkbox" class="custom-control-input"
                                                        v-model="form.history" id="history" :true-value="1"
                                                        :false-value="0">
                                                    <label class="custom-control-label" for="history">Previous
                                                        history? </label>
                                                </div>
                                            </div>
                                            <div class="g-item">
                                                <div class="custom-control custom-switch">
                                                    <input type="checkbox" class="custom-control-input" id="pneumonia"
                                                        :true-value="1" :false-value="0" v-model="form.pneumonia">
                                                    <label class="custom-control-label" for="pneumonia">Pneumonia</label>
                                                </div>
                                            </div>
                                            <div class="g-item">
                                                <div class="custom-control custom-switch">
                                                    <input type="checkbox" class="custom-control-input" :true-value="1"
                                                        :false-value="0" v-model="form.bronchial_asthma"
                                                        id="bronchial_asthma">
                                                    <label class="custom-control-label" for="bronchial_asthma">Bronchial
                                                        asthma</label>
                                                </div>
                                            </div>
                                            <div class="g-item">
                                                <div class="custom-control custom-switch">
                                                    <input type="checkbox" class="custom-control-input" id="tb"
                                                        :true-value="1" :false-value="0" v-model="form.tb">
                                                    <label class="custom-control-label" for="tb">TB(unexplained
                                                        persistent night sweat)</label>
                                                </div>
                                            </div>
                                            <div class="g-item">
                                                <div class="custom-control custom-switch">
                                                    <input type="checkbox" class="custom-control-input" :true-value="1"
                                                        :false-value="0" v-model="form.chest_expansion"
                                                        id="chest_expansion">
                                                    <label class="custom-control-label" for="chest_expansion">Are there
                                                        signs
                                                        of decreased chest expansion?</label>
                                                </div>
                                            </div>
                                            <div class="g-item">
                                                <div class="custom-control custom-switch">
                                                    <input type="checkbox" class="custom-control-input" :true-value="1"
                                                        :false-value="0" id="abnormal_dullness"
                                                        v-model="form.abnormal_dullness">
                                                    <label class="custom-control-label" for="abnormal_dullness">Are there
                                                        signs of
                                                        abnormal dullness to percussion?</label>
                                                </div>
                                            </div>
                                            <div class="g-item">
                                                <div class="custom-control custom-switch">
                                                    <input type="checkbox" class="custom-control-input" :true-value="1"
                                                        :false-value="0" v-model="form.abnormal_auscultatory"
                                                        id="abnormal_auscultatory">
                                                    <label class="custom-control-label" for="abnormal_auscultatory">Are
                                                        there
                                                        abnormal auscultatory signs?</label>
                                                </div>
                                            </div>
                                            <div class="g-item">
                                                <div class="custom-control custom-switch">
                                                    <input type="checkbox" class="custom-control-input" id="voice"
                                                        :true-value="1" :false-value="0" v-model="form.voice">
                                                    <label class="custom-control-label" for="voice">Is the voice
                                                        normal?</label>
                                                </div>
                                            </div>
                                            <div class="g-item">
                                                <div class="custom-control custom-switch">
                                                    <input type="checkbox" class="custom-control-input" :true-value="1"
                                                        :false-value="0" v-model="form.goitre" id="goitre">
                                                    <label class="custom-control-label" for="goitre"><b>NECK:</b> Is
                                                        there evidence of goitre?</label>
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
