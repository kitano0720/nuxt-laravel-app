<template>
  <v-container>
    <div class="title">サンプル一覧</div>
    <v-row>
      <v-col v-for="(item, i) in menu" :key="i" :to="item.to" cols="3" router exact>
        <v-btn rounded x-large outlined color="indigo" block :to="item.to">
          <v-icon left> {{ item.icon }} </v-icon> {{ item.title }}
        </v-btn>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
import { defineComponent } from '@vue/composition-api'

export default defineComponent({
  name: 'SamplePage',
  setup() {
    const menu = [
      {
        icon: 'mdi-account-edit',
        title: 'CRUDサンプル',
        to: '/sample/userManage',
      },
    ]
    return { menu }
  },
})
</script>

<style scoped>
.title {
  font-size: 1.25rem;
  font-weight: 500;
  margin-bottom: 20px;
}
</style>
