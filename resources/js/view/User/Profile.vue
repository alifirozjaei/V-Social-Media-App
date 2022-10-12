<template>
 <v-main :class="$vuetify.breakpoint.mdAndDown ? 'my-10 py-10' : 'mt-10 pt-10 pb-3'">
  <v-container v-if="user">
   <v-row align="center" justify="center" class="d-flex flex-column">
    <v-col cols="12" md="8" class="mx-auto">
     <v-form ref="profileForm">
      <!-- user profile -->
      <div class="d-flex flex-row">
       <!-- user profile image -->
       <v-avatar size="80px">
        <v-img
         :src="user.profile_src || '/images/avatar1.jpg'"
         @click="$refs.profileImg.click()"
        >
        </v-img>
        <input
         type="file"
         class="d-none"
         ref="profileImg"
         @change="uploadProfile"
        />
       </v-avatar>
       <!-- user profile image -->

       <!-- user profile detail -->
       <div class="d-flex flex-column mr-5 w-100">
        <!-- user name -->
        <v-text-field
         label="نام"
         v-model="user.name"
         :rules="[required('فیلد نام الزامی است!')]"
        ></v-text-field>

        <!-- user bio -->
        <v-textarea label="بیوگرافی" v-model="user.bio"></v-textarea>
       </div>
       <!-- user profile detail -->
      </div>
      <v-divider class="my-5"></v-divider>

      <!-- user account config -->
      <div>
       <h3 class="blue--text my-5">
        تنظیمات حساب کاربری
       </h3>
       <!-- username -->
       <div class="d-flex flex-row align-center ">
        <div class="d-flex flex-column">
         <span>
          نام کاربری
         </span>
         <div>
          <v-btn
           rounded
           outlined
           small
           class="mt-3"
           @click="changeEdit('username')"
           :color="editing.username ? 'success' : 'blue darken-3'"
          >
           {{ editing.username ? "ثبت " : "ویرایش" }}
          </v-btn>

          <v-btn
           rounded
           outlined
           small
           class="mt-3"
           color="error"
           @click="cancel('username')"
           v-show="editing.username"
          >
           منصرف شدن
          </v-btn>
         </div>
        </div>
        <v-spacer> </v-spacer>
        <template v-if="!editing.username">
         <span>{{ fullUsername }}</span>
        </template>
        <template v-else>
         <v-text-field
          class="ltr"
          :prefix="url"
          v-model="user.username"
          :rules="[required('فیلد نام کاربری الزامی است!'), verifyUsername()]"
          :error="errors.username"
         ></v-text-field>
        </template>
       </div>
       <v-divider class="my-3"></v-divider>

       <!-- email -->
       <div class="d-flex flex-row align-center ">
        <div class="d-flex flex-column">
         <span>
          ایمیل
         </span>
         <!-- Edit button -->
         <div>
          <v-btn
           rounded
           outlined
           small
           class="mt-3"
           @click="changeEdit('email')"
           :color="editing.email ? 'success' : 'blue darken-3'"
          >
           {{ editing.email ? "ثبت " : "ویرایش" }}
          </v-btn>

          <v-btn
           rounded
           outlined
           small
           class="mt-3"
           color="error"
           @click="cancel('email')"
           v-show="editing.email"
          >
           منصرف شدن
          </v-btn>
         </div>
        </div>
        <v-spacer> </v-spacer>
        <template v-if="!editing.email">
         <span>{{ user.email }}</span>
        </template>
        <template v-else>
         <v-text-field
          class="ltr"
          v-model="user.email"
          :rules="[required('فیلد ایمیل الزامی است!'), verifyEmail()]"
          :error="errors.email"
         ></v-text-field>
        </template>
       </div>
       <v-divider class="my-3"></v-divider>

       <!-- password -->
       <div class="d-flex flex-row align-center ">
        <div class="d-flex flex-column">
         <span>
          تغییر رمز عبور
         </span>
        </div>
        <v-spacer> </v-spacer>
        <template>
         <v-text-field
          class="ltr"
          v-model="user.password"
          :rules="[moreThan(8, 'رمز عبور', true)]"
         ></v-text-field>
        </template>
       </div>
       <v-divider class="my-3"></v-divider>

       <!-- email nitification for follow -->
       <div class="d-flex flex-row align-center ">
        <span>
         ارسال ایمیل هنگام دنبال کردن
        </span>
        <v-spacer> </v-spacer>
        <v-switch v-model="user.email_on_follow"></v-switch>
       </div>
       <v-divider class="my-3"></v-divider>

       <!-- email nitification for like -->
       <div class="d-flex flex-row align-center ">
        <span>
         ارسال ایمیل هنگام لایک کردن
        </span>
        <v-spacer> </v-spacer>
        <v-switch v-model="user.email_on_like"></v-switch>
       </div>
       <v-divider class="my-3"></v-divider>

       <!-- email nitification for reply -->
       <div class="d-flex flex-row align-center ">
        <span>
         ارسال ایمیل هنگام جواب دادن
        </span>
        <v-spacer> </v-spacer>
        <v-switch v-model="user.email_on_reply"></v-switch>
       </div>

       <v-btn
        class="my-3 darken-4"
        block
        color="blue"
        rounded
        outlined
        @click="update"
       >
        <v-progress-circular
         v-if="loading"
         :width="3"
         color="blue "
         indeterminate
        ></v-progress-circular>
        <span v-else>
         ذخیره
        </span>
       </v-btn>
      </div>
      <!-- user account config -->
     </v-form>
    </v-col>
   </v-row>
  </v-container>
 </v-main>
</template>

<script>
import profileModule from "../../module/user/profileModule";
export default {
 name: "Profile",
 metaInfo: {
  title: "پروفایل من",
 },

 setup(props, context) {
  return {
   ...profileModule(),
  };
 },
};
</script>

<style></style>
