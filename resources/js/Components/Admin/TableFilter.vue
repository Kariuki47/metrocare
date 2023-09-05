<script setup>
import { ref, onMounted, computed } from "vue"
import { Dropdown } from "flowbite";
import { onClickOutside } from '@vueuse/core';
import ModalDialog from "@/Components/ModalDialog.vue"
import { useForm, Link } from "@inertiajs/vue3"
import Sort from "@/Components/Admin/Sort.vue"
import Order from "@/Components/Admin/Order.vue"
import Select2 from 'vue3-select2-component';
import { Axios } from "axios";
import axios from "axios";

const elementRef = ref();
const modalRef = ref();
const modalDownload = ref();
const dropdown = ref();
const closeDropdown = ref(() => { });
const isSearch = ref(false);
const toolbarActive = ref(false);
const searchInput = ref();
const action = ref('');
const treatmentVal = ref();
const healthVal = ref();
const historyVal = ref();
const roleVal = ref();
const isFilter = ref(false);
const isComplete = ref(null);

const props = defineProps({
    myOptions: {
        type: Object,
        default: () => ({}),
    },
    healthOptions: {
        type: Object,
        default: [{
            id: 1,
            text: 'Good',
        },
        {
            id: 2,
            text: 'Average',
        },
        {
            id: 3,
            text: 'Poor',
        }],
    },
    historyOptions: {
        type: Object,
        default: [{
            id: 1,
            text: 'Ischaemic heart disease',
        },
        {
            id: 2,
            text: 'Hypertension',
        },
        {
            id: 3,
            text: 'Bronchial asthma',
        },
        {
            id: 4,
            text: 'Allergic skin conditions',
        },
        {
            id: 5,
            text: 'Diabetes',
        },
        {
            id: 6,
            text: 'Mental disorder',
        },
        {
            id: 7,
            text: 'Sudden death',
        },
        {
            id: 8,
            text: 'Cancer',
        }],
    },
    bulkOptions: {
        type: Object,
        default: [
            { id: 'delete', text: 'Delete User' },
        ],
    },
    filter: Boolean,
    health: Boolean,
    history: Boolean,
    treatment: Boolean,
    search: Boolean,
    role: Boolean,
    ids: {
        type: Object,
        default: () => ({}),
    },
    searchPlaceholder: {
        type: String,
        default: null,
    },
    searchUrl: {
        type: String,
        default: null,
    },
    filters: {
        type: Object,
        default: () => ({}),
    },
    filterLabel: {
        type: String,
        default: null,
    },
    resetFilter: {
        type: String,
        default: null,
    },
    alertMessage: {
        type: String,
        default: null,
    },
    roles: {
        type: Object,
        default: () => ({}),
    },
})

const emit = defineEmits(['modal-show']);

const form = useForm({
    search: props.filters.search,
})

onMounted(() => {
    let url = new URL(document.location)

    if (url.searchParams.get('treatment') || url.searchParams.get('health') || url.searchParams.get('history') || url.searchParams.get('role')) {
        isFilter.value = true;
    } else {
        isFilter.value = false;
    }
    if (url.searchParams.get('treatment')) {
        treatmentVal.value = true
    }

    if (url.searchParams.get('health')) {
        healthVal.value = parseInt(url.searchParams.get('health'))
    }

    if (url.searchParams.get('history')) {
        historyVal.value = parseInt(url.searchParams.get('history'))
    }

    if (url.searchParams.get('role')) {
        roleVal.value = parseInt(url.searchParams.get('role'))
    }

    const $targetEl = document.getElementById("dropdownFilter");
    const $triggerEl = document.getElementById("filterButton");

    const options = {
        placement: 'bottom-end',
        triggerType: 'click',
        offsetSkidding: 0,
        offsetDistance: 10,
        delay: 300,
    };

    if ($targetEl) {
        dropdown.value = new Dropdown($targetEl, $triggerEl, options);
        closeDropdown.value = () => {
            dropdown.value.hide();
        }
    }
});

const toggleSearch = () => {
    isSearch.value = !isSearch.value;
    searchInput.value.focus();
}

const toggleToolbar = () => {
    toolbarActive.value = !toolbarActive.value;
}

const closeToolbar = () => {
    toolbarActive.value = false;
}

const closeSearch = () => {
    isSearch.value = false;
    searchInput.value.blur();
}

const bulkAction = () => {
    if (!props.ids.length) {
        modalRef.value.showModal();
    } else {
        if (action.value === 'download') {
            modalDownload.value.showModal();
            axios.post(route("bulkGeneratePDF"),
                {
                    id: props.ids
                },
                {
                    responseType: "blob"
                }).then((response) => {
                    const url = window.URL.createObjectURL(new Blob([response.data]), { type: 'application/zip' });
                    const link = document.createElement('a');
                    link.href = url;
                    link.setAttribute('download', 'file.zip');
                    document.body.appendChild(link);
                    link.click();
                    link.remove();
                    isComplete.value = true;
                    window.location.reload();
                });
        } else {
            emit('modal-show', props.ids, 'bulk')
        }
    }

}

const sortLink = computed(() => {

    let url = new URL(document.location)

    if (url.searchParams.get('page')) {
        url.searchParams.delete('page')
    }

    if (treatmentVal.value) {
        url.searchParams.set("treatment", 1)
    } else {
        url.searchParams.delete('treatment')
    }

    if (historyVal.value) {
        url.searchParams.set("history", historyVal.value)
    } else {
        url.searchParams.delete('history')
    }

    if (healthVal.value) {
        url.searchParams.set("health", healthVal.value)
    } else {
        url.searchParams.delete('health')
    }

    if (roleVal.value) {
        url.searchParams.set("role", roleVal.value)
    } else {
        url.searchParams.delete('role')
    }

    return url.href
});

onClickOutside(elementRef, closeToolbar);
</script>

<template>
    <div class="card-inner position-relative card-tools-toggle">
        <div class="card-title-group">
            <div class="card-tools">
                <div class="form-inline flex-nowrap gx-3">
                    <div class="form-wrap w-150px">
                        <Select2 v-model="action" :options="myOptions" :placeholder="`Bulk Action`"
                            :settings="{ minimumResultsForSearch: -1 }" />
                    </div>
                    <div class="btn-wrap">
                        <span class="d-none d-md-block">
                            <button class="btn btn-dim btn-outline-light" :class="{ 'disabled': !action }"
                                @click.prevent="bulkAction">Apply</button>
                        </span>
                        <span class="d-md-none">
                            <button class="btn btn-dim btn-outline-light btn-icon" :class="{ 'disabled': !action }"
                                @click.prevent="bulkAction">
                                <em class="icon ni ni-arrow-right"></em>
                            </button>
                        </span>
                    </div>
                </div>
            </div>
            <div class="card-tools me-n1">
                <ul class="btn-toolbar gx-1">
                    <li v-if="search">
                        <a href="#" class="btn btn-icon search-toggle toggle-search" :class="isSearch ? 'active' : ''"
                            data-target="search" @click.prevent="toggleSearch">
                            <em class="icon ni ni-search"></em>
                        </a>
                    </li>
                    <li v-if="search" class="btn-toolbar-sep"></li>
                    <li>
                        <div class="toggle-wrap">
                            <a href="#" class="btn btn-icon btn-trigger toggle" :class="toolbarActive ? 'active' : ''"
                                data-target="cardTools" @click.prevent="toggleToolbar">
                                <em class="icon ni ni-menu-right"></em>
                            </a>
                            <div class="toggle-content" :class="toolbarActive ? 'content-active' : ''"
                                data-content="cardTools" ref="elementRef">
                                <ul class="btn-toolbar gx-1">
                                    <li class="toggle-close">
                                        <a href="#" class="btn btn-icon btn-trigger toggle" data-target="cardTools"
                                            @click.prevent="closeToolbar">
                                            <em class="icon ni ni-arrow-left"></em>
                                        </a>
                                    </li>
                                    <li v-if="filter">
                                        <div class="dropdown">
                                            <a class="btn btn-trigger btn-icon dropdown-toggle"
                                                data-dropdown-toggle="filter-menu" data-dropdown-placement="bottom-end">
                                                <div v-if="isFilter" class="dot dot-primary">
                                                </div>
                                                <em class="icon ni ni-filter-alt"></em>
                                            </a>
                                            <div class="filter-wg dropdown-menu dropdown-menu-xl dropdown-menu-end"
                                                id="filter-menu">
                                                <div class="dropdown-head">
                                                    <span class="sub-title dropdown-title">{{ props.filterLabel }}</span>
                                                </div>
                                                <div class="dropdown-body dropdown-body-rg">
                                                    <div class="row gx-6 gy-3">
                                                        <div v-if="treatment" class="col-12">
                                                            <div class="custom-control custom-control-sm custom-checkbox">
                                                                <input v-model="treatmentVal" type="checkbox"
                                                                    class="custom-control-input" id="isTreatment" value="1">
                                                                <label class="custom-control-label" for="isTreatment"> Under
                                                                    Medical Treatment</label>
                                                            </div>
                                                        </div>
                                                        <div v-if="role" class="col-6">
                                                            <div class="form-group">
                                                                <label
                                                                    class="overline-title overline-title-alt">Role</label>
                                                                <Select2 v-model="roleVal" :options="roles"
                                                                    placeholder="-- Select Role --"
                                                                    :settings="{ minimumResultsForSearch: -1 }" />
                                                            </div>
                                                        </div>
                                                        <div v-if="health" class="col-6">
                                                            <div class="form-group">
                                                                <label
                                                                    class="overline-title overline-title-alt">Health</label>
                                                                <Select2 v-model="healthVal" :options="healthOptions"
                                                                    placeholder="-- Select Health --"
                                                                    :settings="{ minimumResultsForSearch: -1 }" />
                                                            </div>
                                                        </div>
                                                        <div v-if="history" class="col-6">
                                                            <div class="form-group">
                                                                <label
                                                                    class="overline-title overline-title-alt">History</label>
                                                                <Select2 v-model="historyVal" :options="historyOptions"
                                                                    placeholder="-- Select History --"
                                                                    :settings="{ minimumResultsForSearch: -1 }" />
                                                            </div>
                                                        </div>
                                                        <div class="col-12">
                                                            <div class="form-group">
                                                                <Link :href="sortLink" class="btn btn-secondary">Filter
                                                                </Link>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="dropdown-foot between">
                                                    <Link class="clickable" :href="props.resetFilter">Reset Filter</Link>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="dropdown">
                                            <a class="btn btn-trigger btn-icon dropdown-toggle" id="filterButton">
                                                <em class="icon ni ni-setting"></em>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-xs dropdown-menu-end"
                                                id="dropdownFilter">
                                                <ul class="link-check">
                                                    <li><span>Show</span></li>
                                                    <Order label="10" attribute="10" />
                                                    <Order label="20" attribute="20" />
                                                    <Order label="50" attribute="50" />
                                                </ul>
                                                <ul class="link-check">
                                                    <li><span>Order</span></li>
                                                    <Sort label="DESC" attribute="DESC" />
                                                    <Sort label="ASC" attribute="ASC" />
                                                </ul>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
        <div v-if="search" class="card-search search-wrap" :class="isSearch ? 'active' : ''" data-search="search">
            <div class="card-body">
                <form @submit.prevent="form.get(searchUrl)">
                    <div class="search-content">
                        <a href="#" class="search-back btn btn-icon toggle-search" data-target="search"
                            @click.prevent="closeSearch">
                            <em class="icon ni ni-arrow-left"></em>
                        </a>
                        <input type="text" class="form-control border-transparent form-focus-none"
                            :placeholder="searchPlaceholder" ref="searchInput" v-model="form.search">
                        <button class="search-submit btn btn-icon" type="submit">
                            <em class="icon ni ni-search"></em>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <ModalDialog ref="modalRef" :id="`modalAlert`" :data-modal-target="`modalAlert`" :message="alertMessage"
        help="If you need help please contact support." icon="ni-cross" color="bg-danger" label="Error" alert />
    <ModalDialog ref="modalDownload" :id="`modalDownload`" :data-modal-target="`modalDownload`"
        message="Wait while we prepare the pdf document!" icon="ni-loader" color="bg-info" label="Download" download
        :complete="isComplete" />
</template>