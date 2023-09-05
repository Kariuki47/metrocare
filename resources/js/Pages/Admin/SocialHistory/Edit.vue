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
    social_history: {
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
    marital_status: props.social_history.marital_status,
    no_children: props.social_history.no_children,
    profession: props.social_history.profession,
    units_alcohol: props.social_history.units_alcohol,
    no_cigarettes: props.social_history.no_cigarettes,
    duration_smoking: props.social_history.duration_smoking,
    menstrual_cycle: props.social_history.menstrual_cycle,
    contraception: props.social_history.contraception
})
</script>

<template>
    <AuthenticatedLayout>

        <Head title="Update social history details" />

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
                            <CardAside title="Social history"
                                :description="`Social history information on ` + $page.props.appName + `.`"
                                :patient="props.patient">

                                <div class="nk-block-content">
                                    <form
                                        @submit.prevent="form.post(route('social-history.update', props.social_history.id), { preserveScroll: true })">
                                        <div class="gy-3 row">
                                            <div class="col-12">
                                                <FormField label="Marital status" label-for="marital_status"
                                                    :class="{ 'text-red-400': form.errors.marital_status }">
                                                    <FormControl v-model="form.marital_status" type="input"
                                                        id="marital_status" placeholder="Marital status"
                                                        :error="form.errors.marital_status">
                                                        <div class="text-red-400 text-sm" v-if="form.errors.marital_status">
                                                            {{ form.errors.marital_status }}
                                                        </div>
                                                    </FormControl>
                                                    <div>(Where applicable, cause of death of spouse)</div>
                                                </FormField>
                                            </div>
                                            <div class="col-lg-6">
                                                <FormField label="Number of children" label-for="no_children"
                                                    :class="{ 'text-red-400': form.errors.no_children }">
                                                    <FormControl v-model="form.no_children" type="input" id="no_children"
                                                        placeholder="No. of children" :error="form.errors.no_children">
                                                        <div class="text-red-400 text-sm" v-if="form.errors.no_children">
                                                            {{ form.errors.no_children }}
                                                        </div>
                                                    </FormControl>
                                                </FormField>
                                            </div>
                                            <div class="col-lg-6">
                                                <FormField label="Profession" label-for="profession"
                                                    :class="{ 'text-red-400': form.errors.profession }">
                                                    <FormControl v-model="form.profession" type="input" id="profession"
                                                        placeholder="Profession" :error="form.errors.profession">
                                                        <div class="text-red-400 text-sm" v-if="form.errors.profession">
                                                            {{ form.errors.profession }}
                                                        </div>
                                                    </FormControl>
                                                </FormField>
                                            </div>
                                            <h6 class="pt-4">(i) HABITS</h6>
                                            <div class="col-12">
                                                <FormField label="Units of alcohol/sitting" label-for="units_alcohol"
                                                    :class="{ 'text-red-400': form.errors.units_alcohol }">
                                                    <FormControl v-model="form.units_alcohol" type="input"
                                                        id="units_alcohol" placeholder="Units of alcohol/sitting"
                                                        :error="form.errors.units_alcohol">
                                                        <div class="text-red-400 text-sm" v-if="form.errors.units_alcohol">
                                                            {{ form.errors.units_alcohol }}
                                                        </div>
                                                    </FormControl>
                                                </FormField>
                                            </div>
                                            <div class="col-lg-6">
                                                <FormField label="No. of cigarettes/day" label-for="no_cigarettes"
                                                    :class="{ 'text-red-400': form.errors.no_cigarettes }">
                                                    <FormControl v-model="form.no_cigarettes" type="input"
                                                        id="no_cigarettes" placeholder="No. of cigarettes/day"
                                                        :error="form.errors.no_cigarettes">
                                                        <div class="text-red-400 text-sm" v-if="form.errors.no_cigarettes">
                                                            {{ form.errors.no_cigarettes }}
                                                        </div>
                                                    </FormControl>
                                                </FormField>
                                            </div>
                                            <div class="col-lg-6">
                                                <FormField label="Duration of smoking" label-for="duration_smoking"
                                                    :class="{ 'text-red-400': form.errors.duration_smoking }">
                                                    <FormControl v-model="form.duration_smoking" type="input"
                                                        id="duration_smoking" placeholder="Duration of smoking"
                                                        :error="form.errors.duration_smoking">
                                                        <div class="text-red-400 text-sm"
                                                            v-if="form.errors.duration_smoking">
                                                            {{ form.errors.duration_smoking }}
                                                        </div>
                                                    </FormControl>
                                                </FormField>
                                            </div>
                                            <h6 class="pt-4">(ii) If female:-</h6>
                                            <div class="col-12">
                                                <FormField label="Menstrual cycle – duration, flow, abnormality" label-for="menstrual_cycle"
                                                    :class="{ 'text-red-400': form.errors.menstrual_cycle }">
                                                    <FormControl v-model="form.menstrual_cycle" type="text" id="menstrual_cycle"
                                                        placeholder="Menstrual cycle – duration, flow, abnormality"
                                                        :error="form.errors.menstrual_cycle">
                                                        <div class="text-red-400 text-sm"
                                                            v-if="form.errors.menstrual_cycle">
                                                            {{ form.errors.menstrual_cycle }}
                                                        </div>
                                                    </FormControl>
                                                </FormField>
                                            </div>
                                            <div class="col-12">
                                                <FormField label="Contraception history" label-for="contraception"
                                                    :class="{ 'text-red-400': form.errors.contraception }">
                                                    <FormControl v-model="form.contraception" type="text" id="contraception"
                                                        placeholder="Contraception history"
                                                        :error="form.errors.contraception">
                                                        <div class="text-red-400 text-sm" v-if="form.errors.contraception">
                                                            {{ form.errors.contraception }}
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
