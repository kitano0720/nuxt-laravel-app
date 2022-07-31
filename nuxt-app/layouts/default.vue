<template>
  <v-app>
    <!-- ヘッダー -->
    <v-app-bar clipped-left fixed app>
      <v-app-bar-nav-icon @click.stop="state.miniVariant = !state.miniVariant" />
      <v-toolbar-title v-text="title" />
      <v-spacer />
      <v-btn icon @click.stop="state.rightDrawer = !state.rightDrawer">
        <v-icon>mdi-menu</v-icon>
      </v-btn>
    </v-app-bar>

    <!-- 左サイドバー -->
    <v-navigation-drawer :mini-variant="state.miniVariant" clipped fixed app>
      <v-list>
        <v-list-item v-for="(item, i) in leftDrawerItems" :key="i" :to="item.to" router exact>
          <v-list-item-action>
            <v-icon>{{ item.icon }}</v-icon>
          </v-list-item-action>
          <v-list-item-content>
            <v-list-item-title v-text="item.title" />
          </v-list-item-content>
        </v-list-item>
      </v-list>
    </v-navigation-drawer>

    <!-- 右サイドバー -->
    <v-navigation-drawer v-model="state.rightDrawer" right temporary fixed>
      <v-list>
        <v-list-item v-for="(item, i) in rightDrawerItems" :key="i">
          <v-list-item-action>
            <v-icon light> mdi-repeat {{ item.icon }}</v-icon>
          </v-list-item-action>
          <v-list-item-content>
            <v-list-item-title v-text="item.title" />
          </v-list-item-content>
        </v-list-item>
      </v-list>
    </v-navigation-drawer>

    <!-- メインコンテンツ -->
    <v-main>
      <v-container>
        <Nuxt />
      </v-container>
    </v-main>
  </v-app>
</template>

<script>
import { defineComponent, reactive } from '@nuxtjs/composition-api'

export default defineComponent({
  name: 'DefaultPage',
  setup() {
    const title = 'Vuetify.js'

    // 左サイドバーアイテム
    const leftDrawerItems = [
      {
        icon: 'mdi-apps',
        title: 'Welcome',
        to: '/',
      },
      {
        icon: 'mdi-chart-bubble',
        title: 'Inspire',
        to: '/inspire',
      },
      {
        icon: 'mdi-account-edit',
        title: 'Sample',
        to: '/sample',
      },
    ]

    // 右サイドバーアイテム
    const rightDrawerItems = [
      {
        icon: 'mdi-repeat',
        title: 'Dummy',
        to: '/',
      },
    ]

    // リアクティブステート
    const state = reactive({
      miniVariant: false,
      rightDrawer: false,
    })

    return {
      title,
      leftDrawerItems,
      rightDrawerItems,
      state,
    }
  },
})
</script>
