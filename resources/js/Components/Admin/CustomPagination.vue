<script setup>
import { ref, computed } from "vue"
import { Link, router } from '@inertiajs/vue3'
import Select2 from 'vue3-select2-component'

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

const page = ref(props.data.current_page.toString())

const links = computed(() => {
    const base = [];

    for (let i = 1; i < props.data.last_page + 1; i++) {
        base.push({ id: i, text: i });
    }

    return base
})

function update({ id }) {

    if (props.data.current_page != id) {

        const result = props.data.links.find(({ label }) => label === id);
        if (result !== undefined) {
            router.visit(result.url);
        }

        //window.location.href = '/search?q=' + this.searchData;
    }
}

</script>

<template>
    <div v-if="data.links.length > 3" class="card-inner">
        <div class="nk-block-between-md g-3">
            <div class="g d-none d-sm-block">
                <ul class="pagination justify-content-center justify-content-md-start">
                    <template v-for="(link, key) in data.links">
                        <li v-if="!link.active && link.url === null" :key="key" class="page-item disabled"
                            aria-disabled="true">
                            <a class="page-link" v-html="link.label" @click.prevent></a>
                        </li>

                        <li v-else-if="link.active" :key="`current-${key}`" class="page-item active" aria-current="page">
                            <a href="#" class="page-link" v-html="link.label" @click.prevent></a>
                        </li>

                        <li v-else class="page-item">
                            <Link :key="`link-${key}`" :href="link.url" v-html="link.label" class="page-link"
                                :aria-label="`Go to page ${link.label}`" />
                        </li>
                    </template>
                </ul>
            </div>
            <div class="g">
                <div class="flex justify-between justify-content-sm-center flex-1">
                    <div class="inline-flex items-center d-sm-none">
                        <span v-if="data.current_page <= 1"
                            class="relative px-3 py-1 text-xs font-small text-gray-500 bg-white border border-gray-300 cursor-default leading-5 rounded-md">
                            <em class="icon ni ni-chevron-left text-xl align-middle"></em>
                        </span>
                        <Link v-else :href="data.prev_page_url"
                            class="relative px-3 py-1 text-xs font-small text-gray-700 bg-white border border-gray-300 leading-5 rounded-md hover:text-gray-500 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150">
                        <em class="icon ni ni-chevron-left text-xl align-middle"></em>
                        </Link>
                    </div>
                    <div class="pagination-goto d-flex justify-content-center justify-content-md-start gx-3 flex-xs-column">
                        <div>Page</div>
                        <div>
                            <Select2 v-model="page" :options="links" :settings="{ minimumResultsForSearch: -1 }"
                                @select="update($event)" />
                        </div>
                        <div>OF {{ data.last_page }}</div>
                    </div>
                    <div class="inline-flex items-center d-sm-none">
                        <Link v-if="data.current_page < data.last_page" :href="data.next_page_url"
                            class="relative px-3 py-1 ml-3 text-xs font-small text-gray-700 bg-white border border-gray-300 leading-5 rounded-md hover:text-gray-500 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150">
                            <em class="icon ni ni-chevron-right text-xl align-middle"></em>
                        </Link>
                        <span v-else
                            class="relative px-3 py-1 ml-3 text-xs font-small text-gray-500 bg-white border border-gray-300 cursor-default leading-5 rounded-md">
                            <em class="icon ni ni-chevron-right text-xl align-middle"></em>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>