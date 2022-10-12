export const namespaced = true;

export const state = {
 user: window.user,
 isLogin: !!window.user,
};
// state

// getters

export const mutations = {
 LOG_OUT(state) {
  state.isLogin = false;
  state.user = null;
 },
 // LOG_OUT

 LOGIN(state, paylod) {
  state.isLogin = true;
  state.user = {
   name: paylod.name,
   isLogin: true,
   isVerified: paylod.email_verified_at ? 2 : 1,
   username: paylod.username,
   profile_src: paylod.profile_src,
   id: paylod.id,
  };
 },
 // LOGIN

 REGISTER(state, paylod) {
  state.isLogin = true;
  state.user = {
   name: paylod.name,
   isLogin: true,
   isVerified: paylod.email_verified_at ? 2 : 1,
   username: paylod.username,
   profile_src: paylod.profile_src,
   id: paylod.id,
  };
 },
 // REGISTER

 RESET_PASSWORD(state, paylod) {
  state.isLogin = true;
  state.user = {
   name: paylod.name,
   isLogin: true,
   isVerified: paylod.email_verified_at ? 2 : 1,
   username: paylod.username,
   profile_src: paylod.profile_src,
   id: paylod.id,
  };
 },
 // RESET

 SET_NAME(state, payload) {
  state.user.name = payload;
 },
};
// mutation

export const actions = {
 logout({ commit }) {
  return axios.post("/logout").then(() => {
   commit("LOG_OUT");
  });
 },
 // logout

 login({ commit }, form) {
  return axios.post("/login", form.value).then(({ data }) => {
   commit("LOGIN", data.data);
  });
 },
 // login

 register({ commit }, form) {
  return axios.post("/register", form.value).then(({ data }) => {
   commit("REGISTER", data.data);
  });
 },
 // register

 resetPassword({ commit }, form) {
  return axios.post("/api/password/reset", form.value).then(async () => {
   let res = await axios.get("/api/me");
   commit("RESET_PASSWORD", res.data);
  });
 },
 // resetPassword

 sendResetPasswordEmail({ commit }, form) {
  return axios.post("/api/password/email", form.value);
 },
 // sendResetPasswordEmail

 changeName({ commit }, name) {
  commit("SET_NAME", name);
 },
 // change user new name after update profile
};
// action
