<template>
 <v-col
  cols="12"
  :md="md"
  class="gra-bg d-flex flex-column align-center justify-center"
 >
  <v-img src="/logo-bg.svg" max-height="100px"> </v-img>
  <h3 class="white--text my-2">اینجا هر کسی می‌تونه بنویسه!</h3>
  <small class="hidden-md-and-down">
   همین حالا حساب کاربری خودت را بساز و دوران جدید وبلاگ نویسی را شروع کن.
  </small>
  <div class="mt-6">
   <v-btn  @click="$router.push({name:'home'})">
       <v-icon>
           mdi-home
       </v-icon>
       صفحه اصلی
   </v-btn>
  </div>
 </v-col>
</template>

<script>
export default {
 name: "AuthBanner",

 props: {
  md: {
   type: Number,
   default: 8,
  },
 },
};
</script>

<style></style>
