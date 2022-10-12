<template>
 <v-main :class="$vuetify.breakpoint.mdAndDown ? 'my-10 py-10' : 'pt-10 mt-10 pb-3'">
  <v-container>
   <v-row>
    <v-col>
     <v-form class="w-100">
      <v-row>
       <v-col cols="12" md="6" class="mx-auto">
        <v-text-field v-model="title" label="عنوان متن" @input="updatePost">
        </v-text-field>
       </v-col>
      </v-row>
     </v-form>
     <tip-tap-editor
      ref="tiptap"
      v-model="content"
      @input="updatePost"
     ></tip-tap-editor>
     <v-divider class="mt-2"></v-divider>
     <v-btn class="info mt-5" v-if="showSavingPost" @click.stop="savePost">
      ویرایش نوشته
     </v-btn>
    </v-col>
   </v-row>

   <!-- success save data snackbar  -->
   <v-snackbar v-model="snackbar.saved" :timeout="1000">
    <div class="green--text text-center">
     نوشته ذخیره شد
    </div>
   </v-snackbar>

   <!-- error snackbar -->
   <v-snackbar v-model="snackbar.error" :timeout="0">
    <div class="error--text d-flex align-center ">
     <span>پیش نویس ذخیره نشد</span>
     <v-spacer></v-spacer>
     <v-btn
      text
      color="error"
      @click.stop="snackbar.error = false"
      class="mr-auto"
     >
      X
     </v-btn>
    </div>
   </v-snackbar>
  </v-container>
 </v-main>
</template>

<script>
import TipTapEditor from "../../components/TipTapEditor.vue";
import { debounce } from "lodash";
import {
 ref,
 reactive,
 onUnmounted,
 onUpdated,
 computed,
} from "@vue/composition-api";
export default {
 components: { TipTapEditor },
 metaInfo: {
  title: "ویرایش پست",
 },

 name: "Edit",

 setup(props, context) {
  const content = ref("");
  const title = ref("");
  const snackbar = reactive({
   saved: false,
   error: false,
  });

  //   check route have link parameter and get data from server
  axios
   .get(`/api/posts/${context.root.$route.params.slug}/edit`)
   .then(({ data }) => {
    title.value = data.title;
    content.value = data.content;
    context.refs.tiptap.editor.commands.setContent(data.content);
   })
   .catch(({ response }) => {
    if (response.status === 404) {
     context.root.$router.push({ name: "not-found" });
    }
    if (response.status === 403) {
     context.root.$router.push({ name: "access-denied" });
    }
   });

  // create or update draft when change editor content
  const updatePost = debounce(function() {
   updatePostStore()
    .then(({ data }) => {
     snackbar.saved = true;
     snackbar.error = false;
    })
    .catch(() => {
     snackbar.error = true;
    });
  }, 2000);

  const savePost = () => {
   updatePost.cancel();
   updatePostStore().then(({ data }) => {
    context.root.$router.push({
     name: "update-post",
     params: { slug: data.slug },
    });
   });
  };

  const updatePostStore = () => {
   return context.root.$store.dispatch("post/updatePost", {
    title: title.value,
    content: content.value,
    slug: context.root.$route.params.slug,
   });
  };

  const showSavingPost = computed(() => {
   return title.value && content.value;
  });

  return {
   content,
   title,
   snackbar,
   updatePost,
   showSavingPost,
   savePost,
  };
 },
};
</script>

<style lang="scss"></style>
