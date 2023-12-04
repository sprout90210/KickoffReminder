import { createStore } from "vuex"

const store = createStore({
  state() {
    return {
      isLoggedIn: false,
      isLineUser: false,
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
    setLineUser(state, status) {
      state.isLineUser = status;
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
    triggerPopup({ commit }, { message }) {
      commit('setPopupMessage', message);
      setTimeout(() => {
        commit('hidePopup');
      }, 3000);
    },

    logout({ commit }) {
      commit('setLoggedIn', false);
      commit('setLineUser', false);
    },

  },

});

export default store
