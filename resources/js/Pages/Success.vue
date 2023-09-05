<script setup>
import { Head } from "@inertiajs/vue3"
import PlainLayout from "@/Layouts/PlainLayout.vue"

</script>

<template>
    <PlainLayout>

        <Head title="Success" />

        <div class="nk-block nk-block-middle wide-xs mx-auto">
            <div class="nk-block-content nk-error-ld text-center">
                    <em class="icon icon-circle icon-circle-xxl ni ni-check bg-success"></em>
                    <h4 class="mt-2">Details added successful!</h4>
                    <div class="mb-2">
                        <div class="caption-text">We will review the details and get back to you as soon as possible.<br>Regards</div>
                    </div>
            </div>
        </div>
    </PlainLayout>
</template>
