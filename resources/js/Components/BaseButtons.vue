<script>
import { h, defineComponent } from 'vue'

export default defineComponent({
  name: 'BaseButtons',
  props: {
    noWrap: Boolean,
    type: {
      type: String,
      default: null
    },
    classAddon: {
      type: String,
      default: null
    },
    mb: {
      type: String,
      default: null
    }
  },
  render () {
    const hasSlot = this.$slots && this.$slots.default

    const parentClass = [
      //'flex justify-end mt-4',
      //'items-center',
      //this.type,
      //this.noWrap ? 'flex-nowrap' : 'flex-wrap'
    ]

    /*if (this.mb) {
      parentClass.push(this.mb)
    }*/

    return h(
      'div',
      { class: parentClass },
      hasSlot
        ? this.$slots.default().map(element => {
          if (element && element.children && typeof element.children === 'object') {
            return h(
              element,
              {},
              element.children.map(child => {
                return h(child, { class: [this.classAddon] })
              }))
          }

          return h(element, { class: [this.classAddon] })
        })
        : null
    )
  }
})
</script>
