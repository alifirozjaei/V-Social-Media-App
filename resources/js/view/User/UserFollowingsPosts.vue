<template>
 <v-main>
  <v-container
   :class="$vuetify.breakpoint.mdAndDown ? 'my-10 py-10' : 'mt-10 pt-10 pb-3'"
  >
   <v-row>
    <v-col cols="12" sm="8" class="mx-auto mt-5">
     <div class="d-flex justify-center">
      <span>
       جدید ترین پست های کاربرانی که دنبال میکنید
      </span>
     </div>
    </v-col>
   </v-row>

   <v-row v-if="posts">
    <v-col cols="12" md="8" class="mx-auto">
     <div v-for="(post, index) in posts.data" :key="index" class="my-5 py-5">
      <show-post-component :data="post"></show-post-component>
      <br />
      <v-divider></v-divider>
     </div>
    </v-col>
   </v-row>

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
    </v-col>
   </v-row>
  </v-container>
 </v-main>
</template>

<script>
import { ref, watch } from "@vue/composition-api";
import moment from "moment-jalaali";
import ShowPostComponent from "../../components/post/ShowPostComponent.vue";
moment.loadPersian({
 usePersianDigits: true,
});
export default {
 components: { ShowPostComponent },
 name: "UserFollowinPosts",

 metaInfo() {
  return {
   title: "جدید ترین پست ها",
  };
 },

 setup(props, context) {
  //  state
  const posts = ref({});
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

  // created hook
  // get user bookmarked posts
  axios.get("/api/following-posts-all").then(({ data }) => {
   posts.value = data.posts;
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
   posts,
   fetchPost,
   loading,
   moment,
  };
 },
};
</script>

<style></style>
