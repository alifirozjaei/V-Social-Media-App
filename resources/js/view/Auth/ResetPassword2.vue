<template>
 <v-container fluid class="gra-bg">
  <v-row style="min-height: 100vh;" class="justify-center align-center">
   <v-col cols="12" sm="8" md="5" lg="4">
    <v-form ref="formRef" class="w-100">
     <v-card class="rounded-t-xl rounded-b-0">
      <v-card-text>
       <div class="text-center">
        <h4 class="info--text my-3">
         رمز عبور جدید خود را وارد کنید
        </h4>
       </div>
       <v-text-field
        v-model="form.email"
        :rules="emailRules"
        :error-messages="errors.email"
        label=" ایمیل"
        outlined
        rounded
        prepend-inner-icon="mdi-account"
        class="mt-6 mb-0"
       />
       <v-text-field
        v-model="form.password"
        :rules="passwordRules"
        :error-messages="errors.password"
        type="password"
        label="رمز عبور"
        outlined
        rounded
        prepend-inner-icon="mdi-lock"
        class=" my-0"
       />
       <v-text-field
        v-model="form.password_confirmation"
        :rules="passwordRules"
        :error-messages="errors.password_confirmation"
        type="password"
        label="تکرار رمز عبور"
        outlined
        rounded
        prepend-inner-icon="mdi-lock"
        class=" my-0"
       />
      </v-card-text>
      <v-card-actions class="d-felx justify-center">
       <v-btn
        @click="changePassword"
        color="info"
        class="py-5 mb-3"
        rounded
        block
       >
        <template v-if="loading">
         <v-progress-circular color="white" :indeterminate="true">
         </v-progress-circular>
        </template>
        <template v-else>
         تغییر رمز عبور
         <v-icon>mdi-chevron-left</v-icon>
        </template>
       </v-btn>
      </v-card-actions>
     </v-card>
     <v-card class="mt-5 rounded-b-xl rounded-t-0">
      <v-card-actions class="d-flex justify-center">
       <v-btn @click="$router.push({ name: 'home' })" text class="py-5">
        <b>
         <v-icon>mdi-home</v-icon>
         صفحه اصلی
        </b>
       </v-btn>
      </v-card-actions>
     </v-card>
    </v-form>
   </v-col>
  </v-row>
 </v-container>
</template>

<script>
import AuthBanner from "../../components/Auth/AuthBanner.vue";
import { required, moreThan, verifyEmail } from "../../rule/index";
import { ref } from "@vue/composition-api";

export default {
 metaInfo: {
  title: " تغییر رمز عبور ",
 },
 components: { AuthBanner },
 name: "ResetPassword",
 setup(props, context) {
  const emailRules = ref([required("ایمیل الزامی است !"), verifyEmail()]);

  const passwordRules = ref([
   required("رمز عبور الزامی است !"),
   moreThan(8, "رمز عبور"),
  ]);

  const form = ref({
   token: context.root.$route.params.token,
   email: context.root.$route.query.email,
   password: null,
   password_confirmation: null,
  });

  const errors = ref({
   email: null,
   password: null,
   password_confirmation: null,
  });

  const loading = ref(false);

  const formRef = ref(null);

  function changePassword() {
   if (context.refs.formRef.validate()) {
    loading.value = true;
    context.root.$store
     .dispatch("user/resetPassword", form)
     .then(() => {
      context.root.$router.push({ name: "home" });
     })
     .catch((err) => {
      errors.value.email = null;
      errors.value.password = null;
      for (const i in err.response.data.errors) {
       errors.value[i] = err.response.data.errors[i][0];
      }
     })
     .finally(() => {
      loading.value = false;
     });
   }
  }

  return {
   emailRules,
   passwordRules,
   form,
   errors,
   loading,
   formRef,
   changePassword,
  };
 },
};
</script>

<style></style>
