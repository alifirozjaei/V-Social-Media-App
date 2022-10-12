<template>
 <div
  :class="$vuetify.theme.dark ? '' : 'grey lighten-4'"
  style="min-height:100vh"
 >
  <verify-email v-if="user && user.isVerified == 1"></verify-email>
  <front-navbar
   @showNotification="showNotification = true"
   v-on:drawerEvent="drawer = true"
   :items="items"
  />
  <front-notification-drawer
   v-if="user"
   :drawer="showNotification"
   v-on:changeDrawer="changeNotification"
  />
  <front-navigation-drawer
   :items="items"
   :drawer="drawer"
   v-on:changeDrawer="changeDrawer"
  />
  <template v-if="user && user.isVerified == 1">
   <br />
   <br />
   <br />
  </template>
  <router-view> </router-view>
 </div>
</template>

<script>
import { mapState } from "vuex";
import FrontNavbar from "../../components/FrontNavbar.vue";
import FrontNavigationDrawer from "../../components/FrontNavigationDrawer.vue";
import FrontNotificationDrawer from "../../components/FrontNotificationDrawer.vue";
import VerifyEmail from "../../components/VerifyEmail.vue";
export default {
 name: "FrontLayout",
 //  metaInfo: {
 //   titleTemplate: "%s - ",
 //  },
 components: {
  FrontNavbar,
  FrontNavigationDrawer,
  FrontNotificationDrawer,
  VerifyEmail,
 },

 data: () => ({
  drawer: false,
  showNotification: false,
  items: [
   {
    text: "صفحه اصلی",
    class: "indigo--text text--lighten-5",
    icon: "mdi-home",
    to: { name: "home" },
   },
   {
    text: "پروفایل من",
    class: "indigo--text text--lighten-5",
    icon: "mdi-view-dashboard",
    to: {
     name: "user-posts",
     params: { username: "" },
    },
   },
   {
    text: "نوشته های من",
    class: "indigo--text text--lighten-5",
    icon: "mdi-note-text",
    to: { name: "my-posts" },
   },
   {
    text: "ساخت پست جدید",
    class: "indigo--text text--lighten-5",
    icon: "mdi-plus-box-multiple-outline",
    to: { name: "create-post" },
   },
   {
    text: "پست های ذخیره شده",
    class: "indigo--text text--lighten-5",
    icon: "mdi-bookmark",
    to: { name: "bookmarked-post" },
   },
   {
    text: "پست های لایک شده",
    class: "indigo--text text--lighten-5",
    icon: "mdi-heart",
    to: { name: "liked-post" },
   },

   {
    text: "جدید ترین پست ها",
    class: "indigo--text text--lighten-5",
    icon: "mdi-group",
    to: { name: "user-following-posts" },
   },
  ],
 }),

 created() {
  //   this.$store.dispatch("category/getNavbarCategories").then(() => {
  //    this.items.push(...this.$store.state.category.categories);
  //   });
  if (this.$store.state.user.isLogin) {
   this.items[1].to.params.username = this.$store.state.user.user.username;
  }
 },

 methods: {
  changeDrawer(drawer) {
   this.drawer = drawer;
  },

  changeNotification(value) {
   this.showNotification = value;
  },
 },

 computed: {
  ...mapState({
   user: (state) => state.user.user,
  }),
 },
};
</script>

<style></style>
