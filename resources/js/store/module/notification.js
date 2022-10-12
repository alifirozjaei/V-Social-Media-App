export const namespaced = true;

export const state = {
 notifications: [],
};

export const mutations = {
 SET_NOTIFICATIONS(state, data) {
  state.notifications = data;
 },
};

export const actions = {
 async getNotifications({ commit, state }) {
  if (!state.notifications.length) {
   let { data } = await axios.get("/api/notifications");
   commit("SET_NOTIFICATIONS", data.data);
  }
 },
};
