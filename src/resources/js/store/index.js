import { createStore } from "vuex"

const store = createStore({
  state() {
    return {
      isLoggedIn: false,
      isLineUser: false,
      isMenuOpen: false,
      showPopup: false,
      popupMessage: "",
      popupColor: "green",
      activeTab: "standings",
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
    setPopupMessage(state, {message, color}) {
      state.popupMessage = message;
      state.popupColor = color;
      state.showPopup = true;
    },
    setActiveTab(state, tabName) {
      state.activeTab = tabName;
    },
    hidePopup(state) {
      state.showPopup = false;
    }
  },

  actions: {
    triggerPopup({ commit }, { message, color }) {
      commit('setPopupMessage', { message, color });
      setTimeout(() => {
        commit('hidePopup');
      }, 3000);
    },
    logout({ commit }) {
      commit('setLoggedIn', false);
      commit('setLineUser', false);
    },
    changeActiveTab({ commit }, tabName) {
      commit('setActiveTab', tabName);
    }
  },

});

export default store
