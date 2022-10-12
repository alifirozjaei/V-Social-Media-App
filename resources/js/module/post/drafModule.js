import { computed, reactive, toRefs } from "@vue/composition-api";
import store from "../../store/index";
export default function draftModule() {
 const data = reactive({
  deleteDialogDraft: false,
  deleteAbleDraft: { index: null, link: null },

  drafts: computed(() => store.state.draft.drafts),

  drafts_count: computed(() => store.state.draft.drafts_count),
 });

 const openDeleteDialogDraft = (index, link) => {
  data.deleteDialogDraft = true;
  data.deleteAbleDraft = {
   index,
   link,
  };
 };

 const closeDeleteDialogDraft = () => {
  data.deleteDialogDraft = false;
  data.deleteAbleDraft = {
   index: null,
   link: null,
  };
 };

 const deleteDraft = () => {
  store.dispatch("draft/deleteDraft", data.deleteAbleDraft);
  data.deleteDialogDraft = false;
  data.deleteAbleDraft = {
   index: null,
   link: null,
  };
 };

 const fetchAllDrafts = () => store.dispatch("draft/fetchAllDrafts");



 return {
  ...toRefs(data),
  openDeleteDialogDraft,
  closeDeleteDialogDraft,
  deleteDraft,
  fetchAllDrafts,
 };
}
