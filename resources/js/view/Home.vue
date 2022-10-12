<template>
 <div class="mt-10 pt-10 pb-3">
  <v-main>
   <!-- recomended post -->
   <v-container class="mb-2">
    <div>
     <h5 class="my-3">
      مطالب انتخابی برای شما
     </h5>
     <v-row v-if="recomendedPosts">
      <v-col
       cols="12"
       :md="index % 2 == 0 ? (index == 0 ? 8 : 4) : index == 3 ? 8 : 4"
       v-for="(post, index) in recomendedPosts"
       :key="post.slug"
      >
       <related-post :data="post" />
      </v-col>
     </v-row>
    </div>
   </v-container>
   <!-- recomended post -->

   <!-- new post & sidebar -->
   <v-container class="my-3">
    <v-row>
     <!-- new post -->
     <v-col cols="12" md="8">
      <div v-if="posts">
       <h4 class="my-3 indigo--text text--darken-1">
        جدید ترین پست ها
       </h4>

       <new-post
        v-for="(post, index) in posts.data"
        :key="index"
        :data="post"
        :showuser="true"
       ></new-post>

       <v-row>
        <v-col v-if="posts" cols="12" class="mx-auto d-flex my-2">
         <div class="mx-auto d-flex justify-center">
          <v-progress-circular
           v-show="loading"
           :size="40"
           color="primary"
           indeterminate
          ></v-progress-circular>
         </div>
         <!-- <v-spacer></v-spacer>
         <v-btn @click="fetchPost" v-if="!!posts.next_page_url">
          پست بیشتر
         </v-btn> -->
        </v-col>
       </v-row>
      </div>
     </v-col>
     <!-- new post -->
     <v-col cols="4" class="hidden-sm-and-down ">
      <v-banner sticky class="pt-10 mt-10">
       <template v-if="$store.state.user">
        <following-post
         class="mt-10"
         v-if="
          $store.state.user &&
           $store.state.user.isLogin &&
           $store.state.user.user.isVerified == 2
         "
        ></following-post>
       </template>
       <popular-post class="mt-5" />
      </v-banner>
     </v-col>
    </v-row>
   </v-container>
   <!-- new post & sidebar -->
  </v-main>
 </div>
</template>

<script>
import NewPost from "../components/post/NewPost.vue";
import RelatedPost from "../components/post/RelatedPost.vue";
import PopularPost from "../components/PopularPost.vue";
import { ref, watch } from "@vue/composition-api";
import FollowingPost from "../components/FollowingPost.vue";
export default {
 metaInfo: {
  title: "صفحه اصلی",
 },
 components: {
  RelatedPost,
  NewPost,
  PopularPost,
  FollowingPost,
 }, // components

 setup(props, context) {
  const recomendedPosts = ref(null);
  const posts = ref(null);
  const loading = ref(false);

  // start of infinite scroll fetch data
  const bottom = ref(false);
  const bottomVisible = () => {
   const scrollY = window.scrollY;
   const visible = document.documentElement.clientHeight;
   const pageHeight = document.documentElement.scrollHeight;
   const bottomOfPage = visible + scrollY >= pageHeight;
   return bottomOfPage || pageHeight < visible;
  };

  // add event listener for scroll
  window.addEventListener("scroll", () => {
   bottom.value = bottomVisible();
  });

  // set watcher for bottom
  watch(bottom, (bottom) => {
   if (bottom && posts.value && !loading.value) {
    if (!!posts.value.next_page_url) {
    //  console.log("Fetch New Data");
     loading.value = true;
    //  setTimeout(fetchPost, 1000);
      fetchPost();
    }
   }
  });
  // end of infinite scroll fetch new post from server

  // created hook
  axios.get(`api/home-posts`).then(({ data }) => {
   posts.value = data.posts;
  });

  axios.get(`api/random-posts`).then(({ data }) => {
   recomendedPosts.value = data.posts;
  });

  // methods
  // get new post from server - paginate
  const fetchPost = () => {
   axios
    .get(posts.value.next_page_url)
    .then(({ data }) => {
     posts.value.data.push(...data.posts.data);
     posts.value.next_page_url = data.posts.next_page_url;
    })
    .finally(() => {
     loading.value = false;
    });
  };

  return {
   recomendedPosts,
   posts,
   fetchPost,
   loading,
  };
 },
};
</script>

<style>
a {
 text-decoration: none;
}
.v-toolbar__content {
 padding: 0;
}
</style>
