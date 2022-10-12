<template>
 <div>
  <v-list-item>
   <v-list-item-avatar
    style="cursor:pointer"
    @click="
     $router.push({
      name: 'user-posts',
      params: { username: user.username },
     })
    "
   >
    <v-img :src="user.profile_src"></v-img>
   </v-list-item-avatar>
   <v-list-item-content class="d-flex flex-column align-start">
    <div>
     <router-link
      style="cursor:pointer"
      :to="{
       name: 'user-posts',
       params: { username: user.username },
      }"
     >
      {{ user.name }}
     </router-link>
    </div>
    <div class="small-text">
     {{ user.username }}
    </div>
   </v-list-item-content>
   <v-list-item-action v-if="$store.state.user.isLogin">
    <template v-if="$store.state.user.user.id != user.id">
     <v-btn
      small
      :color="user.is_follow ? 'blue darken-2' : 'grey darken-2'"
      rounded
      dark
      @click="followUser"
     >
      {{ user.is_follow ? "دنبال میکنید" : "دنبال کنید" }}
     </v-btn>
    </template>
   </v-list-item-action>
  </v-list-item>
 </div>
</template>

<script>
import { ref } from '@vue/composition-api';
export default {
 name: "UserShow",
 props: ["data"],
 setup(props, context) {
  const user = ref(props.data);
  // follow user
  const followUser = () => {
   axios.post(`/api/follows/${user.value.username}`).then(() => {
    user.value.is_follow = !user.value.is_follow;
   });
  };
  return {
   user,
   followUser,
  };
 },
};
</script>

<style></style>
