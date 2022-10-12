<template>
 <v-row>
  <v-col cols="12" class="hidden-md-and-up ">
   <v-img :src="data.image"></v-img>
  </v-col>
  <v-col cols="12" sm="8">
   <router-link :to="{ name: 'post-show', params: { slug: data.slug } }">
    <h4>
     <b>{{ data.title }}</b>
    </h4>
   </router-link>
   <p class="small-text">
    {{ data.description }}
   </p>
   <v-list-item>
    <v-list-item-content>
     <div class="d-flex align-center">
      <!-- avatar -->
      <v-list-item-avatar>
       <v-img max-height="131" :src="data.user.profile_src"></v-img>
      </v-list-item-avatar>
      <!-- user -->
      <div class="d-flex flex-column ">
       <h4 class="mb-2">
        <router-link
         :to="{
          name: 'user-posts',
          params: { username: data.user.username },
         }"
        >
         {{ data.user.name }}
        </router-link>
       </h4>
       <h6>
        {{ moment(data.created_at).fromNow() }}
        | خواندن {{ data.min_read }}
        دقیقه
       </h6>
      </div>

      <div class="mr-auto align-self-start mt-auto">
       <template>
        <v-btn icon v-if="$store.state.user.isLogin" @click="likePost(data)">
         <v-icon :class="data.is_liked ? 'error--text' : ''">
          {{ data.is_liked ? "mdi-heart" : "mdi-heart-outline" }}
         </v-icon>
        </v-btn>
        <v-btn icon v-else>
         <v-icon>
          mdi-heart-outline
         </v-icon>
        </v-btn>
       </template>
       <v-btn icon @click="bookmarkPost(data)" v-if="$store.state.user.isLogin">
        <v-icon>
         {{ data.is_bookmarked ? "mdi-bookmark" : "mdi-bookmark-outline" }}
        </v-icon>
       </v-btn>
      </div>
     </div>
    </v-list-item-content>
   </v-list-item>
  </v-col>
  <v-col cols="4" class="hidden-sm-and-down ">
   <v-img :src="data.image"></v-img>
  </v-col>
 </v-row>
</template>

<script>
import moment from "moment-jalaali";
moment.loadPersian({
 usePersianDigits: true,
});
export default {
 name: "ShowPostComponent",

 props: ["data"],

 setup(props, context) {
  const bookmarkPost = (postData) => {
   postData.is_bookmarked = !postData.is_bookmarked;
   let reqType = postData.is_bookmarked ? "post" : "delete";
   axios[reqType](`/api/bookmarks/${postData.slug}`);
  };

  const likePost = (postData) => {
   postData.is_liked = !postData.is_liked;
   let reqType = postData.is_liked ? "post" : "delete";
   axios[reqType](`/api/likes/${postData.slug}`);
  };
  return {
   moment,
   likePost,
   bookmarkPost,
  };
 },

 methods: {},
};
</script>

<style></style>
