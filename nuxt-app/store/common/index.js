export const state = () => ({
  overlayLoading: false,
})

export const mutations = {
  setState: (state, { key, value }) => {
    state[key] = value
  },
}

export const actions = {
  // オーバーレイローディング開始
  startOverlayLoading: ({ commit }) => {
    commit('setState', { key: 'overlayLoading', value: true })
  },

  // オーバーレイローディング終了
  stopOverlayLoading: ({ commit }) => {
    commit('setState', { key: 'overlayLoading', value: false })
  },
}

export const getters = {
  getState: (state) => (key) => {
    return state[key]
  },
}
