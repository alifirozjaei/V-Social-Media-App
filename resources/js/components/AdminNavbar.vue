<template>
 <v-app-bar
  height="75"
  flat
  :color="$vuetify.theme.dark ? '' : 'grey lighten-4'"
  class="p-0"
  app
 >
  <v-container fluid class="p-0">
   <v-row>
    <v-container>
     <v-row class="py-md-3 py-0">
      <v-col cols="auto" class="d-flex">
       <v-app-bar-nav-icon
        @click="$emit('drawerEvent')"
        v-if="!drawer || $vuetify.breakpoint.mdAndDown"
       >
       </v-app-bar-nav-icon>
       <span class="d-none d-md-flex align-center ">
        <v-img src="/favicon2.ico"></v-img>
       </span>
      </v-col>
      <v-spacer></v-spacer>
      <v-col cols="auto d-flex align-center">
       <v-btn color="pink " dark @click="logout">
        خروج
       </v-btn>
       <v-btn class="mr-3" @click.prevent="nightMode">
        <v-icon>
         mdi-theme-light-dark
        </v-icon>
       </v-btn>
      </v-col>
     </v-row>
    </v-container>
   </v-row>
  </v-container>
 </v-app-bar>
</template>

<script>
export default {
 name: "FrontNavbar",
 props: ["drawer"],
 data: () => ({
  search: false,
  items: [
   { text: "کتاب", class: "indigo--text text--lighten-5" },
   { text: "روانشناسی", class: "indigo--text text--lighten-5" },
   { text: "استارتاپ", class: "indigo--text text--lighten-5" },
   { text: "پست های دوستان", class: "indigo--text text--lighten-5" },
   { text: "با من تقسیم کن", class: "indigo--text text--lighten-5" },
   { text: "دل نوشته", class: "indigo--text text--lighten-5" },
  ],
 }), // data

 methods: {
  logout() {
   axios.post("/logout");
  },

  nightMode() {
   this.$vuetify.theme.dark = !this.$vuetify.theme.dark;
   if (this.$vuetify.theme.dark) {
    localStorage.setItem("isDark", 1);
   } else {
    localStorage.removeItem("isDark");
   }
  }, // nightMode
 }, // methods

 computed: {
  isDark() {
   return this.$vuetify.theme.dark;
  },
 },
};
</script>

<style>
.v-menu__content {
 box-shadow: unset !important;
}
.v-menu__content,
.v-list {
 border-radius: 0;
}
</style>
