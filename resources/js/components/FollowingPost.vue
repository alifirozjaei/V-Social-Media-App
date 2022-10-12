<template>
 <div v-if="posts">
  <h4>پست های جدید دنبال شوندگان</h4>
  <v-list class="mt-2">
   <v-list-item-group>
    <v-list-item v-for="post in posts" :key="post.slug">
     <v-list-item-content>
      <div class="d-flex align-center">
       <v-list-item-avatar>
        <v-img max-height="131" :src="post.user.profile_src"></v-img>
       </v-list-item-avatar>
       <div>
        <h5 class="mb-2 d-inline-block text-truncate" style="max-width:240px">
         <router-link :to="{ name: 'post-show', params: { slug: post.slug } }">
          {{ post.title }}
         </router-link>
        </h5>
        <h6 class="grey--text over-line d-flex">
         <div>{{ post.user.name }}</div>

         <div>
          |
          {{ moment(post.created_at).fromNow() }}
         </div>
        </h6>
       </div>
      </div>
     </v-list-item-content>
    </v-list-item>
    <v-list-item v-if="messageShow" class="small-text">
     پستی برای نمایش وجود ندارد!!!
    </v-list-item>
   </v-list-item-group>
  </v-list>
 </div>
</template>

<script>
import { ref } from "@vue/composition-api";
import moment from "moment-jalaali";
moment.loadPersian({
 usePersianDigits: true,
});
export default {
 name: "FollowingPost",

 setup(props, context) {
  const posts = ref([]);
  const messageShow = ref(false);

  //   created hook
  if (context.root.$store.state.user.isLogin) {
   axios.get("/api/following-posts").then(({ data }) => {
    posts.value = data.posts;
    messageShow.value = data.posts.length ? false : true;
   });
  }

  return {
   posts,
   messageShow,
   moment,
  };
 },
};
</script>

<style></style>
