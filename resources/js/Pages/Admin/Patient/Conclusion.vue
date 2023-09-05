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
    item_options: {
        type: Object,
        default: [
            { name: 'GOOD', id: 1 },
            { name: 'AVERAGE', id: 2 },
            { name: 'POOR', id: 3 },
        ],
    },
    options: {
        type: Object,
        default: [
            { name: 'Yes', id: 1 },
            { name: 'No', id: 0 },
        ],
    },
})

const form = useForm({
    longevity: props.patient.longevity,
    disability: props.patient.disability,
    comments: props.patient.comments,
    health: props.patient.health,
    recommendation: props.patient.recommendation,
    conclusion: props.patient.conclusion
})
</script>

<template>
    <AuthenticatedLayout>

        <Head title="Conclusion" />

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
                            <CardAside title="Conclusions/ Recommendations"
                                :description="`Conclusion information on ` + $page.props.appName + `.`"
                                :patient="props.patient">

                                <div class="nk-block-content">
                                    <form
                                        @submit.prevent="form.post(route('admin.examination.conclusion.store', props.patient.id), { preserveScroll: true })">
                                        <div class="gy-3">
                                            <div class="g-item">
                                                <div class="custom-control custom-switch">
                                                    <input type="checkbox" class="custom-control-input"
                                                        v-model="form.longevity" id="longevity" :true-value="1"
                                                        :false-value="0">
                                                    <label class="custom-control-label" for="longevity">Do you have any
                                                        reserves concerning the longevity of the examinee?</label>
                                                </div>
                                            </div>
                                            <div class="g-item">
                                                <div class="custom-control custom-switch">
                                                    <input type="checkbox" class="custom-control-input" id="disability"
                                                        :true-value="1" :false-value="0" v-model="form.disability">
                                                    <label class="custom-control-label" for="disability">Are there any risks
                                                        on invalidity or partial, or total disability?
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="g-item">
                                                <FormField label="Comments" label-for="comments"
                                                    :class="{ 'text-red-400': form.errors.comments }">
                                                    <FormControl v-model="form.comments" id="comments" type="textarea"
                                                        placeholder="Enter comments" :error="form.errors.comments">
                                                        <div class="text-red-400 text-sm" v-if="form.errors.comments">
                                                            {{ form.errors.comments }}
                                                        </div>
                                                    </FormControl>
                                                </FormField>
                                            </div>
                                            <div class="g-item">
                                                <FormField wrap-body
                                                    label="The proposer’s state of health is Considered to be:">
                                                    <FormCheckRadioGroupNew v-model="form.health" type="radio" name="health"
                                                        is-column :options="item_options" />
                                                </FormField>
                                            </div>
                                            <div class="g-item">
                                                <FormField label="Conclusion"
                                                    :class="{ 'text-red-400': form.errors.conclusion }">
                                                    <FormControl v-model="form.conclusion" type="textarea"
                                                        :error="form.errors.conclusion">
                                                        <div class="text-red-400 text-sm" v-if="form.errors.conclusion">
                                                            {{ form.errors.conclusion }}
                                                        </div>
                                                    </FormControl>
                                                </FormField>
                                            </div>
                                            <div class="g-item">
                                                <FormField label="Recommendation"
                                                    :class="{ 'text-red-400': form.errors.recommendation }">
                                                    <FormControl v-model="form.recommendation" type="textarea"
                                                        :error="form.errors.recommendation">
                                                        <div class="text-red-400 text-sm" v-if="form.errors.recommendation">
                                                            {{ form.errors.recommendation }}
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
