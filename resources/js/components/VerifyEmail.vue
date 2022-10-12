<template>
 <v-system-bar height="50" app class="d-flex  justify-center py-5">
  <span class="font-weight-bold">
   شما ایمیل خود را تایید نکرده اید!
  </span>
  <v-btn
   text
   small
   @click="resendVerified"
   outlined
   rounded
   class="ma-5"
   :disabled="loading"
  >
   ارسال مجدد ایمیل تایید
  </v-btn>
  <span class="green--text" v-if="resend">
   ایمیل با موفقیت ارسال شد.
   <v-icon> mdi- </v-icon>
  </span>
 </v-system-bar>
</template>

<script>
import { ref } from "@vue/composition-api";
export default {
 name: "VerifyEmail",

 setup() {
  const resend = ref(false);
  const loading = ref(false);

  //resend verify email
  function resendVerified() {
   if (loading.value == false) {
    loading.value = true;
    axios
     .get("/api/email/resend")
     .then((res) => {
      resend.value = true;
     })
     .finally(() => {
      loading.value = false;
     });
   }
  }

  return {
   resend,
   loading,
   resendVerified,
  };
 },
};
</script>

<style></style>
