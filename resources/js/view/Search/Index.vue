<template>
 <v-main>
  <v-container
   :class="$vuetify.breakpoint.mdAndDown ? 'my-10 py-10' : 'mt-10 pt-10 pb-3'"
  >
   <v-row>
    <v-col cols="12" class="mx-auto my-2">
     <v-text-field
      label="جستجو در پست ها ، کاربران ، دسته ها و ..."
      v-model="search"
      @keyup="pushToSearh"
     >
     </v-text-field>

     <!-- Tab Menu -->
     <v-tabs v-model="activeTab" grow>
      <v-tab href="#posts" @click.stop="goTo('posts')"> پست ها</v-tab>
      <v-tab href="#users" @click.stop="goTo('users')"> کاربران</v-tab>
      <v-tab href="#categories" @click.stop="goTo('categories')"
       >دسته بندی ها
      </v-tab>
      <v-tab href="#no-content" style="display:none"> no-content</v-tab>
     </v-tabs>

     <!-- Tab content -->
     <v-tabs-items v-model="activeTab">
      <!-- posts -->
      <v-tab-item value="posts">
       <v-row
        v-if="posts"
        class="py-4"
        :class="$vuetify.theme.dark ? 'custom-dark' : 'grey lighten-4'"
       >
        <v-col cols="12" md="6" v-for="post in posts.data" :key="post.id">
         <new-post style="height:100%" :data="post" :showuser="true"></new-post>
        </v-col>

        <v-col
         v-if="!!posts.next_page_url"
         cols="12"
         class="mx-auto d-flex my-6"
        >
         <v-spacer></v-spacer>
         <v-btn
          @click="fetchPost"
          v-if="!!posts.next_page_url"
          color="info"
          class="px-6"
          rounded
         >
          بیشتر
          <v-icon>mdi-chevron-left</v-icon>
         </v-btn>
        </v-col>

        <!-- not found posts message -->
        <v-col cols="12" class="pa-5" v-if="!posts.to">
         <v-alert class="d-flex justify-center" elevation="0">
          پستی برای نمایش وجود ندارد !!!
         </v-alert>
        </v-col>
       </v-row>
       <template v-else>
        <v-card class="pa-5 d-flex justify-center">
         درحال دریافت اطلاعات ...
        </v-card>
       </template>
      </v-tab-item>
      <!-- users -->
      <v-tab-item value="users">
       <v-row
        v-if="users"
        class="py-4"
        :class="$vuetify.theme.dark ? 'custom-dark' : 'grey lighten-4'"
       >
        <!-- show find users -->
        <v-col cols="12" md="6" v-for="user in users.data" :key="user.id">
         <v-card :elevation="0">
          <v-list-item>
           <v-list-item-avatar
            style="cursor:pointer"
            @click="
             $router.push({
              name: 'user-posts',
              params: { username: user.username },
             })
            "
           >
            <v-img :src="user.profile_src"></v-img>
           </v-list-item-avatar>
           <v-list-item-content class="d-flex flex-column align-start">
            <div>
             <router-link
              style="cursor:pointer"
              :to="{
               name: 'user-posts',
               params: { username: user.username },
              }"
             >
              {{ user.name }}
             </router-link>
            </div>
            <div class="small-text">
             {{ user.username }}
             {{ user.bio ? ` | ${user.bio}` : "" }}
            </div>
           </v-list-item-content>
           <v-list-item-action v-if="$store.state.user.isLogin">
            <template v-if="$store.state.user.user.id != user.id">
             <v-btn
              small
              :color="user.is_follow ? 'blue darken-2' : 'grey darken-2'"
              rounded
              dark
              @click="followUser(user)"
             >
              {{ user.is_follow ? "دنبال میکنید" : "دنبال کنید" }}
             </v-btn>
            </template>
           </v-list-item-action>
          </v-list-item>
         </v-card>
        </v-col>

        <!-- button -> fetch new user from server  -->
        <v-col
         v-if="!!users.next_page_url"
         cols="12"
         class="mx-auto d-flex my-6"
        >
         <v-spacer></v-spacer>
         <v-btn
          @click="fetchPost"
          v-if="!!users.next_page_url"
          color="info"
          class="px-6"
          rounded
         >
          بیشتر
          <v-icon>mdi-chevron-left</v-icon>
         </v-btn>
        </v-col>

        <!-- not found user message -->
        <v-col cols="12" class="pa-5 " v-if="!users.to">
         <v-alert class="d-flex justify-center" elevation="0">
          کاربری برای نمایش وجود ندارد !!!
         </v-alert>
        </v-col>
       </v-row>
       <template v-else>
        <v-card class="pa-5 d-flex justify-center">
         درحال دریافت اطلاعات ...
        </v-card>
       </template>
      </v-tab-item>
      <!-- categories -->
      <v-tab-item value="categories">
       <v-row
        v-if="categories"
        class="py-4"
        :class="$vuetify.theme.dark ? 'custom-dark' : 'grey lighten-4'"
       >
        <v-col cols="12">
         <v-btn
          v-for="category in categories.data"
          :key="category.id"
          @click="
           $router.push({
            name: 'post-category',
            params: { slug: category.slug },
           })
          "
          text
          class="mx-2"
         >
          {{ category.title }}
         </v-btn>
        </v-col>

        <v-col
         v-if="!!categories.next_page_url"
         cols="12"
         class="mx-auto d-flex my-6"
        >
         <v-spacer></v-spacer>
         <v-btn
          @click="fetchPost"
          v-if="!!categories.next_page_url"
          color="info"
          class="px-6"
          rounded
         >
          بیشتر
          <v-icon>mdi-chevron-left</v-icon>
         </v-btn>
        </v-col>
        <v-col cols="12" class="pa-5 center" v-if="!categories.to">
         <v-alert class="d-flex justify-center" elevation="0">
          دسته بندی برای نمایش وجود ندارد !!!
         </v-alert>
        </v-col>
       </v-row>
       <template v-else>
        <v-card class="pa-5 d-flex justify-center">
         درحال دریافت اطلاعات ...
        </v-card>
       </template>
      </v-tab-item>
      <!-- not content q query -->
      <v-tab-item value="no-content">
       <v-card class="pa-5 d-flex justify-center">
        متنی برای جستجو وجود ندارد!!!
       </v-card>
      </v-tab-item>
     </v-tabs-items>
    </v-col>
   </v-row>
  </v-container>
 </v-main>
</template>

<script>
import { ref } from "@vue/composition-api";
import NewPost from "../../components/post/NewPost.vue";
import { debounce } from "lodash";
export default {
 components: { NewPost },
 name: "Index",
 metaInfo: {
  title: "جستجو",
 },

 setup(props, context) {
  // state
  const search = ref(context.root.$route.query.q);
  const activeTab = ref(context.root.$route.params.type);
  const posts = ref(null);
  const users = ref(null);
  const categories = ref(null);

  // created hook
  const pagetype = context.root.$route.params.type;
  if (pagetype != "posts" && pagetype != "users" && pagetype != "categories") {
   context.root.$router.push({ name: "not-found" });
  }

  if (search.value == "") {
   activeTab.value = "no-content";
  }

  const getItem = () => {
   if (activeTab.value != "not-content" && search.value.trim() != "") {
    axios
     .get(`/api/search/${activeTab.value}/${search.value}`)
     .then(({ data }) => {
      if (activeTab.value == "posts") {
       posts.value = data.posts;
      } else if (activeTab.value == "users") {
       users.value = data.users;
      } else if (activeTab.value == "categories") {
       categories.value = data.categories;
      }
     });
   }
  };

  getItem();

  // methdos
  const goTo = (type) => {
   context.root.$router.push({
    name: "search",
    params: {
     type: type,
    },
    query: {
     q: search.value,
    },
   });
  };

  const fetchPost = () => {
   if (activeTab.value == "posts") {
    axios.get(posts.value.next_page_url).then(({ data }) => {
     posts.value.data.push(...data.posts.data);
     posts.value.next_page_url = data.posts.next_page_url;
    });
   } else if (activeTab.value == "users") {
    axios.get(users.value.next_page_url).then(({ data }) => {
     users.value.data.push(...data.users.data);
     users.value.next_page_url = data.users.next_page_url;
    });
   } else if (activeTab.value == "categories") {
    axios.get(categories.value.next_page_url).then(({ data }) => {
     categories.value.data.push(...data.categories.data);
     categories.value.next_page_url = data.categories.next_page_url;
    });
   }
  };

  const pushToSearh = debounce(() => {
   //    context.root.$router.push({
   //     name: "search",
   //     params: {
   //      type: context.root.$route.params.type,
   //     },
   //     query: {
   //      q: search.value,
   //     },
   //    });
   getItem();
  }, 1000);

  const followUser = (user) => {
   axios.post(`/api/follows/${user.username}`).then(() => {
    user.is_follow = !user.is_follow;
   });
  };

  return {
   search,
   activeTab,
   posts,
   users,
   categories,
   goTo,
   fetchPost,
   pushToSearh,
   followUser,
  };
 },
};
</script>

<style></style>
