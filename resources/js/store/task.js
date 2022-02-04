export default {
  namespaced: true,
  state: {
    tasks: [],
    task: null,
  },
  getters: {
    tasks(state) {
      return state.tasks;
    },
    task(state) {
      return state.task;
    },
  },
  mutations: {
    SET_TASKS(state, value) {
      state.tasks = value;
    },
    SET_TASK(state, value) {
      state.task = value;
    },
  },
  actions: {},
};
