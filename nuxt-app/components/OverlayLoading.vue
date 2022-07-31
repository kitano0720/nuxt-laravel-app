<template>
  <v-overlay :z-index="999" :value="overlay">
    <v-row justify="center">
      <v-progress-circular indeterminate size="64" />
    </v-row>
    <v-row class="mt-10"> しばらくお待ちください... </v-row>
  </v-overlay>
</template>

<script>
import { defineComponent, onMounted, computed, useStore } from '@nuxtjs/composition-api'

export default defineComponent({
  name: 'OverlayLoading',
  setup() {
    const store = useStore()

    onMounted(() => {
      store.dispatch('common/stopOverlayLoading')
    })

    const overlay = computed(() => {
      return store.getters['common/getState']('overlayLoading')
    })

    return { overlay }
  },
})
</script>
