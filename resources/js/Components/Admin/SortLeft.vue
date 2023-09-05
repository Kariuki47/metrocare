<script setup>
import { Link } from "@inertiajs/vue3"
import downloadexcel from "vue-json-excel3";

const props = defineProps({
    href: {
        type: String,
        default: null
    },
    label: {
        type: [String, Number],
        default: null
    },
    json_fields: {
        type: Object,
        default: {
            'Complete name': 'name',
            'Date': 'date',
        }
    },
})

async function fetchData() {
    const response = await axios.get('https://holidayapi.com/v1/holidays?key=a4b2083b-1577-4acd-9408-6e529996b129&country=US&year=2017&month=09');
    console.log(response);
    return response.data.holidays;
}

function startDownload() {
    alert('show loading');
}

function finishDownload() {
    alert('hide loading');
}

</script>

<template>
    <div class="nk-block-head-content">
        <div class="toggle-wrap nk-block-tools-toggle">
            <a class="btn btn-icon btn-trigger toggle-expand me-n1" data-target="pageMenu"
                data-dropdown-toggle="export-menu" data-dropdown-placement="bottom-end">
                <em class="icon ni ni-menu-alt-r"></em>
            </a>
            <div class="toggle-expand-content" data-content="pageMenu" id="export-menu">
                <ul class="nk-block-tools g-3">
                    <li>
                        <downloadexcel class="btn btn-white btn-outline-light kum" :fetch="fetchData" :fields="json_fields"
                            :before-generate="startDownload" :before-finish="finishDownload">
                            <em class="icon ni ni-download-cloud"></em>
                            <span>Export</span>
                        </downloadexcel>
                    </li>
                    <li class="nk-block-tools-opt">
                        <div class="drodown">
                            <a class="dropdown-toggle btn btn-icon btn-primary" data-bs-toggle="dropdown"
                                data-dropdown-toggle="add-menu" data-dropdown-placement="bottom-end">
                                <em class="icon ni ni-plus"></em>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end" id="add-menu">
                                <ul class="link-list-opt no-bdr">
                                    <li>
                                        <Link :href="href"><span>{{ label }}</span></Link>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</template>