<template>
 <!-- :app="$vuetify.breakpoint.smAndDown" -->
 <v-app-bar
  app
  height="auto"
  flat
  :color="$vuetify.theme.dark ? '' : 'grey lighten-3 '"
  class="p-0"
 >
  <v-container fluid class="p-0">
   <v-row>
    <v-container>
     <v-row class=" py-0">
      <!-- app icon and smNavigation toggle icon-->
      <v-col cols="auto" class="d-flex">
       <v-app-bar-nav-icon
        class="hidden-md-and-up"
        @click="$emit('drawerEvent')"
       >
       </v-app-bar-nav-icon>
       <router-link :to="{ name: 'home' }">
        <span class="d-none d-md-flex align-center ">
         <v-img src="/favicon2.ico"></v-img>
        </span>
       </router-link>
      </v-col>
      <v-spacer></v-spacer>

      <!-- show navbar item -->
      <v-col cols="auto d-flex align-center">
       <!-- show search icon and text-field  -->
       <v-menu
        min-width="100%"
        v-model="search"
        transition="slide-y-transition"
        absolute
        top
        :close-on-content-click="false"
        rounded="0"
       >
        <!-- search icon -->
        <template v-slot:activator="{}">
         <v-icon class="ml-2 " @click="search = true">
          mdi-magnify
         </v-icon>
        </template>

        <!-- search text-field -->
        <v-list :color="$vuetify.theme.dark ? '' : 'grey lighten-4 '">
         <v-list-item>
          <v-text-field
           label="دربین مقالات ، نویسندگان و ... جستجو کنید"
           v-model="form"
           @keyup.enter="pushToSearh"
          ></v-text-field>
          <v-btn class=" red--text mr-1" text @click="search = false">X</v-btn>
         </v-list-item>
        </v-list>
        <!-- search text-field -->
       </v-menu>

       <!-- navigation item show (home, liked, bookmarked, ...) -->
       <template v-if="$vuetify.breakpoint.mdAndUp">
        <template v-for="(item, index) in items">
         <v-btn
          text
          v-if="$store.state.user.isLogin || item.to.name == 'home'"
          :key="index"
          @click="$router.push(item.to)"
         >
          <v-icon>
           {{ item.icon }}
          </v-icon>
         </v-btn>
        </template>
       </template>

       <!-- darkmode toggle button -->
       <v-btn text @click.prevent="nightMode">
        <v-icon>
         mdi-theme-light-dark
        </v-icon>
       </v-btn>

       <!-- login and register link -->
       <template v-if="!auth">
        <v-btn
         text
         :to="{ name: 'login' }"
         class="font-weight-bold primary--text"
        >
         ورود
        </v-btn>
        <span class="px-1">/</span>
        <v-btn
         text
         :to="{ name: 'register' }"
         class="font-weight-bold primary--text"
        >
         ثبت نام
        </v-btn>
       </template>

       <!-- darkmod, notifications, user profile edit, logout buttons -->
       <template v-else>
        <!-- notifications button -->
        <v-btn text class="mx-1" @click="$emit('showNotification')">
         <v-icon>
          mdi-bell
         </v-icon>
        </v-btn>

        <!-- user profile and logput -->
        <v-menu rounded offset-y>
         <!-- open menu button -->
         <template v-slot:activator="{ on, attrs }">
          <!-- <v-btn color="indigo darken-1" dark v-bind="attrs" v-on="on">
           <v-icon>mdi-account</v-icon>
          </v-btn> -->
          <v-list-item>
           <v-list-item-avatar>
            <v-img
             style="cursor:pointer"
             v-bind="attrs"
             v-on="on"
             :src="user.profile_src"
            >
            </v-img>
           </v-list-item-avatar>
          </v-list-item>
         </template>

         <!-- menu items -->
         <v-list dark class="indigo darken-3 ">
          <!-- edit user profile button -->
          <v-list-item>
           <router-link :to="{ name: 'profile' }" class="white--text">
            <v-list-item-title two-line>
             <v-list-item-content>
              <v-list-item-title>
               {{ user.name }}
              </v-list-item-title>
              <v-list-item-subtitle>
               ویرایش پروفایل
              </v-list-item-subtitle>
             </v-list-item-content>
            </v-list-item-title>
           </router-link>
          </v-list-item>

          <!-- logout button -->
          <v-list-item>
           <v-btn @click.prevent="logout" color="error darken-1">
            خروج از حساب کاربری
           </v-btn>
          </v-list-item>
         </v-list>
        </v-menu>
       </template>
      </v-col>
     </v-row>
    </v-container>
   </v-row>

   <!-- mdAndUp navigation -->
   <!-- <v-row class="indigo darken-1 py-2" v-if="$vuetify.breakpoint.mdAndUp">
    <v-container class=" body-1">
     <v-row>
      <v-col cols="12">
       <v-hover
        v-for="item in items"
        :key="item.text"
        v-slot:default="{ hover }"
       >
        <span
         class="ml-3"
         :class="hover ? 'white--text' : 'indigo--text text--lighten-2'"
         style="cursor:pointer;"
        >
         <router-link :to="item.to" class="white--text">
          {{ item.text }}
         </router-link>
        </span>
       </v-hover>
      </v-col>
      <div></div>
     </v-row>
    </v-container>
   </v-row> -->
  </v-container>
 </v-app-bar>
</template>

<script>
import { mapActions, mapState } from "vuex";
export default {
 name: "FrontNavbar",
 props: ["items"],
 data: () => ({
  search: false,
  form: null,
 }), // data

 methods: {
  //   ...mapActions("user", ["logout"]),

  // logout
  logout() {
   this.$store.dispatch("user/logout").then(() => {
    this.$router.push({ name: "home" });
   });
  },

  // toggle nightMode
  nightMode() {
   this.$vuetify.theme.dark = !this.$vuetify.theme.dark;
   if (this.$vuetify.theme.dark) {
    localStorage.setItem("isDark", 1);
   } else {
    localStorage.removeItem("isDark");
   }
  },

  // go to search page
  pushToSearh() {
   this.$router.push({
    name: "search",
    params: {
     type: "posts",
    },
    query: {
     q: this.form,
    },
   });
  },
 }, // methods

 computed: {
  ...mapState({
   auth: (state) => state.user.isLogin,
   user: (state) => state.user.user,
  }),

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
