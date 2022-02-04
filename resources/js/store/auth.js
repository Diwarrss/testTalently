import axios from "axios";
import router from "../router";

export default {
  namespaced: true,
  state: {
    authenticated: false,
    user: {},
    token: null,
  },
  getters: {
    authenticated(state) {
      return state.authenticated;
    },
    user(state) {
      return state.user;
    },
    token(state) {
      return state.token;
    },
  },
  mutations: {
    SET_AUTHENTICATED(state, value) {
      state.authenticated = value;
    },
    SET_USER(state, value) {
      state.user = value;
    },
    SET_TOKEN(state, value) {
      state.token = value;
    },
  },
  actions: {
    login({ commit, state }) {
      axios.defaults.headers.common["Authorization"] = `Bearer ${state.token}`;
      return axios
        .post("/api/v1/me")
        .then(({ data }) => {
          commit("SET_USER", data);
          commit("SET_AUTHENTICATED", true);
          router.push({ name: "kanbanboard" });
        })
        .catch(({ response: { data } }) => {
          commit("SET_USER", {});
          commit("SET_AUTHENTICATED", false);
        });
    },
    logout({ commit }) {
      commit("SET_USER", {});
      commit("SET_AUTHENTICATED", false);
      commit("SET_TOKEN", null);
    },
  },
};
