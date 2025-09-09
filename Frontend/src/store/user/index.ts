import { User } from '@/types/models/user';
import { UserState } from './index.d';

export default {
  namespaced: true,
  state: (): UserState => ({
    profile: null,
  }),
  mutations: {
    setProfile(state: UserState, profile: User) {
      state.profile = profile;
    },
  },
  actions: {
    fetchProfile({ commit }: any) {
      // Simulate API call
      const profile = { name: 'John Doe', email: 'john@example.com' };
      commit('setProfile', profile);
    },
  },
  getters: {
    userName: (state: UserState) => state.profile?.name || '',
  },
};
