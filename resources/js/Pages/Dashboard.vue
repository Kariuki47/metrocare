<script setup>
import { ref } from "vue"
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import NoRecord from '@/Components/Admin/NoRecord.vue'
import { Head, Link } from '@inertiajs/vue3'

const props = defineProps({
    activities: {
        type: Object,
        default: () => ({}),
    },
    patients: {
        type: Object,
        default: () => ({}),
    },
    users: {
        type: Object,
        default: () => ({}),
    },
    admin: Boolean,
    can: {
        type: Object,
        default: () => ({}),
    },
})

const isExpanded = ref(false);

function nameInitials(fullName) {
    const name = fullName.split(' ')
    return `${name[0].charAt(0)}${name[1] ? name[1].charAt(0) : ''}`;
}
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

const toggleDropdown = () => {
    isExpanded.value = !isExpanded.value;
}

</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <div class="container-fluid">
            <div class="nk-content-inner">
                <div class="nk-content-body">
                    <div class="nk-block-head nk-block-head-sm">
                        <div class="nk-block-between">
                            <div class="nk-block-head-content">
                                <h3 class="nk-block-title page-title">Overview</h3>
                                <div class="nk-block-des text-soft">
                                    <p>Welcome to {{ $page.props.appName }} Dashboard.</p>
                                </div>
                            </div>
                            <div class="nk-block-head-content">
                                <div class="toggle-wrap nk-block-tools-toggle">
                                    <a class="btn btn-icon btn-trigger toggle-expand me-n1"
                                        :class="isExpanded ? 'active' : ''" @click.prevent="toggleDropdown">
                                        <em class="icon ni ni-more-v"></em>
                                    </a>
                                    <div class="toggle-expand-content" :class="isExpanded ? 'expanded' : ''">
                                        <ul class="nk-block-tools g-3">
                                            <li>
                                                <div class="dropdown">
                                                    <a href="#"
                                                        class="dropdown-toggle btn btn-white btn-dim btn-outline-light"
                                                        data-dropdown-toggle="report-filter" data-dropdown-offset-distance="5"
                                                        data-dropdown-placement="bottom-end" data-bs-toggle="dropdown"
                                                        @click.prevent>
                                                        <em class="d-none d-sm-inline icon ni ni-calender-date"></em>
                                                        <span>
                                                            <span class="d-none d-md-inline">Last</span> 30 Days
                                                        </span>
                                                        <em class="dd-indc icon ni ni-chevron-right"></em>
                                                    </a>
                                                    <div id="report-filter" class="dropdown-menu dropdown-menu-end">
                                                        <ul class="link-list-opt no-bdr">
                                                            <li><a href="#"><span>Last 30 Days</span></a></li>
                                                            <li><a href="#"><span>Last 6 Months</span></a></li>
                                                            <li><a href="#"><span>Last 1 Years</span></a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="nk-block-tools-opt">
                                                <a href="#" class="btn btn-primary"><em
                                                        class="icon ni ni-reports"></em><span>Reports</span></a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="nk-block">
                        <div class="row g-gs">
                            <div v-if="can.patients" class="col-xxl-8">
                                <div class="card card-bordered card-full">
                                    <div class="card-inner">
                                        <div class="card-title-group">
                                            <div class="card-title">
                                                <h6 class="title"><span class="me-2">Patients</span></h6>
                                            </div>
                                            <div v-if="patients.length" class="card-tools">
                                                <Link :href="route('patient.index')" class="link">
                                                View All
                                                </Link>
                                            </div>
                                        </div>
                                    </div>
                                    <div v-if="patients.length" class="card-inner p-0 border-top">
                                        <div class="nk-tb-list nk-tb-orders">
                                            <div class="nk-tb-item nk-tb-head">
                                                <div class="nk-tb-col"><span>ID No.</span></div>
                                                <div class="nk-tb-col"><span>Name</span></div>
                                                <div class="nk-tb-col tb-col-sm"><span>Email</span></div>
                                                <div class="nk-tb-col tb-col-sm"><span>Phone</span></div>
                                                <div class="nk-tb-col tb-col-lg"><span>DOB</span></div>
                                                <div class="nk-tb-col tb-col-md"><span>County</span></div>
                                                <div class="nk-tb-col"><span>&nbsp;</span></div>
                                            </div>
                                            <div v-for="patient in patients" :key="patient.id" class="nk-tb-item">
                                                <div class="nk-tb-col"><span class="tb-lead">
                                                        <Link :href="route('patient.edit', patient.id)">#{{ patient.id }}
                                                        </Link>
                                                    </span>
                                                </div>
                                                <div class="nk-tb-col">
                                                    <div class="user-card">
                                                        <div v-if="patient.name"
                                                            class="user-avatar user-avatar-sm bg-purple"><span>{{
                                                                nameInitials(patient.name) }}</span>
                                                        </div>
                                                        <div class="user-name"><span class="tb-lead">{{ patient.name
                                                        }}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="nk-tb-col tb-col-sm"><span class="tb-sub text-primary">{{
                                                    patient.email }}</span>
                                                </div>
                                                <div class="nk-tb-col tb-col-sm"><span class="tb-sub">{{ patient.phone
                                                }}</span></div>
                                                <div class="nk-tb-col tb-col-lg"><span class="tb-sub">{{ patient.dob }}</span></div>
                                                <div class="nk-tb-col tb-col-md"><span class="tb-sub">{{ patient.county_name }}</span>
                                                </div>
                                                <div class="nk-tb-col nk-tb-col-action">
                                                    <div class="dropdown"><a
                                                            class="text-soft dropdown-toggle btn btn-icon btn-trigger"
                                                            data-bs-toggle="dropdown"
                                                            :data-dropdown-toggle="`tb-action-` + patient.id"
                                                            data-dropdown-placement="bottom-end"><em
                                                                class="icon ni ni-more-h"></em></a>
                                                        <div class="dropdown-menu dropdown-menu-end dropdown-menu-xs"
                                                            :id="`tb-action-` + patient.id">
                                                            <ul class="link-list-plain">
                                                                <li>
                                                                    <Link :href="route('patient.edit', patient.id)">Edit
                                                                    </Link>
                                                                </li>
                                                                <li><a href="#" @click.prevent="download(patient.id)">Print</a></li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div v-else class="card-inner">
                                        <NoRecord label="patients" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-xxl-4">
                                <div class="card card-bordered card-full">
                                    <div class="card-inner">
                                        <div class="card-title-group">
                                            <div class="card-title">
                                                <h6 class="title">Recent Activities</h6>
                                            </div>
                                            <div v-if="activities.length" class="card-tools">
                                                <Link :href="route('activitylog')" class="link">View All</Link>
                                            </div>
                                        </div>
                                    </div>
                                    <div v-if="activities.length" class="card-inner p-0 border-top">
                                        <div class="nk-tb-list nk-tb-activity">
                                            <div class="nk-tb-item nk-tb-head">
                                                <div v-if="admin" class="nk-tb-col"><span>User/ IP</span></div>
                                                <div class="nk-tb-col"><span>Object</span></div>
                                                <div class="nk-tb-col"><span>Event Type</span></div>
                                                <div class="nk-tb-col"><span>Date</span></div>
                                            </div>
                                            <div v-for="activity in activities" :key="activity.id" class="nk-tb-item">
                                                <div v-if="admin" class="nk-tb-col">
                                                    <div class="user-card">
                                                        <div v-if="activity.name"
                                                            class="user-avatar user-avatar-sm bg-purple"><span>{{
                                                                nameInitials(activity.name) }}</span>
                                                        </div>
                                                        <div class="user-name">
                                                            <span class="tb-lead">
                                                                {{ activity.properties.ip }}
                                                            </span>
                                                            <span>
                                                                {{ activity.name }}
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="nk-tb-col"><span class="tb-sub">{{ activity.properties.model }}
                                                        | #{{ activity.subject_id }}</span></div>
                                                <div class="nk-tb-col"><span class="tb-sub text-primary">{{
                                                    activity.description }}</span></div>
                                                <div class="nk-tb-col"><span class="tb-sub">
                                                        {{ new Date(activity.created_at).toLocaleString('en-IN',
                                                            { dateStyle: 'medium', timeStyle: 'short' }) }} </span></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div v-else class="card-inner">
                                        <NoRecord label="activities" />
                                    </div>
                                </div>
                            </div>
                            <div v-if="can.users" class="col-md-6 col-xxl-4">
                                <div class="card card-bordered card-full">
                                    <div class="card-inner-group">
                                        <div class="card-inner">
                                            <div class="card-title-group">
                                                <div class="card-title">
                                                    <h6 class="title">New Users</h6>
                                                </div>
                                                <div class="card-tools">
                                                    <Link :href="route('user.index')" class="link">View All</Link>
                                                </div>
                                            </div>
                                        </div>
                                        <div v-for="user in users" :key="user.id" class="card-inner card-inner-md">
                                            <div class="user-card">
                                                <div v-if="user.abbr_name" class="user-avatar bg-primary-dim"><span>{{
                                                    user.abbr_name }}</span>
                                                </div>
                                                <div class="user-info"><span class="lead-text">{{ user.name }}</span><span
                                                        class="sub-text">{{ user.email }}</span></div>
                                                <div class="user-action">
                                                    <div class="dropdown"><a
                                                            class="dropdown-toggle btn btn-icon btn-trigger me-n1"
                                                            data-bs-toggle="dropdown" aria-expanded="false"
                                                            :data-dropdown-toggle="`tb-actionu-` + user.id"
                                                            data-dropdown-placement="bottom-end"><em
                                                                class="icon ni ni-more-h"></em></a>
                                                        <div class="dropdown-menu dropdown-menu-end"
                                                            :id="`tb-actionu-` + user.id">
                                                            <ul class="link-list-opt no-bdr">
                                                                <li>
                                                                    <Link :href="route('user.edit', user.id)"><em
                                                                        class="icon ni ni-setting"></em><span>Edit
                                                                        User</span></Link>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div v-if="!users.length" class="card-inner">
                                            <NoRecord label="users" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
    </div>

</AuthenticatedLayout></template>
