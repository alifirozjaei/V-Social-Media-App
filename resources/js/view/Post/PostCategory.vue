<template>
 <v-main>
  <v-container
   :class="$vuetify.breakpoint.mdAndDown ? 'my-10 py-10' : 'pt-10 mt-10 pb-3'"
  >
   <!-- show category detail -->
   <v-row v-if="category">
    <v-col cols="12" md="8" class="mx-auto mt-5 py-5">
     <div class="d-flex ">
      <span>
       دسته :
       <b> {{ category.title }}</b>
      </span>
      <v-spacer></v-spacer>
      <span
       >تعداد پست ها :
       <b> {{ category.posts_count }}</b>
      </span>
     </div>
    </v-col>
   </v-row>

   <v-divider></v-divider>

   <!-- show posts -->
   <v-row v-if="posts">
    <v-col cols="12" md="6" v-for="(post, index) in posts.data" :key="index">
     <new-post style="height:100%" :data="post" :showuser="true"></new-post>
    </v-col>
    <v-col cols="12" class="text-center mt-6" v-if="!posts.to">
     <v-alert class="d-flex justify-center" elevation="0">
      پستی برای نمایش وجود ندارد !!!
     </v-alert>
    </v-col>
    <v-col v-if="posts" cols="12" class="mx-auto d-flex my-6">
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
   <template v-else>
    در حال بارگیری اطلاعات ...
   </template>
  </v-container>
 </v-main>
</template>

<script>
import { ref } from "@vue/composition-api";
import NewPost from "../../components/post/NewPost.vue";
export default {
 components: {
  NewPost,
 },

 name: "PostCategory",

 metaInfo() {
  return {
   title: this.category.title,
  };
 },

 setup(props, context) {
  //  state
  const posts = ref(null);
  const category = ref({
   title: "",
  });

  // created hook
  // get category and posts from server
  axios
   .get(`/api/posts/category/${context.root.$route.params.slug}`)
   .then(({ data }) => {
    posts.value = data.posts;
    category.value = data.category;
   });

  // methods

  // load paginate post
  const fetchPost = () => {
   axios.get(posts.value.next_page_url).then(({ data }) => {
    posts.value.data.push(...data.posts.data);
    posts.value.next_page_url = data.posts.next_page_url;
   });
  };

  return {
   posts,
   category,
   fetchPost,
  };
 },
};
</script>

<style></style>
