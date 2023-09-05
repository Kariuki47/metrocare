<script setup>
import { ref } from "vue"
import { Link } from "@inertiajs/vue3"
import downloadexcel from "vue-json-excel3";

const isExpanded = ref(false);
const isLoading = ref(false);

const props = defineProps({
    href: {
        type: String,
        default: null
    },
    url: {
        type: String,
        default: null
    },
    label: {
        type: [String, Number],
        default: null
    },
    worksheet: {
        type: String,
        default: null
    },
    json_fields: {
        type: Object,
        default: {
            'Name': 'name',
            'Sex': 'sex_name',
            'ID / Passport No': 'id_no',
            'D.O.B. (dd/mm/yr)': 'dob',
            'Email': 'email',
            'Resident County': 'county_name',
            'Cellphone': 'phone',
            'Personal Physician': 'physician',
            'Physician Tel': 'physician_tel',
        }
    },
    export: Boolean,
    create: Boolean,
})

const toggleDropdown = () => {
    isExpanded.value = !isExpanded.value;
}

async function fetchData() {
    const response = await axios.get(props.url);
    return response.data;
}

function startDownload() {
    isLoading.value = true;
}

function finishDownload() {
    isLoading.value = false;
}
</script>

<template>
    <div class="nk-block-head-content">
        <div class="toggle-wrap nk-block-tools-toggle">
            <a class="btn btn-icon btn-trigger toggle-expand me-n1" :class="isExpanded ? 'active' : ''"
                @click.prevent="toggleDropdown">
                <em class="icon ni ni-menu-alt-r"></em>
            </a>
            <div class="toggle-expand-content" :class="isExpanded ? 'expanded' : ''">
                <ul class="nk-block-tools g-3">
                    <li v-if="export">
                        <downloadexcel class="btn btn-white btn-outline-light" :class="{'disabled':isLoading}" :fetch="fetchData" :fields="json_fields"
                            :before-generate="startDownload" :before-finish="finishDownload" :worksheet="worksheet"
                            name="Patient records.xls">
                            <template v-if="isLoading">
                                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                <span>Loading...</span>
                            </template>
                            <template v-else>
                                <em class="icon ni ni-download-cloud"></em>
                                <span>Export</span>
                            </template>
                        </downloadexcel>
                    </li>
                    <li v-if="create" class="nk-block-tools-opt">
                        <Link :href="href" class="btn btn-icon btn-primary d-md-none">
                        <em class="icon ni ni-plus"></em>
                        </Link>
                        <Link :href="href" class="btn btn-primary d-none d-md-inline-flex">
                        <em class="icon ni ni-plus"></em>
                        <span>Add</span>
                        </Link>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</template>