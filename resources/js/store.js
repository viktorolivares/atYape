import { createStore } from "vuex";
import axios from 'axios';

const store = createStore({
    state: {
        isAuthenticated: false,
        user: null,
    },
    mutations: {
        setAuth(state, user) {
            state.isAuthenticated = true;
            state.user = user;
        },
        clearAuth(state) {
            state.isAuthenticated = false;
            state.user = null;
        },
    },
    actions: {
        login({ commit }, credentials) {
            return new Promise((resolve, reject) => {
                axios
                    .post("/api/login", credentials)
                    .then((response) => {
                        const authUser = response.data.authUser;
                        commit("setAuth", authUser);
                        resolve(authUser);
                    })
                    .catch((error) => {
                        reject(error);
                    });
            });
        },
        logout({ commit }) {
            return new Promise((resolve, reject) => {
                axios
                    .post("/api/logout")
                    .then(() => {
                        commit("clearAuth");
                        resolve();
                    })
                    .catch((error) => {
                        reject(error);
                    });
            });
        },
    },
});

export default store;
