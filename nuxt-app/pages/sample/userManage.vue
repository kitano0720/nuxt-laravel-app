<template>
  <div>
    <!-- ユーザー一覧 -->
    <v-row class="mt-2 mb-1">
      <div class="table-title">ユーザーリスト</div>
      <v-spacer />
      <v-text-field
        v-model="state.search"
        append-icon="mdi-magnify"
        :label="COMMON_TEXT.searchHint"
        single-line
        hide-details
        class="pr-4"
      ></v-text-field>
    </v-row>
    <!-- テーブル -->
    <v-data-table
      :headers="headers"
      :items="state.userList"
      item-key="id"
      height="380"
      :search="state.search"
      :loading="state.loading"
      :loading-text="COMMON_TEXT.loadingItem"
      :no-data-text="COMMON_TEXT.noDataText"
      :no-results-text="COMMON_TEXT.noResultText"
      :page="state.pagination.page"
      hide-default-footer
      dense
      @pagination="
        (pagination) => {
          state.pagination = pagination
        }
      "
    >
      <template #item="{ item }">
        <tr>
          <td class="text-center">{{ item.id }}</td>
          <td class="text-left">{{ item.name }}</td>
          <td class="text-left">{{ item.email }}</td>
          <td class="text-center">{{ item.age }}</td>
          <td class="text-center">{{ item.gender }}</td>
          <td class="text-center">
            <v-icon @click="openDialog('edit', item)"> mdi-pencil </v-icon>
          </td>
          <td class="text-center">
            <v-icon @click="openConfirm(item)"> mdi-delete </v-icon>
          </td>
        </tr>
      </template>
    </v-data-table>
    <!-- ページネーション -->
    <v-pagination v-model="state.pagination.page" :length="state.pagination.pageCount" />

    <v-row>
      <v-spacer />
      <v-btn color="primary" dark class="mt-2 mb-2 mr-4" @click="openDialog('create')">
        ユーザーを追加
      </v-btn>
    </v-row>

    <!-- ダイアログ -->
    <v-form ref="form" v-model="state.formValid">
      <v-dialog v-model="state.dialog" max-width="500px">
        <v-card>
          <v-card-title> ユーザー編集 </v-card-title>
          <v-card-text>
            <v-text-field v-model="state.user.name" label="名前" :rules="rules.name" />
            <v-text-field
              v-model="state.user.email"
              type="email"
              label="メールアドレス"
              :rules="rules.email"
            />
            <v-text-field
              v-if="state.mode === 'create'"
              v-model="state.user.password"
              :type="state.showPassword ? 'text' : 'password'"
              label="パスワード"
              :append-icon="state.showPassword ? 'mdi-eye' : 'mdi-eye-off'"
              :rules="rules.password"
              @click:append="state.showPassword = !state.showPassword"
            />
            <v-text-field
              v-if="state.mode === 'create'"
              v-model="state.user.passwordConfirm"
              :type="state.showPasswordConfirm ? 'text' : 'password'"
              label="パスワード（確認）"
              :append-icon="state.showPasswordConfirm ? 'mdi-eye' : 'mdi-eye-off'"
              :rules="rules.passwordConfirm"
              @click:append="state.showPasswordConfirm = !state.showPasswordConfirm"
            />
            <v-text-field
              v-model="state.user.age"
              label="年齢"
              type="number"
              max="100"
              min="0"
              :rules="rules.age"
            />
            <v-radio-group v-model="state.user.gender" mandatory>
              <v-radio label="男" value="1" />
              <v-radio label="女" value="0" />
            </v-radio-group>
          </v-card-text>
          <v-card-actions>
            <v-spacer />
            <v-btn color="blue darken-1" text @click="closeDialog"> キャンセル </v-btn>
            <v-btn v-if="state.mode === 'create'" color="blue darken-1" text @click="createUser()">
              登録
            </v-btn>
            <v-btn v-if="state.mode === 'edit'" color="blue darken-1" text @click="updateUser()">
              更新
            </v-btn>
          </v-card-actions>
        </v-card>
      </v-dialog>
    </v-form>

    <!-- 確認ダイアログ -->
    <ConfirmDialog
      v-model="state.confirm"
      message="ユーザーを削除しますか？"
      @clickCancel="closeConfirm"
      @clickOk="deleteUser"
    />

    <!-- オーバーレイローディング -->
    <OverlayLoading />
  </div>
</template>

<script>
import { defineComponent, onMounted, reactive, useStore, ref } from '@nuxtjs/composition-api'
import axios from 'axios'
import { COMMON_TEXT } from '@/const'

export default defineComponent({
  name: 'UserManagePage',
  setup(props, context) {
    // ストア
    const store = useStore()

    // バックエンドURL
    const backendURL = 'http://localhost:8000/'

    // トースト
    const toast = context.root.$root.$toast

    // 初期処理
    onMounted(() => {
      // ユーザーリストを取得
      getUserList()
    })

    // リアクティブステート
    const state = reactive({
      userList: [],
      user: {},
      loading: false,
      search: '',
      pagination: {},
      dialog: false,
      mode: '',
      formValid: false,
      confirm: false,
      showPassword: false,
      showPasswordConfirm: false,
    })

    // テーブルヘッダー
    const headers = [
      { text: 'ID', value: 'id', align: 'center' },
      { text: '名前', value: 'name', align: 'center' },
      { text: 'メールアドレス', value: 'email', align: 'center' },
      { text: '年齢', value: 'age', align: 'center' },
      { text: '性別', value: 'gender', align: 'center' },
      { text: '編集', value: 'edit', align: 'center', sortable: false },
      { text: '削除', value: 'delete', align: 'center', sortable: false },
    ]

    // ユーザーリストを取得
    const getUserList = async () => {
      state.loading = true

      await axios
        .get(backendURL + 'api/getUserList')
        .then((response) => {
          state.userList = response.data.userList
        })
        .catch((e) => {
          toast.error('データの取得に失敗しました')
          state.userList = []
        })

      state.loading = false
    }

    // フォームDOM
    const form = ref(null)

    // ダイアログを開く
    const openDialog = (mode, user = {}) => {
      state.mode = mode

      if (mode === 'create') {
        state.user = user
      } else if (mode === 'edit') {
        state.user = { ...user }
      }

      form.value.reset()

      state.dialog = true
    }

    // ダイアログを閉じる
    const closeDialog = () => {
      state.dialog = false
    }

    // 入力ルール
    const rules = {
      name: [(val) => !!val || '名前を入力してください'],
      email: [(val) => !!val || 'メールアドレスを入力してください'],
      password: [(val) => !!val || 'パスワードを入力してください'],
      passwordConfirm: [
        (val) => !!val || 'パスワード（確認）を入力してください',
        (val) => val === state.user.password || 'パスワードと一致しません',
      ],
      age: [(val) => !!val || '年齢を入力してください'],
    }

    // ユーザー作成
    const createUser = async () => {
      // バリデーションチェック
      form.value.validate()

      if (!state.formValid) {
        toast.error('入力項目に不備があります')
        return
      }

      closeDialog()

      // オーバーレイローディング開始
      store.dispatch('common/startOverlayLoading')

      await axios
        .post(backendURL + 'api/createUser', {
          user: state.user,
        })
        .then((response) => {
          toast.success('登録が完了しました')
          getUserList()
        })
        .catch((e) => {
          toast.error('登録に失敗しました')
        })

      // オーバーレイローディング終了
      store.dispatch('common/stopOverlayLoading')
    }

    // ユーザー編集
    const updateUser = async () => {
      // バリデーションチェック
      if (!state.formValid) {
        toast.error('入力項目に不備があります')
        return
      }

      closeDialog()

      // オーバーレイローディング開始
      store.dispatch('common/startOverlayLoading')

      await axios
        .post(backendURL + 'api/updateUser', {
          user: state.user,
        })
        .then((response) => {
          toast.success('更新が完了しました')
          getUserList()
        })
        .catch((e) => {
          toast.error('更新に失敗しました')
        })

      // オーバーレイローディング終了
      store.dispatch('common/stopOverlayLoading')
    }

    // ユーザー削除
    const deleteUser = async () => {
      closeConfirm()

      // オーバーレイローディング開始
      store.dispatch('common/startOverlayLoading')

      await axios
        .post(backendURL + 'api/deleteUser', {
          id: state.user.id,
        })
        .then((response) => {
          toast.success('削除が完了しました')
          getUserList()
        })
        .catch((e) => {
          toast.error('削除に失敗しました')
        })

      // オーバーレイローディング終了
      store.dispatch('common/stopOverlayLoading')
    }

    // 確認ダイアログを開く
    const openConfirm = (user) => {
      state.user = { ...user }
      state.confirm = true
    }

    // 確認ダイアログを閉じる
    const closeConfirm = () => {
      state.confirm = false
    }

    return {
      state,
      headers,
      form,
      rules,
      openDialog,
      closeDialog,
      openConfirm,
      closeConfirm,
      createUser,
      updateUser,
      deleteUser,
      COMMON_TEXT,
    }
  },
})
</script>

<style scoped>
.table-title {
  display: flex;
  flex-wrap: wrap;
  font-size: 1.25rem;
  font-weight: 500;
  letter-spacing: 0.0125em;
  line-height: 2rem;
  word-break: break-all;
  padding: 16px;
}
</style>
