<template>
 <v-container
  fluid
  class="pa-0 ma-0  d-flex flex-column "
  :class="$vuetify.breakpoint.mdAndUp ? 'h-100' : ''"
 >
  <v-row class="ma-0">
   <auth-banner md="4" />
   <v-col
    cols="12"
    md="8"
    class="d-flex flex-column align-center justify-center py-10"
   >
    <h3 class="blue--text text--darken-3">
     به ویرگول خوش آمدید . اینجا شروع دوران جدید شماست.
    </h3>
    <p class="body-2 grey--text text--darken-3 mt-3">
     برای اتمام مراحل ثبت نام به ایمیل خود مراجعه کرده و بر روی لینک فعال سازی
     ارسال شده کلیک کنید.
    </p>
    <br />
    <v-btn
     @click="$router.push({ name: 'home' })"
     color="blue darken-3 "
     class="px-6 mr-auto"
     dark
     rounded
    >
     ورود به صفحه اصلی
     <v-icon>mdi-chevron-left</v-icon>
    </v-btn>
   </v-col>
  </v-row>
 </v-container>
</template>

<script>
import AuthBanner from "../../components/Auth/AuthBanner.vue";

export default {
 name: "Verify",
 metaInfo: {
  title: "تایید ایمیل - ویرگول",
 },
 components: { AuthBanner },
};
</script>

<style></style>
