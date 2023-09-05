<script setup>
import { ref, onMounted } from "vue"

const modal = ref();
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
    title: {
        type: String,
        default: null
    },
    success: Boolean,
})

const emit = defineEmits(['modal-close'])

onMounted(() => {

    const $targetEl = document.getElementById(props.id);

    const options = {
        placement: 'center',
        backdrop: 'dynamic',
        backdropClasses: 'modal-backdrop fade show',
        closable: true,
        onHide: () => {
            emit('modal-close')
        },
    };

    if ($targetEl) {
        modal.value = new Modal($targetEl, options);

        showModal.value = () => {
            modal.value.show();
        }
        closeModal.value = () => {
            modal.value.hide();
        }
    }

})

defineExpose({
    showModal,
    closeModal
})

</script>

<template>
    <div class="modal fade" tabindex="-1" role="dialog" :id="id">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <a href="#" class="close" @click.prevent="closeModal"><em class="icon ni ni-cross"></em></a>
                <div class="modal-body modal-body-lg">
                    <h5 v-if="title" class="title">{{ title }}</h5>
                    <slot />
                </div>
            </div>
        </div>
    </div>
</template>
