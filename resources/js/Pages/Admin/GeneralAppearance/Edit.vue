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
    general_appearance: {
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
    height: props.general_appearance.height,
    waist: props.general_appearance.waist,
    weight: props.general_appearance.weight,
    hip: props.general_appearance.hip,
    bmi: props.general_appearance.bmi,
    age: props.general_appearance.age,
    morphological: props.general_appearance.morphological,
    mutations: props.general_appearance.mutations,
    stigmata: props.general_appearance.stigmata,
    state_health: props.general_appearance.state_health,
    comments: props.general_appearance.comments
})
</script>

<template>
    <AuthenticatedLayout>

        <Head title="Update general appearance details" />

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
                            <CardAside title="General appearance"
                                :description="`General appearance information on ` + $page.props.appName + `.`"
                                :patient="props.patient">

                                <div class="nk-block-content">
                                    <form
                                        @submit.prevent="form.post(route('general-appearance.update', props.general_appearance.id), { preserveScroll: true })">
                                        <div class="gy-3 row">
                                            <div class="col-lg-6">
                                                <FormField label="Height" label-for="height"
                                                    :class="{ 'text-red-400': form.errors.height }">
                                                    <FormControl v-model="form.height" type="text" id="height"
                                                        placeholder="Height in cm" :error="form.errors.height">
                                                        <div class="text-red-400 text-sm" v-if="form.errors.height">
                                                            {{ form.errors.height }}
                                                        </div>
                                                    </FormControl>
                                                </FormField>
                                            </div>
                                            <div class="col-lg-6">
                                                <FormField label="Waist measurement" label-for="waist"
                                                    :class="{ 'text-red-400': form.errors.waist }">
                                                    <FormControl v-model="form.waist" type="text" id="waist"
                                                        placeholder="Waist in cm" :error="form.errors.waist">
                                                        <div class="text-red-400 text-sm" v-if="form.errors.waist">
                                                            {{ form.errors.waist }}
                                                        </div>
                                                    </FormControl>
                                                </FormField>
                                            </div>
                                            <div class="col-lg-4">
                                                <FormField label="Weight" label-for="weight"
                                                    :class="{ 'text-red-400': form.errors.weight }">
                                                    <FormControl v-model="form.weight" type="text" id="weight"
                                                        placeholder="Weight in kg" :error="form.errors.weight">
                                                        <div class="text-red-400 text-sm" v-if="form.errors.weight">
                                                            {{ form.errors.weight }}
                                                        </div>
                                                    </FormControl>
                                                </FormField>
                                            </div>
                                            <div class="col-lg-4">
                                                <FormField label="Hip measurement" label-for="hip"
                                                    :class="{ 'text-red-400': form.errors.hip }">
                                                    <FormControl v-model="form.hip" type="text" id="hip"
                                                        placeholder="Hip in cm" :error="form.errors.hip">
                                                        <div class="text-red-400 text-sm" v-if="form.errors.hip">
                                                            {{ form.errors.hip }}
                                                        </div>
                                                    </FormControl>
                                                </FormField>
                                            </div>
                                            <div class="col-lg-4">
                                                <FormField label="BMI" label-for="bmi"
                                                    :class="{ 'text-red-400': form.errors.bmi }">
                                                    <FormControl v-model="form.bmi" id="bmi" type="text" placeholder="BMI"
                                                        :error="form.errors.bmi">
                                                        <div class="text-red-400 text-sm" v-if="form.errors.bmi">
                                                            {{ form.errors.bmi }}
                                                        </div>
                                                    </FormControl>
                                                </FormField>
                                            </div>
                                            <div class="col-12">
                                                <FormField label="Healthy, looks declared age?" label-for="age"
                                                    :class="{ 'text-red-400': form.errors.age }">
                                                    <FormControl v-model="form.age" id="age" type="text" placeholder="Age"
                                                        :error="form.errors.age">
                                                        <div class="text-red-400 text-sm" v-if="form.errors.age">
                                                            {{ form.errors.age }}
                                                        </div>
                                                    </FormControl>
                                                </FormField>
                                            </div>
                                            <div class="col-12">
                                                <FormField label="Morphological type?" label-for="morphological"
                                                    :class="{ 'text-red-400': form.errors.morphological }">
                                                    <FormControl v-model="form.morphological" id="morphological" type="text"
                                                        placeholder="Morphological type" :error="form.errors.morphological">
                                                        <div class="text-red-400 text-sm" v-if="form.errors.morphological">
                                                            {{ form.errors.morphological }}
                                                        </div>
                                                    </FormControl>
                                                </FormField>
                                            </div>
                                            <div class="g-item">
                                                <div class="custom-control custom-switch">
                                                    <input type="checkbox" class="custom-control-input" id="mutations"
                                                        :true-value="1" :false-value="0" v-model="form.mutations">
                                                    <label class="custom-control-label" for="mutations">Are there any
                                                        malformations or mutations?</label>
                                                </div>
                                            </div>
                                            <div class="g-item">
                                                <div class="custom-control custom-switch">
                                                    <input type="checkbox" class="custom-control-input" id="stigmata"
                                                        :true-value="1" :false-value="0" v-model="form.stigmata">
                                                    <label class="custom-control-label" for="stigmata">Are there any
                                                        stigmata of alcohol, tobacco, or drug abuse?
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="g-item">
                                                <div class="custom-control custom-switch">
                                                    <input type="checkbox" class="custom-control-input" :true-value="1"
                                                        :false-value="0" v-model="form.state_health" id="state_health">
                                                    <label class="custom-control-label" for="state_health">Are there any
                                                        repercussions of the proper’s professional or social activities on
                                                        the general state of health?</label>
                                                </div>
                                            </div>
                                            <div class="col-12">
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
