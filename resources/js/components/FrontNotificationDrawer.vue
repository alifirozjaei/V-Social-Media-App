<template>
 <v-navigation-drawer
  dark
  :value="drawer"
  @input="changeDrawer"
  :class="$vuetify.theme.dark ? '' : 'white'"
  app
  left
  temporary
 >
  <div class="text-center py-5">
   <h4><b>اعلان</b></h4>
  </div>
  <v-divider></v-divider>
  <v-list nav dense>
   <v-list-item v-for="(item, index) in items" :key="index">
    <v-alert
     dense
     text
     :type="item.read_at ? 'success' : 'info'"
     class="small-text text-justify w-100"
    >
     <span @click="readNotification(item)" style="cursor:pointer">
      {{ item.data.text }}
     </span>
    </v-alert>
   </v-list-item>
  </v-list>
 </v-navigation-drawer>
</template>

<script>
export default {
 name: "FrontNotificationDrawer",
 props: ["drawer"],
 data: () => ({
  draw: false,
  items: [],
 }), // data

 methods: {
  changeDrawer(event) {
   this.$emit("changeDrawer", event);
  },

  readNotification(item) {
   if (!item.read_at) {
    axios.patch(`/api/notifications/${item.id}`).then(() => {
     this.$router.push("/" + item.data.link);
     item.read_at = true;
    });
   } else {
    this.$router.push("/" + item.data.link);
   }
  },
 },

 created() {
  if (this.$store.state.user.user.isVerified == 2) {
   //   axios.get("/api/notifications").then(({ data }) => {
   //    this.items = data.data;
   //   });
   this.$store.dispatch("notification/getNotifications").then(() => {
    this.items = this.$store.state.notification.notifications;
   });
  }
 },
};
</script>

<style></style>
