<template>
 <v-main
  :class="$vuetify.breakpoint.mdAndDown ? 'my-10 py-10' : 'pt-10 mt-10 pb-3'"
 >
  <v-container>
   <v-row>
    <v-col cols="12">
     <!-- Page title -->
     <div class="my-5 d-flex">
      <span class="headline font-weight-bold">
       نوشته های شما
      </span>
      <v-spacer></v-spacer>
      <v-btn color="info" outlined :to="{ name: 'create-post' }">
       نوشتن پست جدید
      </v-btn>
     </div>

     <!-- Tab Menu -->
     <v-tabs class="mt-2" v-model="menu" grow>
      <v-tab href="#drafts" @click="fetchAllDrafts">
       پیش نویس ها
       <template v-if="drafts_count">({{ drafts_count }})</template>
      </v-tab>
      <v-tab href="#posts" @click="fetchAllPosts">
       مطالب منتشر شده
       <template v-if="posts_count">({{ posts_count }})</template>
      </v-tab>
     </v-tabs>

     <!-- Tab content -->
     <v-tabs-items v-model="menu">
      <!-- Drafts -->
      <v-tab-item
       value="drafts"
       :class="$vuetify.theme.dark ? 'custom-dark' : 'grey lighten-4'"
      >
       <!-- Drafts Item -->
       <div class="my-5 pa-5" v-for="(draft, index) in drafts" :key="index">
        <router-link
         :to="{ name: 'update-draft', params: { link: draft.link } }"
        >
         {{ draft.title || "بدون عنوان" }}
        </router-link>
        <div class="d-flex">
         <span class="body-2 grey--text">
          {{ draft.updated_at }}
         </span>
         <v-spacer></v-spacer>
         <router-link
          :to="{ name: 'update-draft', params: { link: draft.link } }"
         >
          <v-icon class="info--text text--darken-2 ml-2">
           mdi-file-document-edit
          </v-icon>
         </router-link>
         <v-icon
          @click="openDeleteDialogDraft(index, draft.link)"
          class="red--text text--darken-2"
         >
          mdi-delete
         </v-icon>
        </div>
        <v-divider class="my-3"></v-divider>
       </div>
      </v-tab-item>
      <!-- Posts -->
      <v-tab-item
       value="posts"
       :class="$vuetify.theme.dark ? 'custom-dark' : 'grey lighten-4'"
      >
       <!-- Drafts Item -->
       <div class="my-5 pa-5" v-for="(post, index) in posts" :key="index">
        <router-link :to="{ name: 'post-show', params: { slug: post.slug } }">
         {{ post.title }}
        </router-link>
        <div class="d-flex">
         <span class="body-2 grey--text">
          {{ post.updated_at }}
         </span>
         <v-spacer></v-spacer>
         <router-link :to="{ name: 'edit-post', params: { slug: post.slug } }">
          <v-icon class="info--text text--darken-2 ml-2">
           mdi-file-document-edit
          </v-icon>
         </router-link>
         <v-icon
          @click="openDeleteDialogPost(index, post.slug)"
          class="red--text text--darken-2"
         >
          mdi-delete
         </v-icon>
        </div>
        <v-divider class="my-3"></v-divider>
       </div>
      </v-tab-item>
     </v-tabs-items>
    </v-col>
   </v-row>

   <v-dialog max-width="500" v-model="deleteDialogDraft">
    <v-card>
     <v-card-title>
      آیا از حذف این پیش نویسّ مطمئن هستید؟
     </v-card-title>

     <v-card-actions class="d-flex">
      <v-spacer></v-spacer>

      <v-btn @click="closeDeleteDialogDraft">
       بستن
      </v-btn>

      <v-btn color="error darken-5" @click="deleteDraft">
       تایید
      </v-btn>
     </v-card-actions>
    </v-card>
   </v-dialog>

   <v-dialog max-width="500" v-model="deleteDialogPost">
    <v-card>
     <v-card-title>
      آیا از حذف این پست مطمئن هستید؟
     </v-card-title>

     <v-card-actions class="d-flex">
      <v-spacer></v-spacer>

      <v-btn @click="closeDeleteDialogPost">
       بستن
      </v-btn>

      <v-btn color="error darken-5" @click="deletePost">
       تایید
      </v-btn>
     </v-card-actions>
    </v-card>
   </v-dialog>
  </v-container>
 </v-main>
</template>

<script>
import { computed, reactive, toRefs } from "@vue/composition-api";
import postModule from "../../module/post/postModule";
import draftModule from "../../module/post/drafModule";
export default {
 name: "MyPosts",
 metaInfo: {
  title: "پست های من",
 },

 setup(props, context) {
  const data = reactive({
   menu: null,
  });

  const { fetchAllDrafts } = draftModule();
  // created hook
  fetchAllDrafts();

  return {
   ...toRefs(data),
   ...draftModule(),
   ...postModule(),
  };
 },
};
</script>

<style></style>
