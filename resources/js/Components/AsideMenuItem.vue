<script setup>
import { ref, computed } from 'vue'
import { Link } from '@inertiajs/vue3'
import MenuBaseIcon from '@/Components/MenuBaseIcon.vue'
import AsideMenuList from '@/Components/AsideMenuList.vue'
import AnimateHeight from 'vue-animate-height'

const props = defineProps({
  item: {
    type: Object,
    required: true
  },
  isDropdownList: Boolean,
})

const height = ref(0);
const toggle = () => height.value = height.value === 0 ? 'auto' : 0;

const itemHref = computed(() => (props.item && props.item.link) ? props.item.link : '')

const hasDropdown = computed(() => props.item.children)

const activeClass = computed(() => {
  var currentUrl = window.location.pathname;
   
   //console.log(currentUrl.match('/admin/menu*'))
  if (props.item.children) {
    let childItems = Object.entries(props.item.children);
    for (const [key, value] of childItems) {
      
      if (currentUrl.match(value.link + '/*') && value.link !== '/') {
      //if(value.link ===currentUrl){
        height.value = 'auto';
        return 'current-page';
      }else if(value.link ===currentUrl && value.link === '/'){
        height.value = 'auto';
        return 'current-page';
      }
    }
  }
  if (currentUrl.match(itemHref.value + '/*') && itemHref.value !== '/') {
    return 'active current-page';
  } else if(currentUrl === itemHref.value && itemHref.value === '/') {
    return 'active current-page';
  }else {
    return '';
  }
})

</script>

<template>
  <li class="nk-menu-item"
    :class="[(hasDropdown ? 'has-sub' : ''), activeClass, (height !== 0 && hasDropdown ? 'active' : '')]">
    <a v-if="hasDropdown" href="#" class="nk-menu-link" :class="[(hasDropdown ? 'nk-menu-toggle' : '')]"
      @click.prevent="toggle">
      <MenuBaseIcon v-if="item.icon" :path="item.icon" class="nk-menu-icon" />
      <span class="nk-menu-text">{{ item.name }}</span>
    </a>
    <component v-else :is="itemHref ? Link : 'div'" :href="itemHref" :target="item.target ?? null" class="nk-menu-link"
      :class="[(hasDropdown ? 'nk-menu-toggle' : '')]">
      <MenuBaseIcon v-if="item.icon" :path="item.icon" class="nk-menu-icon" />
      <span class="nk-menu-text">{{ item.name }}</span>
    </component>
    <AnimateHeight :id='`example-panel-` + item.id' :duration="500" :height="height">
      <AsideMenuList v-if="hasDropdown" :menu="item.children" class="nk-menu-sub" is-dropdown-list />
    </AnimateHeight>
  </li>
</template>
