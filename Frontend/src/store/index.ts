import { createStore } from 'vuex';
import auth from './auth';
import user from './user';

const store = createStore({
  modules: {
    auth,
    user,
  },
});

export default store;
