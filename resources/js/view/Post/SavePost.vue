<template>
 <!-- save draft (save post) -->
 <v-main :class="$vuetify.breakpoint.mdAndDown ? 'my-10 py-10' : 'pt-10 mt-10 pb-3'">
  <v-container>
   <v-row>
    <v-col cols="12" md="6" class="mx-auto">
     <!-- upload image -->
     <p>
      عکس خود را آپلود کنید
     </p>
     <input type="file" @change="uploadImage" />
     <!-- show uploaded image -->
     <v-img max-height="200" v-if="form.image" :src="form.image"></v-img>

     <!--show draft title -->
     <p class="my-5">{{ form.title }}</p>

     <!-- get description for post -->
     <v-textarea v-model="form.description" label="توضیحات نوشته"></v-textarea>
    </v-col>

    <v-col cols="12" md="6">
     <!-- get categories of post-->
     <p>
      برای شناسایی بهتر نوشته تان دسته بندی ها را اضافه کنید
     </p>
     <v-combobox
      label="دسته بندی ها"
      v-model="form.categories"
      multiple
      chips
      append-icon=""
      hint="شما حداکثر پنچ دسته بندی میتوانید داشته باشید"
      persistent-hint
     >
     </v-combobox>
     <div class="d-flex">
      <v-spacer></v-spacer>
      <v-btn class="info mt-5" @click="sendForm">
       ذخیره
      </v-btn>
     </div>
    </v-col>
   </v-row>
   <!-- error snackbar -->
   <v-snackbar
    v-for="(error, index) in errors"
    :key="index"
    v-model="error.show"
    :timeout="0"
   >
    <div class="error--text d-flex align-center ">
     <span>{{ error.text }}</span>
     <v-spacer></v-spacer>
     <v-btn text color="error" @click.stop="error.show = false" class="mr-auto">
      X
     </v-btn>
    </div>
   </v-snackbar>
  </v-container>
 </v-main>
</template>

<script>
import { reactive, ref, watch } from "@vue/composition-api";
import uploadBase64 from "../../module/file/uploadBase64";

export default {
 name: "SavePost",
 metaInfo: {
  title: "ذخیزه پست",
 },

 setup(props, context) {
  //  form data
  const form = reactive({
   image: null,
   imageName: null,
   title: null,
   content: null,
   description: null,
   categories: [],
  });

  const errors = ref([]);

  // get draft data from vuex
  context.root.$store
   .dispatch("draft/getDraft", context.root.$route.params.link)
   .then((data) => {
    form.title = data.title;
    form.content = data.content;
   });

  // upload image
  const uploadImage = (event) => {
   form.imageName = event.target.files[0].name;
   form.image = uploadBase64(event);
  };

  const sendForm = () => {
   context.root.$store
    .dispatch("post/savePost", form)
    .then(({ data }) => {
     context.root.$router.push({
      name: "post-show",
      params: {
       slug: data.data.slug,
      },
     });
    })
    .catch(({ response }) => {
     Object.values(response.data.errors).forEach((e) => {
      errors.value.push({
       text: e[0],
       show: true,
      });
     });
    });
  };

  // check categories item count (if moreThan 5 delete item)
  watch(
   () => form.categories,
   (value) => {
    if (value.length > 5) {
     form.categories.pop();
    }
   }
  );

  return {
   form,
   uploadImage,
   sendForm,
   errors,
  };
 },
};
</script>

<style></style>
