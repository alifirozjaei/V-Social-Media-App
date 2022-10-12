<template>
 <v-container fluid class="gra-bg">
  <v-row style="min-height: 100vh;" class="justify-center align-center">
   <v-col cols="12" sm="8" md="5" lg="4">
    <v-form ref="loginForm" class="w-100">
     <v-card class="rounded-t-xl rounded-b-0">
      <v-card-text>
       <div class="text-center py-3">
        <h3><b>ورود به حساب کاربری</b></h3>
       </div>
       <v-divider></v-divider>
       <v-text-field
        v-model="form.email"
        :rules="emailRules"
        :error-messages="errors.email"
        label="نام کاربری یا ایمیل"
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
      </v-card-text>
      <v-card-actions class="d-felx justify-center">
       <v-btn @click="login" color="info" class="py-5" rounded block>
        <template v-if="loading">
         <v-progress-circular color="white" :indeterminate="true">
         </v-progress-circular>
        </template>
        <template v-else>
         ورود به حساب کاربری
         <v-icon>mdi-chevron-left</v-icon>
        </template>
       </v-btn>
      </v-card-actions>
      <v-card-actions class="text-center flex-column">
       <h5 class="py-1 mb-1">
        <router-link :to="{ name: 'reset-email-password' }">
         رمز عبور خود را فراموش کرده اید؟
        </router-link>
       </h5>
       <h5 class="py-1">
        <router-link :to="{ name: 'register' }">
         عضو نیستید؟ ثبت نام کنید
        </router-link>
       </h5>
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
import { loginModule } from "../../module/auth/loginModule.js";
export default {
 components: { AuthBanner },
 name: "Login",
 metaInfo: {
  title: "صفحه ورود",
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
