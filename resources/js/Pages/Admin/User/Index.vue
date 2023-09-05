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
  users: {
    type: Object,
    default: () => ({}),
  },
  roles: {
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
      text: 'Delete User',
    }],
  },
})

const emit = defineEmits(['modal-confirm', 'modal-close', 'modal-show']);

const modalRef = ref();
const success = ref(false);
const ids = ref([]);

function confirmModal(id, bulk) {
  modalRef.value.showModal(id, bulk);
}

function destroy(id, bulk) {

  const bulkForm = useForm({
    id: id,
    bulk: bulk
  })

  bulkForm.post(route("bulk.delete.user"), {
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
    return props.users.data ? ids.value.length == props.users.data.length : false;
  },
  set(value) {
    var checked = [];
    if (value) {
      props.users.data.forEach(function (user) {
        checked.push(user.id);
      });
    }
    ids.value = checked;
  }
})

const computedRoles = computed(() => {

  var roles = [];
  props.roles.forEach(function (role) {
    roles.push({ id: role.id, text: role.name });
  });
  return roles;
});

onUnmounted(() => success.value = false);
</script>

<template>
  <AuthenticatedLayout>

    <Head title="Users" />

    <div class="container-fluid">
      <div class="nk-content-inner">
        <div class="nk-content-body">
          <div class="nk-block-head nk-block-head-sm">
            <div class="nk-block-between">
              <div class="nk-block-head-content">
                <h3 class="nk-block-title page-title">Users</h3>
                <div class="nk-block-des text-soft">
                  <p>You have total {{ users.total }} users.</p>
                </div>
              </div>
              <TopSortRight label="Add user" :href="route('user.create')" create />
            </div>
          </div>

          <div class="nk-block">
            <div class="card card-bordered">
              <div class="card-inner-group">
                <TableFilter :ids="ids" @modal-show="confirmModal" search-placeholder="Search by name, or email"
                  :search-url="route('user.index')" :my-options="bulkOptions" :filters="props.filters" filter
                  filter-label="Filter Users" role :roles="computedRoles" :reset-filter="route('user.index')"
                  alert-message="Select at least one user" search />
                <template v-if="users.data.length">
                  <div class="card-inner p-0">
                    <div class="nk-tb-list nk-tb-ulist">
                      <div class="nk-tb-item nk-tb-head">
                        <div class="nk-tb-col nk-tb-col-check">
                          <div class="custom-control custom-control-sm custom-checkbox notext">
                            <input type="checkbox" class="custom-control-input" v-model="checkAll" id="uid">
                            <label class="custom-control-label" for="uid"></label>
                          </div>
                        </div>
                        <div class="nk-tb-col"><span class="sub-text">Name</span></div>
                        <div class="nk-tb-col"><span class="sub-text">Email</span></div>
                        <div class="nk-tb-col tb-col-mb"><span class="sub-text">Last Login</span></div>
                        <div class="nk-tb-col tb-col-md"><span class="sub-text">Created At</span></div>
                        <div class="nk-tb-col nk-tb-col-tools text-end">

                        </div>
                      </div>
                      <div v-for="user in users.data" :key="user.id" class="nk-tb-item">
                        <div class="nk-tb-col nk-tb-col-check">
                          <div class="custom-control custom-control-sm custom-checkbox notext">
                            <input type="checkbox" class="custom-control-input" v-model="ids" :id="`uid` + user.id"
                              :value="user.id">
                            <label class="custom-control-label" :for="`uid` + user.id"></label>
                          </div>
                        </div>
                        <div class="nk-tb-col">
                          <Link :href="route('user.edit', user.id)">
                          <div class="user-card">
                            <div v-if="user.abbr_name" class="user-avatar bg-primary"><span>{{
                              user.abbr_name
                            }}</span></div>
                            <div class="user-info">
                              <span class="tb-lead">{{ user.name }}
                                <span class="dot dot-success d-md-none ms-1"></span>
                              </span>
                            </div>
                          </div>
                          </Link>
                        </div>
                        <div class="nk-tb-col"><span>{{ user.email }} </span></div>
                        <div class="nk-tb-col tb-col-mb">
                          <span v-if="user.last_login_at">{{ new Date(user.last_login_at).toLocaleString('en-IN', {dateStyle:'medium',timeStyle: 'short'}) }} </span>
                        </div>
                        <div class="nk-tb-col tb-col-md">
                          <span v-if="user.created_at">{{ new Date(user.created_at).toLocaleString('en-IN', {dateStyle:'medium',timeStyle: 'short'}) }} </span>
                        </div>
                        <div class="nk-tb-col nk-tb-col-tools">
                          <ul class="nk-tb-actions gx-1">
                            <li class="nk-tb-action-hidden">
                              <CTooltip content="View Details" placement="top">
                                <template #toggler="{ on }">
                                  <Link :href="route('user.edit', user.id)" class="btn btn-trigger btn-icon" v-on="on"
                                    aria-label="View Details">
                                  <em class="icon ni ni-eye"></em>
                                  </Link>
                                </template>
                              </CTooltip>
                            </li>
                            <li class="nk-tb-action-hidden">
                              <CTooltip content="Move to Trash" placement="top">
                                <template #toggler="{ on }">
                                  <a href="#" class="btn btn-trigger btn-icon" v-on="on" aria-label="Move to Trash"
                                    @click.prevent="confirmModal(user.id)">
                                    <em class="icon ni ni-trash"></em>
                                  </a>
                                </template>
                              </CTooltip>
                            </li>
                            <li>
                              <div class="drodown">
                                <a class="dropdown-toggle btn btn-icon btn-trigger" data-bs-toggle="dropdown"
                                  :data-dropdown-toggle="`tb-action-u-` + user.id"
                                  data-dropdown-placement="bottom-end"><em class="icon ni ni-more-h"></em></a>
                                <div class="dropdown-menu dropdown-menu-end" :id="`tb-action-u-` + user.id">

                                  <ul class="link-list-opt no-bdr">
                                    <li>
                                      <Link :href="route('user.edit', user.id)">
                                      <em class="icon ni ni-eye"></em>
                                      <span>View Details</span>
                                      </Link>
                                    </li>
                                    <li class="divider"></li>
                                    <li>
                                      <a href="#" @click.prevent="confirmModal(user.id)">
                                        <em class="icon ni ni-trash"></em>
                                        <span>Delete</span>
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
                  <CustomPagination :data="users" />
                </template>
                <template v-else>
                  <div class="card-inner p-0">
                    <NoRecord label="users" />
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
