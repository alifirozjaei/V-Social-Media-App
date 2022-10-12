<template>
 <v-app>
  <admin-navigation-drawer
   :drawer="drawer"
   v-on:drawerEvent="drawer = !drawer"
  />
  <admin-navbar v-on:drawerEvent="drawer = true" :drawer="drawer" />

  <v-main>
   <router-view> </router-view>
  </v-main>
 </v-app>
</template>

<script>
import AdminNavbar from "../../components/AdminNavbar.vue";
import AdminNavigationDrawer from "../../components/AdminNavigationDrawer.vue";
export default {
 name: "AdminLayout",
 components: {
  AdminNavbar,
  AdminNavigationDrawer,
 },
 data: () => ({
  drawer: true,
 }),
};
</script>

<style></style>
