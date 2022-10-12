<template>
 <v-img :src="data.image" height="250px" cover>
  <v-overlay absolute :value="true" class="d-flex align-end justify-start">
   <div class="pa-8 white--text text--darken-2">
    <h3>
     <router-link
      class="white--text"
      :to="{ name: 'post-show', params: { slug: data.slug } }"
     >
      {{ data.title }}
     </router-link>
    </h3>
    <v-row class="my-2 align-center">
     <router-link
      :to="{ name: 'user-posts', params: { username: data.user.username } }"
     >
      <v-avatar>
       <img :src="data.user.profile_src" />
      </v-avatar>
     </router-link>
     <div class="d-flex flex-column pa-2">
      <h4 class="mb-2">
       <router-link
        :to="{ name: 'user-posts', params: { username: data.user.username } }"
        class="white--text"
       >
        {{ data.user.name }}
       </router-link>
      </h4>
      <h6>{{ moment(data.created_at).fromNow() }}</h6>
     </div>
    </v-row>
   </div>
  </v-overlay>
 </v-img>
</template>

<script>
import moment from "moment-jalaali";
moment.loadPersian({
 usePersianDigits: true,
});
export default {
 name: "RelatedPost",
 props: ["data"],

 setup() {
  return {
   moment,
  };
 },
};
</script>

<style></style>
