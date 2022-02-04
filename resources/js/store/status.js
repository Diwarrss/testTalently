export default {
  namespaced: true,
  state: {
    statuses: [],
  },
  getters: {
    statuses(state) {
      return state.statuses;
    },
  },
  mutations: {
    SET_STATUSES(state, value) {
      state.statuses = value;
    },
  },
  actions: {},
};
