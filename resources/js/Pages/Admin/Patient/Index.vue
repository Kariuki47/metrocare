<script setup>
import { ref, onUnmounted, computed } from "vue"
import { Head, Link, useForm } from "@inertiajs/vue3"
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue"
import CustomPagination from "@/Components/Admin/CustomPagination.vue"
import TopSortRight from "@/Components/Admin/TopSortRight.vue"
import TableFilter from "@/Components/Admin/TableFilter.vue"
import ModalDialog from "@/Components/ModalDialog.vue"
import NoRecord from '@/Components/Admin/NoRecord.vue'
import { CTooltip } from '@coreui/vue'

const props = defineProps({
    patients: {
        type: Object,
        default: () => ({}),
    },
    filters: {
        type: Object,
        default: () => ({}),
    },
    can: {
        type: Object,
        default: () => ({}),
    },
    modelValue: {
        type: [Array, String, Number, Boolean],
        default: null
    },
    item_options: {
        type: Object,
        default: [
            { name: 'Male', value: 'male' },
            { name: 'Female', value: 'female' },
            { name: 'Other', value: 'other' },
        ],
    },
    bulkOptions: {
        type: Object,
        default: [
            {
                id: 'delete',
                text: 'Delete Patient',
            },
            {
                id: 'download',
                text: 'Download PDF',
            }
        ],
    },
})

const emit = defineEmits(['modal-confirm', 'modal-close', 'update:modelValue', 'modal-show']);

const modalRef = ref();
const success = ref(false);
const ids = ref([]);

function download(id) {
    window.open(route('generatePDF', id), '_blank')
    /*axios({
        url: '/report/pdf/' + id,
        method: 'GET',
        responseType: 'blob',
    }).then((response) => {
        var fileURL = window.URL.createObjectURL(new Blob([response.data]));
        var fileLink = document.createElement('a');
        fileLink.href = fileURL;
        fileLink.setAttribute('download', 'medical_report' + id + '.pdf');
        document.body.appendChild(fileLink);
        fileLink.click();

    });*/
}

function bulkDownload(ids) {
    for (id in ids) {
        window.open(route('generatePDF', id), '_blank')
    }
}

function nameInitials(fullName) {
    const name = fullName.split(' ')
    return `${name[0].charAt(0)}${name[1] ? name[1].charAt(0) : ''}`;
}

function confirmModal(id, bulk) {
    modalRef.value.showModal(id, bulk);
}

function destroy(id, bulk) {

    const bulkForm = useForm({
        id: id,
        bulk: bulk
    })

    bulkForm.post(route("bulk.delete.patient"), {
        onSuccess: () => {
            success.value = true
            ids.value = []
        },
    })

}

const modalClose = () => {
    success.value = false;
}

const checkAll = computed({
    get() {
        return props.patients.data ? ids.value.length == props.patients.data.length : false;
    },
    set(value) {
        var checked = [];
        if (value) {
            props.patients.data.forEach(function (patient) {
                checked.push(patient.id);
            });
        }
        ids.value = checked;
    }
})

onUnmounted(() => success.value = false);
</script>

<template>
    <AuthenticatedLayout>

        <Head title="Patients" />

        <div class="container-fluid">
            <div class="nk-content-inner">
                <div class="nk-content-body">
                    <div class="nk-block-head nk-block-head-sm">
                        <div class="nk-block-between">
                            <div class="nk-block-head-content">
                                <h3 class="nk-block-title page-title">Patients</h3>
                                <div class="nk-block-des text-soft">
                                    <p>You have total {{ patients.total }} patients.</p>
                                </div>
                            </div>
                            <TopSortRight label="Add patient" :href="route('patient.create')"
                                :url="route('export.patients')" :export="patients.total ? true : false" worksheet="Patient"
                                create />
                        </div>
                    </div>

                    <div class="nk-block">
                        <div class="card card-bordered">
                            <div class="card-inner-group">
                                <TableFilter :ids="ids" @modal-show="confirmModal"
                                    search-placeholder="Search by name, email, phone or county"
                                    :search-url="route('patient.index')" :my-options="bulkOptions" :filters="props.filters"
                                    filter filter-label="Filter Patients" health history treatment
                                    :reset-filter="route('patient.index')" alert-message="Select at least one patient"
                                    search />
                                <template v-if="patients.data.length">
                                    <div class="card-inner p-0">
                                        <div class="nk-tb-list nk-tb-ulist">
                                            <div class="nk-tb-item nk-tb-head">
                                                <div class="nk-tb-col nk-tb-col-check">
                                                    <div class="custom-control custom-control-sm custom-checkbox notext">
                                                        <input type="checkbox" class="custom-control-input"
                                                            v-model="checkAll" id="uid">
                                                        <label class="custom-control-label" for="uid"></label>
                                                    </div>
                                                </div>
                                                <div class="nk-tb-col"><span class="sub-text">Patient</span></div>
                                                <div class="nk-tb-col tb-col-md"><span class="sub-text">Phone</span></div>
                                                <div class="nk-tb-col tb-col-lg"><span class="sub-text">ID NO</span></div>
                                                <div class="nk-tb-col tb-col-lg"><span class="sub-text">DOB</span></div>
                                                <div class="nk-tb-col tb-col-md"><span class="sub-text">County</span></div>
                                                <div class="nk-tb-col tb-col-mb"><span class="sub-text">Created</span></div>
                                                <div class="nk-tb-col nk-tb-col-tools text-end">

                                                </div>
                                            </div>
                                            <div v-for="patient in patients.data" :key="patient.id" class="nk-tb-item">
                                                <div class="nk-tb-col nk-tb-col-check">
                                                    <div class="custom-control custom-control-sm custom-checkbox notext">
                                                        <input type="checkbox" class="custom-control-input" v-model="ids"
                                                            :id="`uid` + patient.id" :value="patient.id">
                                                        <label class="custom-control-label"
                                                            :for="`uid` + patient.id"></label>
                                                    </div>
                                                </div>
                                                <div class="nk-tb-col">
                                                    <Link :href="route('patient.edit', patient.id)">
                                                    <div class="user-card">
                                                        <div v-if="patient.name" class="user-avatar bg-primary"><span>{{
                                                            nameInitials(patient.name)
                                                        }}</span></div>
                                                        <div class="user-info"><span class="tb-lead">{{ patient.name }}<span
                                                                    class="dot dot-success d-md-none ms-1"></span></span><span>{{
                                                                        patient.email }}</span>
                                                        </div>
                                                    </div>
                                                    </Link>
                                                </div>
                                                <div class="nk-tb-col tb-col-md"><span>{{ patient.phone }} </span></div>
                                                <div class="nk-tb-col tb-col-lg"><span>{{ patient.id_no }}</span></div>
                                                <div class="nk-tb-col tb-col-lg">
                                                    <span>{{ patient.dob }}</span>
                                                </div>
                                                <div class="nk-tb-col tb-col-md"><span>{{ patient.county_name }}</span>
                                                </div>
                                                <div class="nk-tb-col tb-col-mb">
                                                    <span>{{ new Date(patient.created_at).toLocaleString('en-IN',
                                                        { dateStyle: 'medium', timeStyle: 'short' }) }} </span>
                                                </div>
                                                <div class="nk-tb-col nk-tb-col-tools">
                                                    <ul class="nk-tb-actions gx-1">
                                                        <li class="nk-tb-action-hidden">
                                                            <CTooltip content="Export PDF" placement="top">
                                                                <template #toggler="{ on }">
                                                                    <a href="#" class="btn btn-trigger btn-icon" v-on="on"
                                                                        aria-label="Export PDF"
                                                                        @click.prevent="download(patient.id)">
                                                                        <em class="icon ni ni-file-pdf"></em>
                                                                    </a>
                                                                </template>
                                                            </CTooltip>
                                                        </li>
                                                        <li class="nk-tb-action-hidden">
                                                            <CTooltip content="Move to Trash" placement="top">
                                                                <template #toggler="{ on }">
                                                                    <a href="#" class="btn btn-trigger btn-icon" v-on="on"
                                                                        aria-label="Move to Trash"
                                                                        @click.prevent="confirmModal(patient.id)">
                                                                        <em class="icon ni ni-trash"></em>
                                                                    </a>
                                                                </template>
                                                            </CTooltip>
                                                        </li>
                                                        <li>
                                                            <div class="drodown">
                                                                <a class="dropdown-toggle btn btn-icon btn-trigger"
                                                                    data-bs-toggle="dropdown"
                                                                    :data-dropdown-toggle="`tb-action-p-` + patient.id"
                                                                    data-dropdown-placement="bottom-end"><em
                                                                        class="icon ni ni-more-h"></em></a>
                                                                <div class="dropdown-menu dropdown-menu-end"
                                                                    :id="`tb-action-p-` + patient.id">

                                                                    <ul class="link-list-opt no-bdr">
                                                                        <li>
                                                                            <a href="#"
                                                                                @click.prevent="download(patient.id)">
                                                                                <em class="icon ni ni-file-pdf"></em>
                                                                                <span>Export PDF</span>
                                                                            </a>
                                                                        </li>
                                                                        <li>
                                                                            <Link :href="route('patient.edit', patient.id)">
                                                                            <em class="icon ni ni-edit"></em>
                                                                            <span>Edit Details</span>
                                                                            </Link>
                                                                        </li>
                                                                        <li class="divider"></li>
                                                                        <li>
                                                                            <a href="#"
                                                                                @click.prevent="confirmModal(patient.id)">
                                                                                <em class="icon ni ni-trash"></em>
                                                                                <span>Move to Trash</span>
                                                                            </a>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <CustomPagination :data="patients" />
                                </template>
                                <template v-else>
                                    <div class="card-inner p-0">
                                        <NoRecord label="patients" />
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>

                    <ModalDialog ref="modalRef" :id="`modalDefaults`" :data-modal-target="`modalDefaults`"
                        :message="success ? $page.props.flash.message : 'Are you sure you want to delete this?'"
                        :icon="success ? 'ni-check' : 'ni-cross'" :color="success ? 'bg-success' : 'bg-danger'"
                        :label="success ? 'Deleted' : 'Delete'" @modal-confirm="(id, bulk) => destroy(id, bulk)"
                        @modal-close="modalClose" :success="success" />

                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
