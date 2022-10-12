import { computed, reactive, toRefs } from "@vue/composition-api";
import store from "../../store/index";
export default function postModule() {
 const data = reactive({
  deleteDialogPost: false,

  deleteAblePost: { index: null, slug: null },

  posts_count: computed(() => store.state.post.posts_count),

  posts: computed(() => store.state.post.posts),
 });

 const openDeleteDialogPost = (index, slug) => {
  data.deleteDialogPost = true;
  data.deleteAblePost = {
   index,
   slug,
  };
 };

 const closeDeleteDialogPost = () => {
  data.deleteDialogPost = false;
  data.deleteAblePost = {
   index: null,
   slug: null,
  };
 };

 const deletePost = () => {
  store.dispatch("post/deletePost", data.deleteAblePost);
  data.deleteDialogPost = false;
  data.deleteAblePost = {
   index: null,
   slug: null,
  };
 };

 const fetchAllPosts = () => store.dispatch("post/fetchAllPosts");

 return {
  ...toRefs(data),
  openDeleteDialogPost,
  closeDeleteDialogPost,
  deletePost,
  fetchAllPosts,
 };
}
