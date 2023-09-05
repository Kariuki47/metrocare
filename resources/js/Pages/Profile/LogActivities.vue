<script setup>
import { Head, Link } from "@inertiajs/vue3"
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue"
import CustomPagination from "@/Components/Admin/CustomPagination.vue"
import NoRecord from '@/Components/Admin/NoRecord.vue'

const props = defineProps({
    activities: {
        type: Object,
        default: () => ({}),
    },
    filters: {
        type: Object,
        default: () => ({}),
    },
    admin: Boolean,
})

</script>

<template>
    <AuthenticatedLayout>

        <Head title="Activity Log" />

        <div class="container-fluid">
            <div class="nk-content-inner">
                <div class="nk-content-body">
                    <div class="nk-block-head nk-block-head-sm">
                        <div class="nk-block-between">
                            <div class="nk-block-head-content">
                                <h3 class="nk-block-title page-title">Activity Log</h3>
                            </div>
                        </div>
                    </div>

                    <div class="nk-block">
                        <div v-if="activities.data.length" class="card card-bordered card-preview">
                            <div class="card-inner-group">
                                <div class="card-inner p-0">
                                    <table class="table table-ulogs">
                                        <thead class="table-light">
                                            <tr>
                                                <th v-if="admin" class="tb-col-os"><span class="overline-title">User</span>
                                                </th>
                                                <th :class="{ 'tb-col-ip': admin }"><span class="overline-title">IP
                                                        Address</span></th>
                                                <th><span class="overline-title">Object</span></th>
                                                <th><span class="overline-title">Event Type</span></th>
                                                <th class="tb-col-time"><span class="overline-title">Date</span></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="activity in activities.data" :key="activity.id">
                                                <td v-if="admin" class="tb-col-os">
                                                    <Link :href="route('user.edit', activity.user_id)"
                                                        class="text-primary fw-bold">
                                                    {{ activity.name }}
                                                    </Link>
                                                </td>
                                                <td :class="{ 'tb-col-ip': admin }"><span class="sub-text">{{
                                                    activity.properties.ip }}</span></td>
                                                <td><span class="sub-text">{{ activity.properties.model }} | #{{
                                                    activity.subject_id }}</span></td>
                                                <td><span class="sub-text">{{ activity.description }}</span></td>
                                                <td class="tb-col-time"><span class="sub-text">{{ new
                                                    Date(activity.created_at).toLocaleString('en-IN',
                                                        { dateStyle: 'medium', timeStyle: 'short' }) }}</span></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <CustomPagination :data="activities" />
                            </div>
                        </div>
                        <NoRecord v-else label="activities" />
                    </div>
                </div>
        </div>
    </div>
</AuthenticatedLayout></template>
