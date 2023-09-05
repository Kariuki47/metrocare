<script setup>
import { computed } from 'vue'
import { Link } from '@inertiajs/vue3'

const props = defineProps({
    id: {
        type: [String, Number],
        default: null
    },
})
</script>

<template>
    <div
        class="text-sm font-medium text-center text-gray-500 border-b border-gray-200 dark:text-gray-400 dark:border-gray-700">
        <ul class="flex flex-wrap -mb-px">
            <li class="mr-2">
                <Link :href="route('patient.edit', id)" class="inline-block p-4 border-b-2 rounded-t-lg"
                    :class="route().current('patient.edit') ? 'text-blue-600 border-blue-600 active dark:text-blue-500 dark:border-blue-500' : 'border-transparent hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300'">
                Details
                </Link>
            </li>
            <li class="mr-2">
                <Link :href="route('respiratory-system.edit', id)" class="inline-block p-4 border-b-2 rounded-t-lg"
                    :class="route().current('respiratory-system.edit') ? 'text-blue-600 border-blue-600 active dark:text-blue-500 dark:border-blue-500' : 'border-transparent hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300'">
                Respiratory
                </Link>
            </li>
            <li class="mr-2">
                <Link :href="route('cardiovascular-system.edit', id)" class="inline-block p-4 border-b-2 rounded-t-lg"
                    :class="route().current('cardiovascular-system.edit') ? 'text-blue-600 border-blue-600 active dark:text-blue-500 dark:border-blue-500' : 'border-transparent hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300'">
                    Cardiovascular
                </Link>
            </li>
            <li class="mr-2">
                <Link :href="route('gastro-intestinal.edit', id)" class="inline-block p-4 border-b-2 rounded-t-lg"
                    :class="route().current('gastro-intestinal.edit') ? 'text-blue-600 border-blue-600 active dark:text-blue-500 dark:border-blue-500' : 'border-transparent hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300'">
                    Gastrointenstinal
                </Link>
            </li>
            <li class="mr-2">
                <Link :href="route('genito-urinary-system.edit', id)" class="inline-block p-4 border-b-2 rounded-t-lg"
                    :class="route().current('genito-urinary-system.edit') ? 'text-blue-600 border-blue-600 active dark:text-blue-500 dark:border-blue-500' : 'border-transparent hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300'">
                    Genital
                </Link>
            </li>
            <li class="mr-2">
                <Link :href="route('central-nervous-system.edit', id)" class="inline-block p-4 border-b-2 rounded-t-lg"
                    :class="route().current('central-nervous-system.edit') ? 'text-blue-600 border-blue-600 active dark:text-blue-500 dark:border-blue-500' : 'border-transparent hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300'">
                    Central Nervous
                </Link>
            </li>
            <li class="mr-2">
                <Link :href="route('skin-teguments.edit', id)" class="inline-block p-4 border-b-2 rounded-t-lg"
                    :class="route().current('skin-teguments.edit') ? 'text-blue-600 border-blue-600 active dark:text-blue-500 dark:border-blue-500' : 'border-transparent hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300'">
                    Skin & Teguments
                </Link>
            </li>
            <li class="mr-2">
                <Link :href="route('skeletal-system.edit', id)" class="inline-block p-4 border-b-2 rounded-t-lg"
                    :class="route().current('skeletal-system.edit') ? 'text-blue-600 border-blue-600 active dark:text-blue-500 dark:border-blue-500' : 'border-transparent hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300'">
                    Skeletal
                </Link>
            </li>
            <li class="mr-2">
                <Link :href="route('sensory-organ.edit', id)" class="inline-block p-4 border-b-2 rounded-t-lg"
                    :class="route().current('sensory-organ.edit') ? 'text-blue-600 border-blue-600 active dark:text-blue-500 dark:border-blue-500' : 'border-transparent hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300'">
                    Sensory
                </Link>
            </li>
            <li class="mr-2">
                <Link :href="route('past-medical-history.edit', id)" class="inline-block p-4 border-b-2 rounded-t-lg"
                    :class="route().current('past-medical-history.edit') ? 'text-blue-600 border-blue-600 active dark:text-blue-500 dark:border-blue-500' : 'border-transparent hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300'">
                    Medical
                    History
                </Link>
            </li>
            <li class="mr-2">
                <Link :href="route('social-history.edit', id)" class="inline-block p-4 border-b-2 rounded-t-lg"
                    :class="route().current('social-history.edit') ? 'text-blue-600 border-blue-600 active dark:text-blue-500 dark:border-blue-500' : 'border-transparent hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300'">
                    Social
                </Link>
            </li>
            <li class="mr-2">
                <Link :href="route('family-history.edit', id)" class="inline-block p-4 border-b-2 rounded-t-lg"
                    :class="route().current('family-history.edit') ? 'text-blue-600 border-blue-600 active dark:text-blue-500 dark:border-blue-500' : 'border-transparent hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300'">
                    Family
                </Link>
            </li>
            <li class="mr-2">
                <Link :href="route('general-appearance.edit', id)" class="inline-block p-4 border-b-2 rounded-t-lg"
                    :class="route().current('general-appearance.edit') ? 'text-blue-600 border-blue-600 active dark:text-blue-500 dark:border-blue-500' : 'border-transparent hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300'">
                    Appearance
                </Link>
            </li>
            <li class="mr-2">
                <Link :href="route('blood-pressure.edit', id)" class="inline-block p-4 border-b-2 rounded-t-lg"
                    :class="route().current('blood-pressure.edit') ? 'text-blue-600 border-blue-600 active dark:text-blue-500 dark:border-blue-500' : 'border-transparent hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300'">
                    Blood
                    Pressure
                </Link>
            </li>
            <li class="mr-2">
                <Link :href="route('admin.examination.conclusion', id)" class="inline-block p-4 border-b-2 rounded-t-lg"
                    :class="route().current('admin.examination.conclusion') ? 'text-blue-600 border-blue-600 active dark:text-blue-500 dark:border-blue-500' : 'border-transparent hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300'">
                    Conclusion
                </Link>
            </li>
        </ul>
    </div>
</template>
