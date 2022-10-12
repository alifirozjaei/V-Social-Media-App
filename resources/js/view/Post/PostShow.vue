<template>
 <v-main>
  <v-container
   :class="$vuetify.breakpoint.mdAndDown ? 'my-10 py-10' : 'pt-10 mt-10 pb-3'"
   v-if="post.user"
  >
   <v-row>
    <v-col cols="12" md="11" class="mx-auto">
     <!-- writer info -->
     <v-list-item>
      <div>
       <v-row class="my-2 align-center">
        <v-avatar>
         <img :src="post.user.profile_src" />
        </v-avatar>
        <div class="d-flex flex-column pa-2">
         <p class="mb-2">
          <router-link
           :to="{
            name: 'user-posts',
            params: { username: post.user.username },
           }"
          >
           {{ post.user.name }}
          </router-link>
          <v-btn
           v-if="
            $store.state.user.isLogin &&
             $store.state.user.user.id != post.user.id
           "
           small
           :color="post.user.is_follow ? 'blue darken-2' : 'grey darken-2'"
           rounded
           dark
           @click="followUser"
          >
           {{ post.user.is_follow ? "دنبال میکنید" : "دنبال کنید" }}
          </v-btn>
         </p>
         <p class="grey--text small-text text--darken-2 ma-0">
          {{ post.user.bio }}
         </p>
         <p class="grey--text small-text text--darken-2 ma-1">
          {{ moment(post.created_at).fromNow() }}
          | خواندن {{ post.min_read }}
          دقیقه
         </p>
        </div>
       </v-row>
      </div>
     </v-list-item>

     <!-- <div class="d-flex justify-center">
      <v-img :src="post.image" style="max-width:50%"> </v-img>
     </div> -->
     <div class="mt-3">
      <!-- Post title -->
      <h2>
       {{ post.title }}
      </h2>
      <!-- POST CONTENT -->
      <div class="mt-6" v-html="post.content"></div>

      <!-- Post Category -->
      <div class="my-3">
       <v-btn
        class="ml-1"
        depressed
        v-for="(category, index) in post.categories"
        @click="
         $router.push({
          name: 'post-category',
          params: { slug: category.slug },
         })
        "
        :key="index"
       >
        {{ category.title }}
       </v-btn>
      </div>

      <!-- Post Save & Like -->
      <v-row class="my-8 ">
       <v-col cols="12" md="4">
        <span class="ml-5">
         <v-icon @click="bookmarkPost(post)" v-if="$store.state.user.isLogin">
          {{ post.is_bookmarked ? "mdi-bookmark" : "mdi-bookmark-outline" }}
         </v-icon>
        </span>
        <span class="ml-5">
         <v-icon
          @click="likePost(post)"
          :class="post.is_liked ? 'error--text' : ''"
          v-if="$store.state.user.isLogin"
         >
          {{ post.is_liked ? "mdi-heart" : "mdi-heart-outline" }}
         </v-icon>
         <v-icon v-else>
          mdi-heart-outline
         </v-icon>
         {{ post.likes_count }}
        </span>
        <span class="ml-5">
         <v-icon>
          mdi-comment-outline
         </v-icon>
         {{ post.comments_count }}
        </span>
       </v-col>
       <v-col cols="12" md="8" class="d-flex">
        <v-spacer></v-spacer>
        <v-icon>
         mdi-send-circle
        </v-icon>
        <v-icon>
         mdi-twitter
        </v-icon>
        <v-btn
         outlined
         rounded
         color="grey"
         class="mr-2 text-small"
         v-clipboard:copy="short_link"
         v-clipboard:success="onCopyShortLink"
         :disabled="short_link == 'کپی شد!!!'"
        >
         {{ short_link }}
         <v-icon>
          mdi-content-copy
         </v-icon>
        </v-btn>
       </v-col>
      </v-row>

      <v-divider class="mb-5"></v-divider>

      <!-- related Post -->
      <div class="my-10" v-if="related_post">
       <p class="font-weight-bold h-5">
        شاید از این نوشته ها خوشتان بیاید
        <span v-if="!related_post.length">
         : پستی مرتبط وجود ندارد !!!
        </span>
       </p>
       <v-row v-if="related_post">
        <!-- post -->
        <v-col
         cols="12"
         sm="6"
         md="4"
         class="mx-auto"
         v-for="(rel, index) in related_post"
         :key="index"
        >
         <v-card :elevation="0">
          <router-link :to="{ name: 'post-show', params: { slug: rel.slug } }">
           <v-img :src="rel.image" height="150px"></v-img>
          </router-link>
          <v-card-title class="subtitle-1 d-inline-block text-truncate" style="max-width:100%">
           <router-link :to="{ name: 'post-show', params: { slug: rel.slug } }">
            {{ rel.title }}
           </router-link>
          </v-card-title>
          <v-card-actions class="d-flex">
           <v-row class="ma-1 align-center">
            <v-avatar>
             <img :src="rel.user.profile_src" />
            </v-avatar>
            <div class="d-flex flex-column pa-2">
             <router-link
              :to="{
               name: 'user-posts',
               params: { username: rel.user.username },
              }"
             >
              <b
               style="max-width:150px"
               class="mb-0 d-inline-block text-truncate"
              >
               {{ rel.user.name }}
              </b>
             </router-link>
             <p class="grey--text small-text text--darken-2 ma-1">
              {{ moment(rel.created_at).fromNow() }}
              |
              {{ rel.min_read }}
              دقیقه
             </p>
            </div>
           </v-row>
           <v-spacer></v-spacer>
           <v-icon @click="bookmarkPost(rel)" v-if="$store.state.user.isLogin">
            {{ rel.is_bookmarked ? "mdi-bookmark" : "mdi-bookmark-outline" }}
           </v-icon>
          </v-card-actions>
         </v-card>
        </v-col>
       </v-row>
      </div>

      <!-- Add Comment -->
      <div class="my-10">
       <template v-if="$store.state.user.isLogin">
        <h4 class="my-8">
         دیدگاه ها
        </h4>
        <v-textarea
         label="نظر خود را بنویسد..."
         filled
         v-model="comment.content"
        ></v-textarea>
        <div class="d-flex">
         <v-spacer></v-spacer>
         <v-btn color="success" @click="saveComment">
          ارسال دیدگاه
         </v-btn>
        </div>
       </template>
       <template v-else>
        <span class="font-weight-bold">
         برای ثبت دیدگاه باید وارد سایت شوید!
        </span>
       </template>
      </div>

      <!-- show comments -->
      <post-comment
       v-for="commentItem in post.parent_comments"
       :key="commentItem.id"
       :data="commentItem"
      ></post-comment>
      <!-- end show comments -->
     </div>
    </v-col>
   </v-row>

   <!-- show error box -->
   <v-snackbar v-model="commentErrors.show" color="error" outlined>
    {{ commentErrors.message }}
    <template v-slot:action="{ attrs }">
     <v-btn
      color="error"
      text
      v-bind="attrs"
      @click="commentErrors.show = false"
     >
      X
     </v-btn>
    </template>
   </v-snackbar>
   <!-- end show error -->
  </v-container>
 </v-main>
</template>

<script>
import { reactive, ref } from "@vue/composition-api";
import moment from "moment-jalaali";
import PostComment from "./PostComment.vue";
import EventBus from "../../Service/EventBus.js";
import _ from "lodash";
moment.loadPersian({
 usePersianDigits: true,
});

export default {
 name: "PostShow",

 components: { PostComment },

 metaInfo() {
  return {
   title: this.post.title,
   meta: [{ name: "description", content: this.post.description }],
  };
 },

 setup(props, context) {
  const post = ref({});
  const related_post = ref({});
  const short_link = ref("http://myblog.test/link/short-link");
  const comment = ref({
   content: "",
   post_id: null,
  });
  const commentErrors = ref({
   show: false,
   message: null,
  });

  // created hook
  axios
   .get(`/api/posts/${context.root.$route.params.slug}`)
   .then(({ data }) => {
    post.value = data.post;
    related_post.value = data.related_post;
    short_link.value = `http://myblog.test/link/${data.post.short_link}`;
    comment.value.post_id = data.post.id;

    Echo.channel(`v_comment_${post.value.id}`).listen(
     ".comment.created",
     (e) => {
      post.value.parent_comments.push(e.comment);
      EventBus.$emit("comment_created");
     }
    );

    Echo.channel(`v_comment_deleted_${post.value.id}`).listen(
     ".comment.deleted",
     (e) => {
      post.value.parent_comments = post.value.parent_comments.filter(
       (c) => c.id !== e.comment.id
      );
      EventBus.$emit("comment_deleted", e.comment.replies.length);
      //   let myComments = post.value.parent_comments.filter(
      //    (c) => c.id !== e.comment.id
      //   );
      //   post.value.parent_comments = {};
      //   setTimeout(() => {
      //    post.value.parent_comments = myComments;
      //    EventBus.$emit("comment_deleted", e.comment.replies.length);
      //   }, 1);
     }
    );
   });

  // EventBus
  EventBus.$on("error", (message) => {
   showErrorSnakebar(message);
  });
  EventBus.$on("comment_created", () => {
   post.value.comments_count++;
  });

  EventBus.$on("comment_deleted", (length) => {
   post.value.comments_count -= length + 1;
  });

  // methods
  const onCopyShortLink = () => {
   const link = short_link.value;
   short_link.value = "کپی شد!!!";
   setTimeout(() => {
    short_link.value = link;
   }, 2000);
  };

  const saveComment = () => {
   axios
    .post(`/api/comments/${post.value.slug}`, comment.value)
    .then(({ data }) => {
     comment.value.content = null;
    })
    .catch((error) => {
     showErrorSnakebar(error.response.data.errors.content[0]);
    });
  };

  const showErrorSnakebar = (message) => {
   commentErrors.value.message = message;
   commentErrors.value.show = true;
  };

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

  const followUser = () => {
   axios.post(`/api/follows/${post.value.user.username}`).then(() => {
    post.value.user.is_follow = !post.value.user.is_follow;
   });
  };

  return {
   post,
   related_post,
   moment,
   short_link,
   onCopyShortLink,
   comment,
   saveComment,
   commentErrors,
   showErrorSnakebar,
   bookmarkPost,
   likePost,
   followUser,
  };
 },
};
</script>

<style>
.body-text {
 line-height: 3rem;
}

img {
 max-width: 100%;
}
</style>
