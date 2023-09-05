<script setup>
import { ref, onMounted } from "vue"
import { useConfirmDialog } from '@vueuse/core'

const {
    isRevealed,
    reveal,
    confirm,
    cancel,
    onReveal,
    onConfirm,
    onCancel,
} = useConfirmDialog()

const modal = ref();
const accept = ref(false);
const actionId = ref(0);
const action = ref(false);
const showModal = ref(() => { });
const closeModal = ref(() => { });
const props = defineProps({
    id: {
        type: String,
        default: null
    },
    message: {
        type: String,
        default: null
    },
    color: {
        type: String,
        default: null
    },
    icon: {
        type: String,
        default: null
    },
    label: {
        type: String,
        default: null
    },
    help: {
        type: String,
        default: null
    },
    complete: {
        type: String,
        default: null
    },
    success: Boolean,
    alert: Boolean,
    download: Boolean,
})

const emit = defineEmits(['modal-confirm', 'modal-close'])

onMounted(() => {

    const $targetEl = document.getElementById(props.id);

    const options = {
        placement: 'center',
        backdrop: 'dynamic',
        backdropClasses: 'modal-backdrop fade show',
        closable: true,
        onHide: () => {
            accept.value = false;
            emit('modal-close')
        },
    };

    if ($targetEl) {
        modal.value = new Modal($targetEl, options);

        showModal.value = (id, bulk) => {
            actionId.value = id;
            if (bulk) {
                action.value = true;
            } else {
                action.value = false;
            }
            modal.value.show();
        }
        closeModal.value = () => {
            modal.value.hide();
        }
    }

})

defineExpose({
    showModal
})

onConfirm(() => {
    accept.value = true;
    modalConfirm();
    //modal.value.hide();
    //formDelete.delete(route("patient.destroy", id))
})

onCancel(() => {
    modal.value.hide();
})

const modalConfirm = () => {
    emit('modal-confirm', actionId.value, action.value)
}

</script>

<template>
    <div class="modal fade" tabindex="-1" role="dialog" :id="id">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <a href="#" class="close" @click.prevent="closeModal"><em class="icon ni ni-cross"></em></a>
                <div class="modal-body modal-body-lg text-center">
                    <div class="nk-modal py-4">
                        <em v-if="icon" class="nk-modal-icon icon icon-circle icon-circle-xxl ni"
                            :class="[icon, color]"></em>
                        <h4 v-if="label" class="nk-modal-title">{{ label }}</h4>
                        <div class="nk-modal-text mt-n2">
                            <p :class="alert ? 'lead' : 'text-soft'">{{ message }}</p>
                            <p v-if="alert" class="text-soft">{{ help }}</p>
                        </div>
                        <div v-if="success" class="nk-modal-action">
                            <a href="#" @click.prevent="closeModal" class="btn btn-lg btn-mw btn-primary">OK</a>
                        </div>
                        <div v-else-if="alert" class="nk-modal-action">
                            <a href="#" @click.prevent="closeModal" class="btn btn-lg btn-mw btn-light">Return</a>
                        </div>
                        <div v-else-if="download" class="nk-modal-action">
                            <ul class="d-flex justify-content-center gx-4 mt-4">
                                <li>
                                    <a v-if="complete" @click.prevent="closeModal" class="btn btn-lg btn-mw btn-light">Return</a>
                                    <button v-else type="button" class="btn btn-success disabled">
                                        <span class="spinner-border spinner-border-sm" role="status"
                                            aria-hidden="true"></span>
                                        <span>Loading...</span>
                                    </button>
                                </li>
                            </ul>
                        </div>
                        <ul v-else class="d-flex justify-content-center gx-4 mt-4">
                            <li>
                                <button v-if="accept" type="button" class="btn btn-success disabled">
                                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                    <span>Loading...</span>
                                </button>
                                <button v-else type="button" class="btn btn-success" @click.prevent="confirm">Yes, {{ label
                                }} it</button>
                            </li>
                            <li>
                                <button data-dismiss="modal" class="btn btn-danger btn-dim"
                                    @click.prevent="cancel">Cancel</button>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
