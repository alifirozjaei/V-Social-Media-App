<template>
 <v-dialog v-model="imageModal" max-width="360px">
  <v-card>
   <v-card-title>
    عکس خود را اپلود کنید
   </v-card-title>
   <vue-dropzone
    ref="myVueDropzone"
    id="dropzone"
    :options="dropzoneOptions"
    @vdropzone-success="upload"
   ></vue-dropzone>
   <v-card-actions>
    <v-spacer></v-spacer>
    <v-btn @click="imageModal = false">
     <v-icon class="error--text">
      mdi-close
     </v-icon>
    </v-btn>
   </v-card-actions>
  </v-card>
 </v-dialog>
</template>

<script>
import vue2Dropzone from "vue2-dropzone";
import "vue2-dropzone/dist/vue2Dropzone.min.css";
import { ref } from "@vue/composition-api";
export default {
 name: "DropZoneModal",
 components: {
  vueDropzone: vue2Dropzone,
 },

 setup(props, context) {
  const myVueDropzone = ref(null);
  const imageModal = ref(false);
  const dropzoneOptions = ref({
   url: "/api/upload-post-image",
   maxFilesize: 1,
   headers: {
    "X-CSRF-TOKEN": window.csrf_token,
   },
  });

  const showModal = () => {
   imageModal.value = true;
  };

  const upload = (file, response) => {
   context.emit("upload", response);
   imageModal.value = false;
   myVueDropzone.value.removeFile(file);
  };

  return {
   imageModal,
   dropzoneOptions,
   myVueDropzone,
   showModal,
   upload,
  };
 },
};
</script>

<style></style>
