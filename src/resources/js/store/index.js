import { createStore } from "vuex"

const store = createStore({
  state() {
    return {
      isLoggedIn: false,
      isMenuOpen: false,
      showPopup: false,
      popupMessage: "",
    }
  },

  mutations: {
    toggleMenu(state) {
      state.isMenuOpen = !state.isMenuOpen;
    },
    setLoggedIn(state, status) {
      state.isLoggedIn = status;
    },
    setPopupMessage(state, message) {
      state.popupMessage = message;
      state.showPopup = true;
    },
    hidePopup(state) {
      state.showPopup = false;
    }
  },

  actions: {
    checkLoginStatus({ commit }) {
      axios.get("/api/check")
        .then(response => {
          commit("setLoggedIn", response.data.isLoggedIn);
        })
        .catch(() => {
          commit("setLoggedIn", false);
        });
    },
    triggerPopup({ commit }, { message }) {
      commit('setPopupMessage', message);
      setTimeout(() => {
        commit('hidePopup');
      }, 3000);
    }
  },

});

export default store
