<template>
 <v-navigation-drawer
  dark
  :value="drawer"
  @input="changeDrawer"
  app
  right
  class="indigo darken-1"
  temporary
 >
  <v-list nav dense>
   <v-list-item-group
    v-model="group"
    active-class="deep-purple--text text--accent-4"
   >
    <template v-for="item in items">
     <v-list-item
      :key="item.text"
      v-if="$store.state.user.isLogin || item.to.name == 'home'"
     >
      <v-list-item-title>
       <router-link :to="item.to" class="white--text">
        <v-icon v-if="!!item.icon"> {{ item.icon }} </v-icon>
        {{ item.text }}
       </router-link>
      </v-list-item-title>
     </v-list-item>
    </template>
   </v-list-item-group>
  </v-list>
 </v-navigation-drawer>
</template>

<script>
export default {
 name: "FrontNavigationDrawer",
 props: ["drawer", "items"],
 data: () => ({
  group: null,
  draw: false,
 }), // data

 methods: {
  changeDrawer(event) {
   this.$emit("changeDrawer", event);
  },
 },
};
</script>

<style></style>
