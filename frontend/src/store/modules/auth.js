import api from '@/api';

const state = {
    user: null,
    token: localStorage.getItem('token') || '',
};

const getters = {
    isAuthenticated: state => !!state.token,
    user: state => state.user,
};

const actions = {
    async register({ commit }, userData) {
        const response = await api.post('/register', userData);
        commit('setUser', response.data.user);
        commit('setToken', response.data.token);
    },
    async login({ commit }, userData) {
        const response = await api.post('/login', userData);
        commit('setUser', response.data.user);
        commit('setToken', response.data.token);
    },
    logout({ commit }) {
        commit('logout');
    },
};

const mutations = {
    setUser(state, user) {
        state.user = user;
    },
    setToken(state, token) {
        state.token = token;
        localStorage.setItem('token', token);
    },
    logout(state) {
        state.user = null;
        state.token = '';
        localStorage.removeItem('token');
    },
};

export default {
    state,
    getters,
    actions,
    mutations,
};
