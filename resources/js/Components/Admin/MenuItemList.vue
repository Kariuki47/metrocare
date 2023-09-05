<script setup>
import { Link, useForm } from "@inertiajs/vue3"
import BaseButton from "@/Components/BaseButton.vue"
import BaseButtons from "@/Components/BaseButtons.vue"
import {
  mdiSquareEditOutline,
  mdiTrashCan,
} from "@mdi/js"

const props = defineProps({
  item: {
    type: Object,
    default: () => ({}),
  },
  menu: {
    type: Object,
    default: () => ({}),
  },
  can: {
    type: Object,
    default: () => ({}),
  },
  level: {
    type: Number,
    default: 0
  },
})

const formDelete = useForm({})

function destroy(id) {
  if (confirm("Are you sure you want to delete?")) {
    formDelete.delete(route("menu.item.destroy", {menu: props.menu.id, item: id}))
  }
}
</script>

<template>
    <tr :key="item.id">
        <td data-label="Name" class="border-b border-slate-100 dark:border-slate-700 p-4 pl-6 text-slate-500 dark:text-slate-400">
            <div :style="{ 'margin-left': level*20 + 'px' }">{{ item.name }}</div>
        </td>
        <td data-label="Description" class="border-b border-slate-100 dark:border-slate-700 p-4 pl-6 text-slate-500 dark:text-slate-400">
            {{ item.description }}
        </td>
        <td data-label="Enabled" class="border-b border-slate-100 dark:border-slate-700 p-4 pl-6 text-slate-500 dark:text-slate-400">
            {{ item.enabled }}
        </td>
        <td class="border-b border-slate-100 dark:border-slate-700 p-4 pl-6 text-slate-500 dark:text-slate-400">
        <BaseButtons type="justify-start lg:justify-end" no-wrap>
            <BaseButton
            :route-name="route('menu.item.edit', {menu: menu.id, item: item.id})"
            color="info"
            :icon="mdiSquareEditOutline"
            small
            />
            <BaseButton
            color="danger"
            :icon="mdiTrashCan"
            small
            @click="destroy(item.id)"
            />
        </BaseButtons>
        </td>
    </tr>
    <template v-for="item in item.children">
        <MenuItemList :item="item" :menu="menu" :can="can" :level="level + 1" />
    </template>
</template>