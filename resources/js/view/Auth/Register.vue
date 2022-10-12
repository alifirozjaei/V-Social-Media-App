<template>
 <v-container
  fluid
  class="pa-0 ma-0  d-flex flex-column "
  :class="$vuetify.breakpoint.mdAndUp ? 'h-100' : ''"
 >
  <v-row class="ma-0">
   <auth-banner />
   <v-col cols="12" md="4" class="d-flex align-end ">
    <v-form ref="registerForm" class="w-100">
     <h5 class="info--text my-3">ایجاد حساب کاربری</h5>
     <v-text-field
      v-model="form.email"
      :rules="emailRules"
      :error-messages="errors.email"
      label="ایمیل"
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
     <div class="d-flex">
      <v-spacer></v-spacer>
      <v-btn @click="register" color="info" class="px-6" rounded>
       <template v-if="loading">
        <v-progress-circular color="white" :indeterminate="true">
        </v-progress-circular>
       </template>
       <template v-else>
        ایجاد حساب کاربری
        <v-icon>mdi-chevron-left</v-icon>
       </template>
      </v-btn>
     </div>
     <div class="text-center my-6">
      <!-- <p class="grey--text">
       ورود با اکانت
       <span class="red--text">
        گوگل
       </span>
      </p> -->
      <p class="grey--text my-3">
       ثبت نام در ویرگول به منزله موافقت با
       <b class="black--text"> قوانین</b>
       است
      </p>
      <router-link :to="{ name: 'login' }">
       قبلا عضو شده‌اید؟ رفتن به صفحه ورود
      </router-link>
     </div>
    </v-form>
   </v-col>
  </v-row>
 </v-container>
</template>

<script>
import AuthBanner from "../../components/Auth/AuthBanner.vue";

import { registerModule } from "../../module/auth/registerModule";

export default {
 name: "Register",
 metaInfo: {
  title: "صفحه ثبت نام - ویرگول",
 },
 components: { AuthBanner },

 setup(props, context) {
  return {
   ...registerModule(context.root),
  };
 },
};
</script>

<style>
.gra-bg {
 background-image: linear-gradient(to bottom right, #054592 0, #1897d4);
}
</style>
