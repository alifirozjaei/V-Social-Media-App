<template>
 <v-card elevation="1" class="my-4 " style="position:relative">
  <v-list-item>
   <v-list-item-content>
    <div class="d-flex align-center">
     <!-- avatar -->
     <v-list-item-avatar v-if="showuser">
      <v-img max-height="131" :src="data.user.profile_src"></v-img>
     </v-list-item-avatar>
     <!-- user -->
     <div class="d-flex flex-column " v-if="showuser">
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
     <!-- category -->
     <div class="mr-auto align-self-start ">
      <v-btn
       v-for="(category, index) in data.categories"
       :key="index"
       @click="
        $router.push({
         name: 'post-category',
         params: { slug: category.slug },
        })
       "
       small
       text
      >
       {{ category.title }}
      </v-btn>
     </div>
    </div>
   </v-list-item-content>
  </v-list-item>

  <v-list-item>
   <v-list-item-title>
    <router-link :to="{ name: 'post-show', params: { slug: data.slug } }">
     <h3>
      {{ data.title }}
     </h3>
    </router-link>
   </v-list-item-title>
  </v-list-item>

  <v-list-item>
   <v-img
    height="200px"
    :src="data.image"
    @click="$router.push({ name: 'post-show', params: { slug: data.slug } })"
    style="cursor:pointer"
   ></v-img>
  </v-list-item>
  <v-card-text>
   {{ data.description }}
  </v-card-text>
  <br />
  <v-card-actions style="position:absolute; bottom:0; left:0; width:100%">
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
   <span>{{ data.likes_count }}</span>
   <v-spacer></v-spacer>
   <v-btn icon @click="bookmarkPost(data)" v-if="$store.state.user.isLogin">
    <v-icon>
     {{ data.is_bookmarked ? "mdi-bookmark" : "mdi-bookmark-outline" }}
    </v-icon>
   </v-btn>
  </v-card-actions>
 </v-card>
</template>

<script>
import moment from "moment-jalaali";
moment.loadPersian({
 usePersianDigits: true,
});
export default {
 name: "NewPost",

 props: ["data", "showuser"],

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
   postData.is_liked ? postData.likes_count++ : postData.likes_count--;
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
