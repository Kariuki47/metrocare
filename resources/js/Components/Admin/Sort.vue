<script setup>
import { computed } from "vue"
import { Link } from "@inertiajs/vue3"

const props = defineProps({
  label: {
    type: String,
    default: "",
  },
  attribute: {
    type: String,
    default: "",
  },
})

const sortLink = computed(() => {
  let url = new URL(document.location)

  if (url.searchParams.get('page')) {
    url.searchParams.delete('page')
  }
  url.searchParams.set("sort", props.attribute)

  return url.href
});

const activeClass = computed(() => {

  let url = new URL(document.location)
  let sortValue = url.searchParams.get("sort")

  if (sortValue == props.attribute) {
    return 'active';
  }else if(!sortValue && props.attribute === 'DESC'){
    return 'active';
  } else {
    return '';
  }
});
</script>

<template>
  <li :class="activeClass">
    <Link :href="sortLink"><span>{{ label }}</span>
    </Link>
  </li>
</template>