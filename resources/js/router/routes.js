export default [
 // view with frontlayout
 {
  path: "/",
  component: require("../view/Layout/FrontLayout.vue").default,
  children: [
   // home paga
   {
    path: "",
    name: "home",
    component: require("../view/Home.vue").default,
   },

   // show post
   {
    path: "post/:slug",
    name: "post-show",
    component: require("../view/Post/PostShow.vue").default,
   },

   // show login user draft and posts
   {
    path: "posts/draft",
    name: "my-posts",
    component: require("../view/Post/MyPosts.vue").default,
    meta: {
     auth: true,
     verified: true,
    },
   },

   //  create new posts
   {
    path: "posts/create",
    name: "create-post",
    component: require("../view/Post/Create.vue").default,
    meta: {
     auth: true,
     verified: true,
    },
   },

   // edit published post content and title
   {
    path: "posts/:slug",
    name: "edit-post",
    component: require("../view/Post/Edit.vue").default,
    meta: {
     auth: true,
     verified: true,
    },
   },

   // edit draft content and title
   {
    path: "drafts/:link",
    name: "update-draft",
    component: require("../view/Post/Create.vue").default,
    meta: {
     auth: true,
     verified: true,
    },
   },

   // save draft and set categories ,description, image (save new post)
   {
    path: "drafts/:link/save",
    name: "save-post",
    component: require("../view/Post/SavePost.vue").default,
    meta: {
     auth: true,
     verified: true,
    },
   },

   // update published post and set new categories, description , image
   {
    path: "posts/:slug/update",
    name: "update-post",
    component: require("../view/Post/UpdatePost.vue").default,
    meta: {
     auth: true,
     verified: true,
    },
   },

   // show posts in category
   {
    path: "posts/category/:slug",
    name: "post-category",
    component: require("../view/Post/PostCategory.vue").default,
    meta: {
     auth: true,
     verified: true,
    },
   },

   {
    path: "user/following/posts",
    name: "user-following-posts",
    component: require("../view/User/UserFollowingsPosts.vue").default,
    meta: {
     auth: true,
     verified: true,
    },
   },

   // edit login user profile
   {
    path: "profile",
    name: "profile",
    component: require("../view/User/Profile.vue").default,
    meta: {
     auth: true,
     verified: true,
    },
   },

   // show login user liked posts
   {
    path: "liked",
    name: "liked-post",
    component: require("../view/User/UserLikedPost.vue").default,
    meta: {
     auth: true,
     verified: true,
    },
   },

   // show login user bookmarked posts
   {
    path: "bookmarked",
    name: "bookmarked-post",
    component: require("../view/User/UserBookmarkedPost.vue").default,
    meta: {
     auth: true,
     verified: true,
    },
   },

   // show user profile and posts (followers, following)
   {
    path: "@:username",
    name: "user-posts",
    component: require("../view/User/UserPost.vue").default,
   },

   // serach between post, user, category
   {
    path: "/search/:type",
    name: "search",
    component: require("../view/Search/Index.vue").default,
   },
  ],
 },

 {
  path: "/admin",
  component: require("../view/Layout/AdminLayout.vue").default,
  children: [
   {
    path: "dashboard",
    name: "dashboard",
    component: require("../view/Admin/Dashboard.vue").default,
   },
  ],
 },

 // login page
 {
  path: "/login",
  name: "login",
  component: require("../view/Auth/Login2.vue").default,
  meta: {
   guest: true,
  },
 },

 // register page
 {
  path: "/register",
  name: "register",
  component: require("../view/Auth/Register2.vue").default,
  meta: {
   guest: true,
  },
 },

 // verify page
 {
  path: "/verify",
  name: "verify",
  component: require("../view/Auth/Verify2.vue").default,
  meta: {
   auth: true,
  },
 },

 // password reser page
 {
  path: "/password/reset",
  name: "reset-email-password",
  component: require("../view/Auth/ResetEmailPassword2.vue").default,
  meta: {
   guest: true,
  },
 },

 // set new password for reset password
 {
  path: "/password/reset/:token",
  name: "reset-password",
  component: require("../view/Auth/ResetPassword2.vue").default,
  meta: {
   guest: true,
  },
 },

 // 404 paga
 {
  path: "/404",
  name: "not-found",
  component: require("../view/Error/NotFound.vue").default,
 },

 // 403 page
 {
  path: "/403",
  name: "access-denied",
  component: require("../view/Error/AccessDenied.vue").default,
 },

 {
  path: "*",
  component: require("../view/Error/NotFound.vue").default,
  redirect: "404",
 },
];
