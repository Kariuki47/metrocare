<script setup>
import { Head, Link, useForm } from "@inertiajs/vue3"
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue"
import CardAside from "@/Components/CardAside.vue"
import FormField from '@/Components/FormField.vue'
import FormControl from '@/Components/FormControl.vue'

const props = defineProps({
    patient: {
        type: Object,
        default: () => ({}),
    },
    lab_reports: {
        type: Object,
        default: () => ({}),
    },
    id: {
        type: Number,
        default: null,
    },
})


const form = useForm({
    file: null
});

const submit = () => {
    form.transform((data) => ({
        ...data,
        patient_id: props.patient.id,
    }))
        .post(route('lab.report.upload'), {
            preserveScroll: true,
            onSuccess: () => form.reset(),
        });
};

function download(id) {
    window.location.href = route('lab.report.download', id)
}

function destroy(id) {

    const deleteFile = useForm({
        id: id,
    })

    deleteFile.post(route("lab.report.delete"), {
        preserveScroll: true,
    })

}

</script>

<template>
    <AuthenticatedLayout>

        <Head title="Upload lab results" />

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
                            <CardAside title="Lab Report"
                                :description="`Lab Report information on ` + $page.props.appName + `.`"
                                :patient="props.patient">

                                <div class="nk-block-content">
                                    <div class="nk-files nk-files-view-group">
                                        <div class="nk-files-group">
                                            <h6 class="title border-top-0 border-bottom mb-3">Lab Report Files</h6>
                                            <div v-if="lab_reports.length" class="nk-files-list">

                                                <!-- .nk-file -->
                                                <div v-for="lab_report in lab_reports"
                                                    class="nk-file-item nk-file bg-lighter w-100">
                                                    <div class="nk-file-info">
                                                        <div class="nk-file-title">
                                                            <div class="nk-file-icon">
                                                                <span class="nk-file-icon-type">
                                                                    <div class="FormFile__icon">
                                                                        <div
                                                                            :class="`FormFile__icon__badge FormFile__icon__badge--` + lab_report.type">
                                                                            {{ lab_report.type }}</div>
                                                                    </div>
                                                                </span>
                                                            </div>
                                                            <div class="nk-file-name">
                                                                <div class="nk-file-name-text">
                                                                    <a @click.prevent="download(lab_report.id)"
                                                                        class="plain-link title">{{ lab_report.name }}</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <ul class="nk-file-desc">
                                                            <!-- <li class="text-dark">Final paper</li> -->
                                                            <li class="date">
                                                                <span>{{ lab_report.created_at }}</span>
                                                            </li>
                                                            <li class="size">{{ lab_report.size }}</li>
                                                        </ul>
                                                    </div>
                                                    <div class="nk-file-actions">
                                                        <div class="dropdown">
                                                            <a class="dropdown-toggle btn btn-sm btn-icon btn-trigger"
                                                                data-toggle="dropdown"
                                                                :data-dropdown-toggle="`files-action-f-` + lab_report.id"
                                                                data-dropdown-placement="bottom-start"><em
                                                                    class="icon ni ni-more-h"></em></a>
                                                            <div class="dropdown-menu dropdown-menu-right"
                                                                :id="`files-action-f-` + lab_report.id">
                                                                <ul class="link-list-plain no-bdr">
                                                                    <li>
                                                                        <a class="plain-link file-dl-toast"
                                                                            @click.prevent="download(lab_report.id)">
                                                                            <em
                                                                                class="icon ni ni-download"></em><span>Download</span>
                                                                        </a>
                                                                    </li>
                                                                    <li>
                                                                        <a @click.prevent="destroy(lab_report.id)"
                                                                            class="plain-link">
                                                                            <em
                                                                                class="icon ni ni-trash"></em><span>Delete</span>
                                                                        </a>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div><!-- .nk-file -->
                                            </div>
                                            <div v-else class="alert alert-icon alert-info">
                                                <em class="icon ni ni-alert-circle"></em> There are no files uploaded by
                                                lab technician.
                                            </div>
                                            <form name="createForm" @submit.prevent="submit">
                                                <div className="col-12 mt-2">

                                                    <FormField label="File" label-for="file"
                                                        :class="{ 'text-red-400': form.errors.file }">
                                                        <div class="form-control-wrap">
                                                            <input id="file" type="file" class="form-control"
                                                                :error="form.errors.file"
                                                                @input="form.file = $event.target.files[0]" autofocus>
                                                            <div class="text-red-400 text-sm" v-if="form.errors.file">
                                                                {{ form.errors.file }}
                                                            </div>
                                                        </div>
                                                    </FormField>
                                                </div>

                                                <div v-if="form.progress"
                                                    className="w-full bg-gray-200 rounded-full dark:bg-gray-700">
                                                    <div className="bg-blue-600 text-xs font-medium text-blue-100 text-center p-0.5 leading-none rounded-full"
                                                        :width="form.progress.percentage"> {{ form.progress.percentage }}%
                                                    </div>
                                                </div>

                                                <div className="mt-4">
                                                    <button type="submit" class="btn btn-primary">
                                                        <em class="icon ni ni-upload-cloud"></em> <span>Upload Files</span>
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </CardAside>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
<style>
.FormFile__icon {
    background: transparent url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABQAAAAbCAYAAAB836/YAAAAZklEQVRIx+3SMQrAMAhA0dy8V3UQoaCjONqp0CEm1XZU+OtDwQFInuwYqwEkN7NXqeoezYBm5oDkJ0uMVkBVjdEKeJ8/RatgiH4Bp2gFXL5UFhSRaczsgORpcLd9gw022GCDD/DPLtbKrKjuXRiiAAAAAElFTkSuQmCC) center/20px 21px no-repeat;
    display: block;
    flex: 0 0 auto;
    height: 27px;
    margin-right: 10px;
    position: relative;
    width: 20px;
}

.FormFile__icon__badge {
    background-image: linear-gradient(0deg, #888 0%, #a1a1a1 100%);
    box-shadow: 0 1px 0 #dfe3e5;
    color: #fff;
    content: "";
    display: block;
    font-family: Lato, Arial, sans-serif;
    font-size: 9px;
    font-style: normal;
    left: 0;
    letter-spacing: 1px;
    line-height: 11px;
    margin-top: -3px;
    position: absolute;
    text-align: center;
    top: 50%;
    width: 100%;
}

.FormFile__icon__badge--jpg,
.FormFile__icon__badge--jpeg,
.FormFile__icon__badge--png,
.FormFile__icon__badge--gif,
.FormFile__icon__badge--tiff,
.FormFile__icon__badge--bmp {
    background-image: linear-gradient(0deg, #9f590f 0%, #c68622 100%);
}

.FormFile__icon__badge--doc,
.FormFile__icon__badge--odt,
.FormFile__icon__badge--rtf,
.FormFile__icon__badge--txt {
    background-image: linear-gradient(0deg, #3775a0 0%, #4b9cbb 100%);
}

.FormFile__icon__badge--xls {
    background-image: linear-gradient(0deg, #0f9e12 0%, #22c53d 100%);
}

.FormFile__icon__badge--pdf {
    background-image: linear-gradient(0deg, #9e0f0f 0%, #c53222 100%);
}

.FormFile__icon__badge--rar,
.FormFile__icon__badge--zip {
    background-image: linear-gradient(0deg, #9e0f93 0%, #a122c5 100%);
}

a.plain-link:hover {
    cursor: pointer;
}</style>