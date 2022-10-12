import Vue from "vue";
import Vuex from "vuex";
import * as user from "./module/user";
import * as draft from "./module/draft";
import * as post from "./module/post";
import * as category from "./module/category";
import * as notification from "./module/notification";
Vue.use(Vuex);

export default new Vuex.Store({
 modules: {
  user,
  draft,
  post,
  category,
  notification,
 },
});
