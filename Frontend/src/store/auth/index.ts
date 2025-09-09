import { AuthState } from './index.d';
export default {
  namespaced: true,
  state: (): AuthState => ({
    isLoggedIn: false,
    token: null,
  }),
  mutations: {
    login(state: AuthState, token: string) {
      state.isLoggedIn = true;
      state.token = token;
    },
    logout(state: AuthState) {
      state.isLoggedIn = false;
      state.token = null;
    },
  },
  actions: {
    login({ commit }: any, token: string) {
      commit('login', token);
    },
    logout({ commit }: any) {
      commit('logout');
    },
  },
  getters: {
    isAuthenticated: (state: AuthState) => state.isLoggedIn,
  },
};
