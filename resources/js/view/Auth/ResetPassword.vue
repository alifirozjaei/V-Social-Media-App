<template>
 <v-container
  fluid
  class="pa-0 ma-0  d-flex flex-column "
  :class="$vuetify.breakpoint.mdAndUp ? 'h-100' : ''"
 >
  <v-row class="ma-0">
   <auth-banner />
   <v-col cols="12" md="4" class="d-flex align-center ">
    <template>
     <v-form ref="formRef" class="w-100">
      <h5 class="info--text my-3">
       رمز عبور جدید خود را وارد کنید
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
      <v-text-field
       v-model="form.password"
       :rules="passwordRules"
       :error-messages="errors.password"
       type="password"
       label="رمز عبور"
       outlined
       rounded
       class=" my-0"
      >
      </v-text-field>

      <v-text-field
       v-model="form.password_confirmation"
       :rules="passwordRules"
       :error-messages="errors.password_confirmation"
       type="password"
       label="تکرار رمز عبور"
       outlined
       rounded
       class=" my-0"
      >
      </v-text-field>

      <div class="d-flex align-center">
       <v-spacer></v-spacer>
       <v-btn @click="changePassword" color="info" class="px-6" rounded>
        <template v-if="loading">
         <v-progress-circular color="white" :indeterminate="true">
         </v-progress-circular>
        </template>
        <template v-else>
         تغییر رمز عبور
         <v-icon>mdi-chevron-left</v-icon>
        </template>
       </v-btn>
      </div>
     </v-form>
    </template>
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
  title: "صفحه تغییر رمز عبور - ویرگول",
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
      errors.value.email = err.response.data.errors.email[0];
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
