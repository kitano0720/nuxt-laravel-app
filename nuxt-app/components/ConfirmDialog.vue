<template>
  <div>
    <v-dialog :value="dialog" width="400" @click:outside="closeDialog">
      <v-card>
        <div align="center">
          <v-icon large color="blue darken-2" class="pa-5"> mdi-help-circle </v-icon>
        </div>
        <div align="center" class="mb-3">{{ message }}</div>
        <v-card-actions>
          <v-spacer />
          <v-btn color="blue darken-1" text @click="clickCancel"> キャンセル </v-btn>
          <v-btn color="blue darken-1" text @click="clickOk"> OK </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </div>
</template>

<script>
import { defineComponent } from '@nuxtjs/composition-api'

export default defineComponent({
  name: 'ConfirmDialog',
  model: {
    prop: 'dialog',
    event: 'toggleDialog',
  },
  props: {
    dialog: {
      type: Boolean,
      default: false,
    },
    message: {
      type: String,
      default: '',
    },
  },
  setup(props, context) {
    // ダイアログを開く
    const closeDialog = () => {
      context.emit('toggleDialog', false)
    }

    const clickCancel = () => {
      context.emit('clickCancel')
    }

    const clickOk = () => {
      context.emit('clickOk')
    }

    return {
      closeDialog,
      clickCancel,
      clickOk,
    }
  },
})
</script>
