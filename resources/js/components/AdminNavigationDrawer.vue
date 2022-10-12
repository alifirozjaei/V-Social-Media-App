<template>
 <v-navigation-drawer dark v-model="drawer" app right class="indigo darken-1">
  <v-list nav dense>
   <!-- User Detail -->
   <v-list-item class="d-flex align-center"
    ><v-list-item-avatar>
     <v-img src="/images/avatar1.jpg"></v-img>
    </v-list-item-avatar>
    <v-list-item-content>
     <v-list-item-title>نیما احمدی</v-list-item-title>
     <v-list-item-subtitle>ادمین</v-list-item-subtitle>
    </v-list-item-content>
    <v-spacer></v-spacer>
    <v-app-bar-nav-icon @click="$emit('drawerEvent')"></v-app-bar-nav-icon>
   </v-list-item>

   <v-divider></v-divider>

   <v-list-item-group
    v-model="group"
    active-class="deep-purple--text text--accent-4"
   >
    <v-list-item v-for="item in items" :key="item.text">
     <v-list-item-title @click="$router.push({ name: item.href })">
      {{ item.text }}
     </v-list-item-title>
    </v-list-item>
   </v-list-item-group>
  </v-list>
 </v-navigation-drawer>
</template>

<script>
export default {
 name: "FrontNavigationDrawer",
 props: ["drawer"],
 data: () => ({
  group: null,
  draw: false,
  items: [{ text: "داشبورد", href: "dashboard" }],
 }), // data
};
</script>

<style></style>
