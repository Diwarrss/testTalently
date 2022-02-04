import Vue from "vue";
import Vuex from "vuex";
import createPersistedState from "vuex-persistedstate";
import auth from "./auth";
import task from "./task";
import status from "./status";

Vue.use(Vuex);

export default new Vuex.Store({
  plugins: [createPersistedState()],
  modules: {
    auth,
    task,
    status,
  },
});
