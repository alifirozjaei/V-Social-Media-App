<template>
 <v-container
  fluid
  class="pa-0 ma-0  d-flex flex-column "
  :class="$vuetify.theme.dark ? '' : 'grey lighten-4'"
  style="min-height: 100vh;"
 >
  <v-row class="ma-0">
   <v-col
    cols="12"
    md="8"
    class="d-flex mx-auto flex-column align-center justify-center py-10"
   >
    <template v-if="!sended">
     <v-form ref="formRef" class="w-100">
      <h5 class="info--text my-3">
       برای بازیابی رمز عبور ایمیل خود را وارد کنید
      </h5>
      <v-text-field
       v-model="form.email"
       :rules="emailRules"
       :error-messages="errors.email"
       label=" ایمیل"
       outlined
       rounded
       class="mt-6 mb-0"
      >
      </v-text-field>
      <div class="d-flex align-center">
       <v-spacer></v-spacer>
       <v-btn
        @click="sendEmail"
        color="info"
        class="px-6"
        rounded
        :disabled="loading"
       >
        <template v-if="loading">
         <v-progress-circular color="white" :indeterminate="true">
         </v-progress-circular>
        </template>
        <template v-else>
         ارسال ایمیل بازیابی
         <v-icon>mdi-chevron-left</v-icon>
        </template>
       </v-btn>
      </div>
      <br />
      <router-link :to="{ name: 'home' }">
       بازگشت به صفحه اصلی
      </router-link>
     </v-form>
    </template>
    <template v-else>
     <div class="text-center">
      <v-alert type="success">
       ایمیل بازنشانی رمز عبور با موفقیت ارسال شد.
      </v-alert>
      <router-link :to="{ name: 'home' }">
       بازگشت به صفحه اصلی
      </router-link>
     </div>
    </template>
   </v-col>
  </v-row>
 </v-container>
</template>

<script>
import AuthBanner from "../../components/Auth/AuthBanner.vue";
import { required, verifyEmail } from "../../rule/index";
import { ref } from "@vue/composition-api";
export default {
 components: { AuthBanner },
 name: "ResetPasswordEmail",
 metaInfo: {
  title: "صفحه بازیابی رمز عبور - ویرگول",
 },
 setup(props, context) {
  const emailRules = ref([required("ایمیل الزامی است !"), verifyEmail()]);

  const form = ref({
   email: null,
  });

  const errors = ref({
   email: null,
  });

  const loading = ref(false);

  const sended = ref(false);

  //   const ResetPassword = ref(null);

  function sendEmail() {
   if (context.refs.formRef.validate()) {
    loading.value = true;
    context.root.$store
     .dispatch("user/sendResetPasswordEmail", form)
     .then(() => {
      errors.value.email = null;
      sended.value = true;
     })
     .catch((err) => {
      errors.value.email = err.response.data.errors.email[0];
     })
     .finally(() => {
      loading.value = false;
     });
   }
  }

  return { emailRules, form, errors, loading, sendEmail, sended };
 },
};
</script>

<style></style>
