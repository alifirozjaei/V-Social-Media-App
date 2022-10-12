require("./bootstrap");

window.Vue = require("vue");

import Vue from "vue";
// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

import vuetify from "./plugins/vuetify";
import VueMeta from "vue-meta";
import router from "./router/router";
import VueCompositionAPI from "@vue/composition-api";
import store from "./store/index";
import VueClipboard from "vue-clipboard2"


Vue.use(VueCompositionAPI);
Vue.use(VueMeta);
Vue.use(VueClipboard);

const app = new Vue({
 el: "#app",
 vuetify: vuetify,
 router,
 store,
});
