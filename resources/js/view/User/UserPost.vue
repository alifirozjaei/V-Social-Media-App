<template>
 <v-main>
  <v-container
   :class="$vuetify.breakpoint.mdAndDown ? 'my-10 py-10' : 'mt-10 pt-10 pb-3'"
  >
   <v-row>
    <v-col cols="12" md="10" class="mx-auto">
     <v-list-item>
      <div>
       <v-row class="my-2 align-center">
        <v-avatar>
         <img :src="user.profile_src" />
        </v-avatar>
        <div class="d-flex flex-column pa-2">
         <p class="mb-2">
          {{ user.name }}
          <v-btn
           v-if="
            $store.state.user.isLogin && $store.state.user.user.id != user.id
           "
           @click="followUser"
           small
           :color="user.is_follow ? 'blue darken-2' : 'grey darken-2'"
           rounded
           dark
          >
           {{ user.is_follow ? "دنبال میکنید" : "دنبال کنید" }}
          </v-btn>
         </p>
         <p class=" small-text  ma-0">
          {{ user.bio }}
         </p>
        </div>
       </v-row>
      </div>
     </v-list-item>
    </v-col>
   </v-row>

   <v-row v-if="user">
    <v-col cols="12" sm="8" class="mx-auto">
     <div class="d-flex text-center">
      <span style="cursor:pointer;" @click="followerDialog = true"
       >دنبال کنندگان :
       <b> {{ user.followers_count }}</b>
      </span>
      <v-spacer></v-spacer>
      <span style="cursor:pointer;" @click="followingDialog = true"
       >دنبال شوندگان :
       <b> {{ user.follows_count }}</b>
      </span>
      <v-spacer></v-spacer>
      <span
       >پست ها :
       <b> {{ user.posts_count }}</b>
      </span>
     </div>
    </v-col>
   </v-row>
   <br />
   <v-divider></v-divider>

   <v-row v-if="posts">
    <v-col cols="12" md="6" v-for="(post, index) in posts.data" :key="index">
     <new-post style="height:100%" :data="post" :showuser="false"></new-post>
    </v-col>
    <v-col cols="12" class="text-center mt-6" v-if="!posts.to">
     <v-alert class="d-flex justify-center" elevation="0">
      این کاربر پستی منتشر نکرده است !!!
     </v-alert>
    </v-col>
    <v-col v-if="posts" cols="12" class="mx-auto d-flex my-6">
     <v-spacer></v-spacer>
     <v-btn
      color="info"
      class="px-6"
      rounded
      @click="fetchPost"
      v-if="!!posts.next_page_url"
     >
      بیشتر
      <v-icon>mdi-chevron-left</v-icon>
     </v-btn>
    </v-col>
   </v-row>
   <template v-else>
    در حال بارگیری اطلاعات ...
   </template>

   <!-- following users -->
   <v-dialog scrollable max-width="500px" v-if="user" v-model="followingDialog">
    <v-card>
     <v-card-title class="d-felx">
      <span class="mx-auto">
       دنبال شوندگان
      </span>
     </v-card-title>
     <v-divider></v-divider>
     <v-card-text style="height: 400px;" v-if="followings">
      <user-show
       v-for="followingUser in followings.data"
       :key="followingUser.username"
       :data="followingUser"
      ></user-show>
      <div class="d-flex">
       <v-btn
        class="mx-auto mt-3"
        @click="fetchFollowing"
        v-if="!!followings.next_page_url"
        fab
        color="info"
       >
        +
       </v-btn>
      </div>
     </v-card-text>
    </v-card>
   </v-dialog>

   <!-- followers users -->
   <v-dialog scrollable max-width="500px" v-if="user" v-model="followerDialog">
    <v-card>
     <v-card-title class="d-felx">
      <span class="mx-auto">
       دنبال کنندگان
      </span>
     </v-card-title>
     <v-divider></v-divider>
     <v-card-text style="height: 400px;" v-if="followers">
      <user-show
       v-for="followerUser in followers.data"
       :key="followerUser.username"
       :data="followerUser"
      ></user-show>
      <div class="d-flex">
       <v-btn
        class="mx-auto mt-3"
        @click="fetchFollowers"
        v-if="!!followers.next_page_url"
        fab
        color="info"
       >
        +
       </v-btn>
      </div>
     </v-card-text>
    </v-card>
   </v-dialog>
  </v-container>
 </v-main>
</template>

<script>
import { ref } from "@vue/composition-api";
import NewPost from "../../components/post/NewPost.vue";
import UserShow from "../../components/User/UserShow.vue";
export default {
 components: { NewPost, UserShow },
 name: "UserPost",

 metaInfo() {
  return {
   title: this.user.name,
  };
 },

 setup(props, context) {
  //  state
  const posts = ref({});
  const user = ref({});
  const followingDialog = ref(false);
  const followerDialog = ref(false);
  const followings = ref(null);
  const followers = ref(null);

  // created hook
  // get user posts
  axios
   .get(`api/user-posts/${context.root.$route.params.username}`)
   .then(({ data }) => {
    posts.value = data.posts;
    user.value = data.user;
   });

  // get user followings
  axios
   .get(`api/user/${context.root.$route.params.username}/following`)
   .then(({ data }) => {
    followings.value = data.followings;
   });

  // get user followers
  axios
   .get(`api/user/${context.root.$route.params.username}/follower`)
   .then(({ data }) => {
    followers.value = data.followers;
   });

  // methods
  // get new post from server - paginate
  const fetchPost = () => {
   axios.get(posts.value.next_page_url).then(({ data }) => {
    posts.value.data.push(...data.posts.data);
    posts.value.next_page_url = data.posts.next_page_url;
   });
  };

  const fetchFollowing = () => {
   axios.get(followings.value.next_page_url).then(({ data }) => {
    followings.value.data.push(...data.followings.data);
    followings.value.next_page_url = data.followings.next_page_url;
   });
  };

  const fetchFollowers = () => {
   axios.get(followers.value.next_page_url).then(({ data }) => {
    followers.value.data.push(...data.followers.data);
    followers.value.next_page_url = data.followers.next_page_url;
   });
  };

  // follow user
  const followUser = () => {
   axios.post(`/api/follows/${user.value.username}`).then(() => {
    user.value.is_follow = !user.value.is_follow;
    user.value.is_follow
     ? user.value.followers_count++
     : user.value.followers_count--;
   });
  };

  return {
   posts,
   user,
   fetchPost,
   followUser,
   followingDialog,
   followerDialog,
   followings,
   fetchFollowing,
   followers,
   fetchFollowers,
  };
 },

 methods: {},
};
</script>

<style></style>
