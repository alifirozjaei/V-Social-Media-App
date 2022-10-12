import Vue from "vue";
import VueRouter from "vue-router";
import store from "../store";
import routes from "./routes";
Vue.use(VueRouter);

const router = new VueRouter({
 mode: "history",
 routes: routes,
});

router.beforeEach((routeTo, routeFrom, next) => {
 if (routeTo.meta.guest && store.state.user.isLogin) {
  return next("/");
 }

 if (routeTo.meta.auth && store.state.user.isLogin == false) {
  return next({ name: "login" });
 }

 if (routeTo.meta.verified && store.state.user.user.isVerified != 2) {
  return next({ name: "home" });
 }

 return next();
});

export default router;
