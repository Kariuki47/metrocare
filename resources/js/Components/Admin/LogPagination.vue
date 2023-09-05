<script setup>
import { computed } from "vue"
import { Link, router } from '@inertiajs/vue3'
import { Select2 } from "select2-vue-component"

const props = defineProps({
    data: {
        type: Object,
        default: () => ({}),
    },
    myOptions: {
        type: Object,
        default: [{
            value: 1,
            label: 1,
        },
        {
            value: 2,
            label: 2,
        },
        {
            value: 3,
            label: 3,
        }],
    },
})

const links = computed(() => {
    const base = [];

    for (const [key, value] of Object.entries(props.data.links)) {
        if (key > 0 && key < props.data.last_page + 1) {
            base.push({ value: parseInt(value.label), label: value.label });
        }
    }

    return base
})

function update($event){
    if(props.data.current_page != $event){
        
        const result = props.data.links.find(({ label }) => label === $event.toString());
        if(result !== undefined){
            router.visit(result.url);
        }
        
        //window.location.href = '/search?q=' + this.searchData;
    }
}

</script>

<template>
        <div v-if="data.links.length > 3" class="row align-items-center">
            <div class="col-7 col-sm-12 col-md-9">
                <ul class="pagination justify-content-center justify-content-md-start">
                    <li v-if="data.current_page <= 1" class="page-item disabled">
                        <a class="page-link">Prev</a>
                    </li>
                    <li v-else class="page-item">
                        <Link :href="data.prev_page_url" class="page-link">Prev</Link>
                    </li>
                    <template v-for="(link, key) in data.links">
                        <template v-if="key > 0 && key < data.last_page + 1">
                            <li v-if="!link.active && link.url === null" :key="key" class="page-item disabled"
                                aria-disabled="true">
                                <a class="page-link">{{ link.label }}</a>
                            </li>

                            <li v-else-if="link.active" :key="`current-${key}`" class="page-item active"
                                aria-current="page">
                                <a href="#" class="page-link" @click.prevent>{{ link.label }}</a>
                            </li>

                            <li v-else class="page-item">
                                <Link :key="`link-${key}`" :href="link.url" v-html="link.label" class="page-link"
                                    aria-label="`Go to page ${link.label}`" />
                            </li>
                        </template>
                    </template>
                    <li v-if="data.current_page < data.last_page" class="page-item">
                        <Link :href="data.next_page_url" class="page-link">Next</Link>
                    </li>
                    <li v-else class="page-item disabled">
                        <a class="page-link">Next</a>
                    </li>
                </ul>
            </div>
            <div class="col-5 col-sm-12 col-md-3 text-start text-md-end">
                <div class="pagination-goto d-flex justify-content-center justify-content-md-start gx-3">
                    <div>Page</div>
                    <div>
                        <Select2 :data="links" :value="data.current_page" @update="update($event)"/>
                    </div>
                    <div>OF {{ data.last_page }}</div>
                </div>
            </div>
        </div>
</template>