<template>
 <v-container
  fluid
  class="pa-0 ma-0  d-flex flex-column "
  :class="$vuetify.breakpoint.mdAndUp ? 'h-100' : ''"
 >
  <v-row class="ma-0">
   <auth-banner />
   <v-col cols="12" md="4" class="d-flex align-end ">
    <v-form ref="loginForm" class="w-100">
     <h5 class="info--text my-3">ورود به حساب کاربری</h5>
     <v-text-field
      v-model="form.email"
      :rules="emailRules"
      :error-messages="errors.email"
      label="نام کاربری یا ایمیل"
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
     <div class="d-flex align-center">
      <router-link :to="{ name: 'reset-email-password' }"
       >فراموشی رمز عبور</router-link
      >
      <v-spacer></v-spacer>
      <v-btn @click="login" color="info" class="px-6" rounded>
       <template v-if="loading">
        <v-progress-circular color="white" :indeterminate="true">
        </v-progress-circular>
       </template>
       <template v-else>
        ورود به حساب کاربری
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
      
     </div>
    </v-form>
   </v-col>
  </v-row>
 </v-container>
</template>

<script>
import AuthBanner from "../../components/Auth/AuthBanner.vue";
import { loginModule } from "../../module/auth/loginModule.js";
export default {
 components: { AuthBanner },
 name: "Login",
 metaInfo: {
  title: "صفحه ورود - ویرگول",
 },

 setup() {
  return {
   ...loginModule(),
  };
 },
};
</script>

<style>
.gra-bg {
 background-image: linear-gradient(to bottom right, #054592 0, #1897d4);
}
.h-100 {
 height: 100%;
}
</style>
