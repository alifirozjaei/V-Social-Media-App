<template>
 <v-main>
  <v-container
   :class="$vuetify.breakpoint.mdAndDown ? 'my-10 py-10' : 'mt-10 pt-10 pb-3'"
  >
   <v-row v-if="user">
    <v-col cols="12" sm="8" class="mx-auto mt-3">
     <div class="d-flex justify-center">
      <span>
       پست های ذخیره شده :
       <b>{{ user.bookmarks_count }}</b>
      </span>
     </div>
    </v-col>
   </v-row>

   <v-row v-if="posts">
    <v-col cols="12" md="6" v-for="(post, index) in posts.data" :key="index">
     <new-post style="height:100%" :data="post" :showuser="true"></new-post>
    </v-col>

    <v-col v-if="posts" cols="12" class="mx-auto d-flex my-2">
     <v-spacer></v-spacer>
     <v-btn
      @click="fetchPost"
      v-if="!!posts.next_page_url"
      color="info"
      class="px-6"
      rounded
     >
      بیشتر
      <v-icon>mdi-chevron-left</v-icon>
     </v-btn>
    </v-col>
   </v-row>
   <v-row v-if="user && user.bookmarks_count == 0">
    <v-col cols="12" md="6" class="mx-auto">
     <v-alert class="d-flex justify-center" elevation="0">
      شما پست ذخیره شده ندارید!!!
     </v-alert>
    </v-col>
   </v-row>
  </v-container>
 </v-main>
</template>

<script>
import { ref } from "@vue/composition-api";
import NewPost from "../../components/post/NewPost.vue";
export default {
 components: { NewPost },
 name: "UserBookmarkedPost",

 metaInfo() {
  return {
   title: "پست ذخیره شده",
  };
 },

 setup(props, context) {
  //  state
  const posts = ref({});
  const user = ref({});
  // created hook
  // get user bookmarked posts
  axios.get(`api/bookmarked-posts`).then(({ data }) => {
   posts.value = data.posts;
   user.value = data.user;
  });

  // methods
  // get new post from server - paginate
  const fetchPost = () => {
   axios.get(posts.value.next_page_url).then(({ data }) => {
    posts.value.data.push(...data.posts.data);
    posts.value.next_page_url = data.posts.next_page_url;
   });
  };

  return {
   posts,
   user,
   fetchPost,
  };
 },
};
</script>

<style></style>
