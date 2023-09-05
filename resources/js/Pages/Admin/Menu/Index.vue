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
  menus: {
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
  bulkOptions: {
    type: Object,
    default: [{
      id: 'delete',
      text: 'Delete Menu',
    }],
  },
})

const emit = defineEmits(['modal-confirm', 'modal-close', 'modal-show']);

const modalRef = ref();
const success = ref(false);
const ids = ref([]);

function destroy(id, bulk) {

  const bulkForm = useForm({
    id: id,
    bulk: bulk
  })

  bulkForm.post(route("bulk.delete.menu"), {
    onSuccess: () => {
      success.value = true
      ids.value = []
    },
  })

}

function confirmModal(id, bulk) {

  modalRef.value.showModal(id, bulk);
}

const modalClose = () => {
  success.value = false;
}

const checkAll = computed({
  get() {
    return props.menus.data ? ids.value.length == props.menus.data.length : false;
  },
  set(value) {
    var checked = [];
    if (value) {
      props.menus.data.forEach(function (menu) {
        checked.push(menu.id);
      });
    }
    ids.value = checked;
  }
})

onUnmounted(() => success.value = false);
</script>

<template>
  <Head title="Menus" />
  <AuthenticatedLayout>
    <div class="container-fluid">
      <div class="nk-content-inner">
        <div class="nk-content-body">
          <div class="nk-block-head nk-block-head-sm">
            <div class="nk-block-between">
              <div class="nk-block-head-content">
                <h3 class="nk-block-title page-title">Menu</h3>
                <div class="nk-block-des text-soft">
                  <p>You have total {{ menus.total }} menus.</p>
                </div>
              </div>
              <TopSortRight label="Add menu" :href="route('menu.create')" create />
            </div>
          </div>

          <div class="nk-block">
            <div class="card card-bordered">
              <div class="card-inner-group">
                <TableFilter :ids="ids" @modal-show="confirmModal" alert-message="Select at least one item"
                  :my-options="bulkOptions" />
                <template v-if="menus.data.length">
                  <div class="card-inner p-0">
                    <div class="nk-tb-list nk-tb-ulist">
                      <div class="nk-tb-item nk-tb-head">
                        <div class="nk-tb-col nk-tb-col-check">
                          <div class="custom-control custom-control-sm custom-checkbox notext">
                            <input type="checkbox" class="custom-control-input" v-model="checkAll" id="mid">
                            <label class="custom-control-label" for="mid"></label>
                          </div>
                        </div>
                        <div class="nk-tb-col"><span class="sub-text">Name</span></div>
                        <div class="nk-tb-col"><span class="sub-text">Description</span></div>
                        <div class="nk-tb-col nk-tb-col-tools text-end">

                        </div>
                      </div>
                      <div v-for="menu in menus.data" :key="menu.id" class="nk-tb-item">
                        <div class="nk-tb-col nk-tb-col-check">
                          <div class="custom-control custom-control-sm custom-checkbox notext">
                            <input type="checkbox" class="custom-control-input" v-model="ids" :id="`mid` + menu.id"
                              :value="menu.id">
                            <label class="custom-control-label" :for="`mid` + menu.id"></label>
                          </div>
                        </div>
                        <div class="nk-tb-col">
                          <Link :href="route('menu.edit', menu.id)">
                          <span> {{ menu.name }}</span>
                          </Link>
                        </div>
                        <div class="nk-tb-col"><span>{{ menu.description }} </span></div>
                        <div class="nk-tb-col nk-tb-col-tools">
                          <ul class="nk-tb-actions gx-1">
                            <li class="nk-tb-action-hidden">
                              <CTooltip content="Move to Trash" placement="top">
                                <template #toggler="{ on }">
                                  <a href="#" class="btn btn-trigger btn-icon" v-on="on" aria-label="Move to Trash"
                                    @click.prevent="confirmModal(menu.id)">
                                    <em class="icon ni ni-trash"></em>
                                  </a>
                                </template>
                              </CTooltip>
                            </li>
                            <li class="nk-tb-action-hidden">
                              <CTooltip content="Edit Menu" placement="top">
                                <template #toggler="{ on }">
                                  <Link :href="route('menu.edit', menu.id)" class="btn btn-trigger btn-icon" v-on="on"
                                    aria-label="Edit Menu">
                                  <em class="icon ni ni-edit"></em>
                                  </Link>
                                </template>
                              </CTooltip>
                            </li>
                            <li class="nk-tb-action-hidden">
                              <CTooltip content="Edit Menu Items" placement="top">
                                <template #toggler="{ on }">
                                  <Link :href="route('menu.item.index', menu.id)" class="btn btn-trigger btn-icon"
                                    v-on="on" aria-label="Edit Menu Items">
                                  <em class="icon ni ni-setting-alt"></em>
                                  </Link>
                                </template>
                              </CTooltip>
                            </li>
                            <li>
                              <div class="drodown">
                                <a class="dropdown-toggle btn btn-icon btn-trigger" data-bs-toggle="dropdown"
                                  :data-dropdown-toggle="`tb-action-m-` + menu.id"
                                  data-dropdown-placement="bottom-end"><em class="icon ni ni-more-h"></em></a>
                                <div class="dropdown-menu dropdown-menu-end" :id="`tb-action-m-` + menu.id">

                                  <ul class="link-list-opt no-bdr">
                                    <li>
                                      <Link :href="route('menu.edit', menu.id)">
                                      <em class="icon ni ni-edit"></em>
                                      <span>Edit Menu</span>
                                      </Link>
                                    </li>
                                    <li>
                                      <Link :href="route('menu.item.index', menu.id)">
                                      <em class="icon ni ni-setting-alt"></em>
                                      <span>Edit Menu Items</span>
                                      </Link>
                                    </li>
                                    <li class="divider"></li>
                                    <li>
                                      <a href="#" @click.prevent="confirmModal(menu.id)">
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
                  <CustomPagination :data="menus" />
                </template>
                <template v-else>
                  <div class="card-inner p-0">
                    <NoRecord label="menus" />
                  </div>
                </template>
              </div>
            </div>
          </div>

          <ModalDialog ref="modalRef" :id="`modalDialog`" :data-modal-target="`modalDialog`"
            :message="success ? $page.props.flash.message : 'Are you sure you want to delete this?'"
            :icon="success ? 'ni-check' : 'ni-cross'" :color="success ? 'bg-success' : 'bg-danger'"
            :label="success ? 'Deleted' : 'Delete'" @modal-confirm="(id, bulk) => destroy(id, bulk)"
            @modal-close="modalClose" :success="success" />

        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
