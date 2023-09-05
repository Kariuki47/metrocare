<script setup>
import { Head, Link, useForm } from "@inertiajs/vue3"
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue"
import FormField from '@/Components/FormField.vue'
import FormControl from '@/Components/FormControl.vue'
import Modal from "@/Components/Modal.vue"
import { ref, onUnmounted } from "vue"
import Notification from "@/Components/Notification.vue"
import CardAside from "@/Components/CardAside.vue"

const props = defineProps({
    patient: {
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
    id: {
        type: Number,
        default: null,
    },
})

const emit = defineEmits('modal-close');

const modalRef = ref();
const success = ref(false);

function showModal() {
    modalRef.value.showModal();
}

function closeModal() {
    modalRef.value.closeModal();
}

const form = useForm({
    _method: 'put',
    name: props.patient.name,
    sex: props.patient.sex,
    id_no: props.patient.id_no,
    dob: props.patient.dob,
    email: props.patient.email,
    county: props.patient.county,
    phone: props.patient.phone,
    physician: props.patient.physician,
    physician_tel: props.patient.physician_tel
})

const modalClose = () => {
    success.value = false;
}

const submitForm = () => {
    form.post(route('patient.update', props.patient.id), {
        preserveScroll: true,
        onSuccess: () => success.value = true
    })
}

onUnmounted(() => {
    success.value = false;
});

</script>

<template>
    <AuthenticatedLayout>

        <Head title="Update patient" />

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
                            <CardAside title="Personal Information"
                                :description="`Basic info, like your name and address, that you use on ` + $page.props.appName + `.`"
                                :patient="props.patient">
                                <div class="nk-block">
                                    <div class="nk-data data-list">
                                        <div class="data-head">
                                            <h6 class="overline-title">Basics</h6>
                                        </div>
                                        <div class="data-item" data-modal-target="modalPersonal"
                                            @click.prevent="showModal()">
                                            <div class="data-col">
                                                <span class="data-label">Name</span>
                                                <span class="data-value">{{ props.patient.name }}</span>
                                            </div>
                                            <div class="data-col data-col-end">
                                                <span class="data-more">
                                                    <em class="icon ni ni-forward-ios"></em>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="data-item" data-modal-target="modalPersonal"
                                            @click.prevent="showModal()">
                                            <div class="data-col">
                                                <span class="data-label">Sex</span>
                                                <span class="data-value">{{ props.patient.sex_name }}</span>
                                            </div>
                                            <div class="data-col data-col-end">
                                                <span class="data-more">
                                                    <em class="icon ni ni-forward-ios"></em>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="data-item" data-modal-target="modalPersonal"
                                            @click.prevent="showModal()">
                                            <div class="data-col">
                                                <span class="data-label">ID / Passport No.</span>
                                                <span class="data-value">{{ props.patient.id_no }}</span>
                                            </div>
                                            <div class="data-col data-col-end">
                                                <span class="data-more disable">
                                                    <em class="icon ni ni-forward-ios"></em>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="data-item" data-modal-target="modalPersonal"
                                            @click.prevent="showModal()">
                                            <div class="data-col">
                                                <span class="data-label">D.O.B. (dd/mm/yr)</span>
                                                <span class="data-value">{{ props.patient.dob }}</span>
                                            </div>
                                            <div class="data-col data-col-end">
                                                <span class="data-more">
                                                    <em class="icon ni ni-forward-ios"></em>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="data-item" data-modal-target="modalPersonal"
                                            @click.prevent="showModal()">
                                            <div class="data-col">
                                                <span class="data-label">Email</span>
                                                <span class="data-value">{{ props.patient.email }}</span>
                                            </div>
                                            <div class="data-col data-col-end">
                                                <span class="data-more">
                                                    <em class="icon ni ni-forward-ios"></em>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="data-item" data-modal-target="modalPersonal"
                                            @click.prevent="showModal()">
                                            <div class="data-col">
                                                <span class="data-label">Resident County</span>
                                                <span class="data-value">{{ props.patient.county_name }}</span>
                                            </div>
                                            <div class="data-col data-col-end">
                                                <span class="data-more">
                                                    <em class="icon ni ni-forward-ios"></em>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="data-item" data-modal-target="modalPersonal"
                                            @click.prevent="showModal()">
                                            <div class="data-col">
                                                <span class="data-label">Cellphone</span>
                                                <span class="data-value">{{ props.patient.phone }}</span>
                                            </div>
                                            <div class="data-col data-col-end">
                                                <span class="data-more">
                                                    <em class="icon ni ni-forward-ios"></em>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="nk-data data-list">
                                        <div class="data-head">
                                            <h6 class="overline-title">Physician</h6>
                                        </div>
                                        <div class="data-item" data-modal-target="modalPersonal"
                                            @click.prevent="showModal()">
                                            <div class="data-col">
                                                <span class="data-label">Personal Physician if any</span>
                                                <span class="data-value">{{ props.patient.physician }}</span>
                                            </div>
                                            <div class="data-col data-col-end">
                                                <span class="data-more">
                                                    <em class="icon ni ni-forward-ios"></em>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="data-item" data-modal-target="modalPersonal"
                                            @click.prevent="showModal()">
                                            <div class="data-col">
                                                <span class="data-label">Physician Tel</span>
                                                <span class="data-value">{{ props.patient.physician_tel }}</span>
                                            </div>
                                            <div class="data-col data-col-end">
                                                <span class="data-more">
                                                    <em class="icon ni ni-forward-ios"></em>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </CardAside>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <Modal ref="modalRef" :id="`modalPersonal`" title="Update Personal Information" @modal-close="modalClose">
            <form @submit.prevent="submitForm">
                <div class="row gy-4">
                    <div class="col-lg-6">
                        <FormField label="Name" :class="{ 'text-red-400': form.errors.name }" label-for="name">
                            <FormControl v-model="form.name" id="name" type="text" placeholder="Enter Name"
                                :error="form.errors.name">
                                <div class="text-red-400 text-sm" v-if="form.errors.name">
                                    {{ form.errors.name }}
                                </div>
                            </FormControl>
                        </FormField>
                    </div>
                    <div class="col-lg-6">
                        <FormField label="Sex" :class="{ 'text-red-400': form.errors.sex }">
                            <FormControl v-model="form.sex" type="select" placeholder="-- Select sex --"
                                :error="form.errors.sex" :options="item_options">
                                <div class="text-red-400 text-sm" v-if="form.errors.sex">
                                    {{ form.errors.sex }}
                                </div>
                            </FormControl>
                        </FormField>
                    </div>
                    <div class="col-lg-6">
                        <FormField label="ID / Passport No." :class="{ 'text-red-400': form.errors.id_no }"
                            label-for="id-no">
                            <FormControl v-model="form.id_no" type="text" id="id-no" placeholder="Enter ID / Passport No"
                                :error="form.errors.id_no">
                                <div class="text-red-400 text-sm" v-if="form.errors.id_no">
                                    {{ form.errors.id_no }}
                                </div>
                            </FormControl>
                        </FormField>
                    </div>
                    <div class="col-lg-6">
                        <FormField label="D.O.B (dd/mm/yr)" label-for="dob" :class="{ 'text-red-400': form.errors.dob }">
                            <FormControl v-model="form.dob" type="text" id="dob" placeholder="Enter date of birth"
                                :error="form.errors.dob">
                                <div class="text-red-400 text-sm" v-if="form.errors.dob">
                                    {{ form.errors.dob }}
                                </div>
                            </FormControl>
                        </FormField>
                    </div>
                    <div class="col-lg-12">
                        <FormField label="Email" label-for="email" :class="{ 'text-red-400': form.errors.email }">
                            <FormControl v-model="form.email" type="text" placeholder="Enter Email" id="email"
                                :error="form.errors.email">
                                <div class="text-red-400 text-sm" v-if="form.errors.email">
                                    {{ form.errors.email }}
                                </div>
                            </FormControl>
                        </FormField>
                    </div>
                    <div class="col-lg-6">
                        <FormField label="Resident County" :class="{ 'text-red-400': form.errors.county }">
                            <FormControl v-model="form.county" type="select" placeholder="-- Select County --"
                                :error="form.errors.county" :options="county_options">
                                <div class="text-red-400 text-sm" v-if="form.errors.county">
                                    {{ form.errors.county }}
                                </div>
                            </FormControl>
                        </FormField>
                    </div>
                    <div class="col-lg-6">
                        <FormField label="Cellphone" label-for="phone" :class="{ 'text-red-400': form.errors.phone }">
                            <FormControl v-model="form.phone" type="text" id="phone" placeholder="Enter cellphone"
                                :error="form.errors.phone">
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
                                placeholder="Enter Personal Physician" :error="form.errors.physician">
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
                                placeholder="Enter Physician Tel" :error="form.errors.physician_tel">
                                <div class="text-red-400 text-sm" v-if="form.errors.physician_tel">
                                    {{ form.errors.physician_tel }}
                                </div>
                            </FormControl>
                        </FormField>
                    </div>
                    <div class="col-12">
                        <Notification v-if="$page.props.flash.message && success" icon="ni-check-circle" color="alert-success"
                            alert-dismissible alert-fill>
                            {{ $page.props.flash.message }}
                        </Notification>
                    </div>
                    <div class="col-12">
                        <ul class="align-center flex-wrap flex-sm-nowrap gx-4 gy-2">
                            <li>
                                <button type="submit" class="btn btn-lg btn-primary"
                                    :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                    <template v-if="form.processing">
                                        <span class="spinner-border spinner-border-sm" role="status"
                                            aria-hidden="true"></span><span>Loading...</span>
                                    </template>
                                    <template v-else>
                                        Update Patient
                                    </template>
                                </button>
                            </li>
                            <li><a href="#" class="link link-light" @click.prevent="closeModal">Cancel</a></li>
                        </ul>
                    </div>
                </div>
            </form>
        </Modal>
    </AuthenticatedLayout>
</template>
