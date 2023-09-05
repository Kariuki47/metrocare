<script setup>
import { Head, Link, useForm } from "@inertiajs/vue3"
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue"
import FormField from '@/Components/FormField.vue'
import Notification from "@/Components/Notification.vue"
import CardAside from "@/Components/CardAside.vue"
import PrimaryButton from '@/Components/PrimaryButton.vue'
import FormCheckRadioGroupNew from '@/Components/FormCheckRadioGroupNew.vue'

const props = defineProps({
    patient: {
        type: Object,
        default: () => ({}),
    },
    family_history: {
        type: Object,
        default: () => ({}),
    },
    history_option: {
        type: Object,
        default: [
            { name: 'Ischaemic heart disease', id: 1 },
            { name: 'Hypertension', id: 2 },
            { name: 'Bronchial asthma', id: 3 },
            { name: 'Allergic skin conditions', id: 4 },
            { name: 'Diabetes', id: 5 },
            { name: 'Mental disorder', id: 6 },
            { name: 'Sudden death', id: 7 },
            { name: 'Cancer', id: 8 },
        ],
    },
    id: {
        type: Number,
        default: null,
    },
})

const form = useForm({
    _method: 'put',
    history: props.family_history.history
})
</script>

<template>
    <AuthenticatedLayout>

        <Head title="Update family history" />

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
                            <CardAside title="Family history"
                                :description="`Family history information on ` + $page.props.appName + `.`"
                                :patient="props.patient">

                                <div class="nk-block-content">
                                    <form
                                        @submit.prevent="form.post(route('family-history.update', props.family_history.id), { preserveScroll: true })">
                                        <div class="gy-3 row">
                                            <div class="col-12">
                                                <FormField wrap-body
                                                    label="Family history of any of the following diseases">
                                                    <FormCheckRadioGroupNew v-model="form.history" type="checkbox"
                                                        name="history" is-column :options="history_option" />
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
