<template>
 <div class="my-8">
  <v-card class="mx-auto" elevation="1">
   <div class="d-flex">
    <v-list-item>
     <v-list-item-avatar>
      <v-img :src="comment.user.profile_src"> </v-img>
     </v-list-item-avatar>

     <v-list-item-content>
      <v-list-item-title>
       {{ comment.user.name }}
      </v-list-item-title>

      <v-list-item-subtitle>
       {{ moment(comment.created_at).fromNow() }}
      </v-list-item-subtitle>
     </v-list-item-content>
    </v-list-item>
    <v-spacer></v-spacer>
    <v-icon
     v-if="canShowDeleteOrUpdate"
     @click="deleteComment"
     style="cursor: pointer"
     class="ml-3"
    >
     mdi-delete
    </v-icon>
    <v-icon
     v-if="canShowDeleteOrUpdate"
     @click="showUpdateTextarea"
     style="cursor: pointer"
     class="ml-3"
    >
     mdi-file-document-edit
    </v-icon>
    <v-icon
     v-if="$store.state.user.isLogin"
     style="cursor: pointer"
     class="ml-4"
     @click="showReplyTextarea"
    >
     mdi-undo
    </v-icon>
   </div>
   <!-- <v-divider></v-divider> -->
   <v-card-text>
    {{ comment.content }}
   </v-card-text>
  </v-card>
  <div class="my-4" v-if="showReply || showUpdate">
   <template v-if="$store.state.user.isLogin">
    <v-textarea
     label="پاسخ خود را بنویسد..."
     filled
     v-model="reply.content"
    ></v-textarea>
    <div class="d-flex">
     <v-spacer></v-spacer>
     <v-btn class="ml-2 info" @click="cancelReply"> لغو </v-btn>
     <v-btn color="success" @click="saveComment"> ارسال پاسخ </v-btn>
    </div>
   </template>
  </div>
  <post-comment
   v-for="commentItem in comment.replies"
   :key="commentItem.id"
   :data="commentItem"
   class="mr-4"
  ></post-comment>
 </div>
</template>

<script>
import moment from "moment-jalaali";
import { computed, reactive, ref } from "@vue/composition-api";
import EventBus from "../../Service/EventBus";
moment.loadPersian({
 usePersianDigits: true,
});
export default {
 name: "PostComment",
 props: {
  data: {
   type: Object,
  },
 },

 setup(props, { root, emit }) {
  const reply = ref({
   content: "",
   comment_id: props.data.id,
  });

  const showReply = ref(false);
  const showUpdate = ref(false);

  const comment = ref(props.data);

  // computed

  const canShowDeleteOrUpdate = computed(() => {
   return (
    root.$store.state.user.isLogin &&
    root.$store.state.user.user.id == comment.value.user_id
   );
  });

  // created hook

  Echo.channel(`v_reply_${props.data.id}`).listen(
   ".reply.created",
   (e) => {
    let index = comment.value.replies.find((c) => c.id == e.reply.id);
    if (index == undefined) {
     comment.value.replies.push(e.reply);
     EventBus.$emit("comment_created");
    }
   }
  );

  Echo.channel(`v_comment_deleted_${props.data.id}`).listen(
   ".comment.deleted",
   (e) => {
    comment.value.replies = comment.value.replies.filter(
     (c) => c.id !== e.comment.id
    );
    EventBus.$emit("comment_deleted", e.comment.replies.length);
    // let myComments = comment.value.replies.filter((c) => c.id !== e.comment.id);
    // comment.value.replies = {};
    // setTimeout(() => {
    //  comment.value.replies = myComments;
    //  EventBus.$emit("comment_deleted", e.comment.replies.length);
    // }, 1);
   }
  );

  // methods
  const saveReply = () => {
   axios
    .post(`/api/replies/${root.$route.params.slug}`, reply.value)
    .then((result) => {
     cancelReply();
    })
    .catch(({ response }) => {
     EventBus.$emit("error", response.data.errors.content[0]);
    });
  };

  const updateComment = () => {
   axios
    .patch(`/api/comments/${comment.value.id}`, reply.value)
    .then(({ data }) => {
     comment.value.content = data.content;

     cancelReply();
    })
    .catch(({ response }) => {
     EventBus.$emit("error", response.data.errors.content[0]);
    });
  };

  const cancelReply = () => {
   showReply.value = false;
   showUpdate.value = false;
   reply.value.content = "";
  };

  const deleteComment = () => {
   axios.delete(`/api/comments/${comment.value.id}`);
  };

  const showUpdateTextarea = () => {
   showUpdate.value = true;
   showReply.value = false;
   reply.value.content = comment.value.content;
  };

  const showReplyTextarea = () => {
   showUpdate.value = false;
   showReply.value = true;
   reply.value.content = "";
  };

  const saveComment = () => {
   if (showReply.value == true) {
    saveReply();
   } else if (showUpdate.value == true) {
    updateComment();
   }
  };

  return {
   moment,
   comment,
   reply,
   saveReply,
   showReply,
   cancelReply,
   canShowDeleteOrUpdate,
   deleteComment,
   showUpdate,
   showUpdateTextarea,
   showReplyTextarea,
   saveComment,
  };
 },
};
</script>

<style></style>
